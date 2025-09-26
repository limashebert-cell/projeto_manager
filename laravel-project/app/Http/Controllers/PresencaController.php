<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenca;
use App\Models\Colaborador;
use App\Models\AuditoriaPresenca;
use App\Models\HistoricoPresenca;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresencaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(Request $request)
    {
        $data = $request->get('data', now()->format('Y-m-d'));
        $dataFormatada = Carbon::parse($data);
        
        // Buscar todos os colaboradores do usuário logado
        $colaboradores = Colaborador::where('admin_user_id', Auth::id())->get();
        
        // Buscar presenças já registradas para esta data
        $presencasExistentes = Presenca::where('admin_user_id', Auth::id())
            ->whereDate('data', $data)
            ->get()
            ->keyBy('colaborador_id');
        
        return view('admin.presencas.index', compact('colaboradores', 'presencasExistentes', 'data', 'dataFormatada'));
    }
    
    public function store(Request $request)
    {
        // Log para debugging
        \Log::info('=== PRESENCA STORE START ===', [
            'data' => $request->data,
            'presencas_count' => count($request->presencas ?? []),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'data' => 'required|date',
            'presencas' => 'required|array',
            'presencas.*.colaborador_id' => 'required|exists:colaboradores,id',
            'presencas.*.status' => 'required|in:presente,falta,atestado,banco_horas',
            'presencas.*.observacoes' => 'nullable|string|max:500'
        ]);
        
        $data = $request->data;
        $userId = Auth::id();
        
        // Buscar registros existentes (para histórico)
        $presencasExistentes = Presenca::where('admin_user_id', $userId)
            ->whereDate('data', $data)
            ->get()
            ->keyBy('colaborador_id');
        
        // Preparar dados para auditoria
        $dadosPresenca = [];
        $contadores = [
            'presente' => 0,
            'falta' => 0,
            'atestado' => 0,
            'banco_horas' => 0
        ];
        
        // Criar novos registros
        foreach ($request->presencas as $presencaData) {
            // Verificar se o colaborador pertence ao usuário logado
            $colaborador = Colaborador::where('id', $presencaData['colaborador_id'])
                ->where('admin_user_id', $userId)
                ->first();
                
            if ($colaborador) {
                $colaboradorId = $presencaData['colaborador_id'];
                $novoStatus = $presencaData['status'];
                $novaObservacao = $presencaData['observacoes'] ?? null;
                
                // Verificar se já existia um registro para este colaborador
                $registroExistente = $presencasExistentes->get($colaboradorId);
                
                // Criar ou atualizar registro de presença de forma manual
                $presencaExistente = Presenca::where('admin_user_id', $userId)
                    ->where('colaborador_id', $colaboradorId)
                    ->whereDate('data', $data)
                    ->first();
                
                if ($presencaExistente) {
                    // Atualizar registro existente
                    $presencaExistente->update([
                        'status' => $novoStatus,
                        'observacoes' => $novaObservacao
                    ]);
                } else {
                    // Criar novo registro
                    Presenca::create([
                        'admin_user_id' => $userId,
                        'colaborador_id' => $colaboradorId,
                        'data' => $data,
                        'status' => $novoStatus,
                        'observacoes' => $novaObservacao
                    ]);
                }
                
                // Criar registro no histórico
                $historico = HistoricoPresenca::create([
                    'admin_user_id' => $userId,
                    'colaborador_id' => $colaboradorId,
                    'data_presenca' => $data,
                    'status_anterior' => $registroExistente ? $registroExistente->status : null,
                    'status_novo' => $novoStatus,
                    'observacoes_anterior' => $registroExistente ? $registroExistente->observacoes : null,
                    'observacoes_nova' => $novaObservacao,
                    'acao' => $registroExistente ? 'editado' : 'criado',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'dados_completos' => [
                        'colaborador_nome' => $colaborador->nome,
                        'colaborador_prontuario' => $colaborador->prontuario,
                        'data_registro' => now()->toDateTimeString(),
                        'dados_request' => $presencaData
                    ]
                ]);

                // Log do histórico criado
                \Log::info('Histórico criado', [
                    'historico_id' => $historico->id,
                    'colaborador_id' => $colaboradorId,
                    'acao' => $registroExistente ? 'editado' : 'criado',
                    'status' => $novoStatus
                ]);
                
                // Preparar dados para auditoria
                $dadosPresenca[] = [
                    'colaborador_id' => $colaborador->id,
                    'colaborador_nome' => $colaborador->nome,
                    'status' => $novoStatus,
                    'observacoes' => $novaObservacao
                ];
                
                // Contar status
                $contadores[$novoStatus]++;
            }
        }
        
        // Registrar auditoria
        AuditoriaPresenca::create([
            'admin_user_id' => $userId,
            'data_registro' => $data,
            'dados_presenca' => $dadosPresenca,
            'total_colaboradores' => count($dadosPresenca),
            'total_presentes' => $contadores['presente'],
            'total_ausentes' => $contadores['falta'],
            'total_justificados' => $contadores['atestado'] + $contadores['banco_horas'],
            'ip_address' => $request->ip(),
            'observacoes' => "Registro de presenças salvo em " . now()->format('d/m/Y H:i:s')
        ]);
        
        // Log final
        \Log::info('=== PRESENCA STORE END ===', [
            'total_processados' => count($dadosPresenca),
            'historico_count_after' => HistoricoPresenca::count()
        ]);

        return redirect()->back()->with('success', 'Presenças registradas com sucesso! Registro de auditoria criado.');
    }
    
    public function historico(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->subDays(3)->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));
        $userId = Auth::id();
        
        // Buscar todos os colaboradores do gerente
        $todosColaboradores = Colaborador::where('admin_user_id', $userId)
            ->where('status', 'ativo')
            ->orderBy('nome')
            ->get();
        
        // Buscar presenças registradas no período
        $presencasRegistradas = Presenca::with('colaborador')
            ->where('admin_user_id', $userId)
            ->whereDate('data', '>=', $dataInicio)
            ->whereDate('data', '<=', $dataFim)
            ->orderBy('data', 'desc')
            ->get()
            ->groupBy(function($presenca) {
                return \Carbon\Carbon::parse($presenca->data)->format('Y-m-d');
            });
        
        // Debug: Log das presenças encontradas
        \Log::info('Histórico Debug', [
            'user_id' => $userId,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'total_presencas' => $presencasRegistradas->flatten()->count(),
            'presencas_por_dia' => $presencasRegistradas->map(function($presencas) {
                return $presencas->count();
            })->toArray()
        ]);
        
        // Criar estrutura completa com todos os colaboradores para cada dia
        $presencas = collect();
        
        $periodo = \Carbon\CarbonPeriod::create($dataInicio, $dataFim)->toArray();
        // Reverter para ordem DESC (mais recente primeiro)
        $periodo = array_reverse($periodo);
        
        foreach ($periodo as $data) {
            $dataFormatada = $data->format('Y-m-d');
            $presencasDoDia = collect();
            
            foreach ($todosColaboradores as $colaborador) {
                // Verificar se existe presença registrada para este colaborador nesta data
                $presencasDoDiaRegistradas = $presencasRegistradas->get($dataFormatada);
                $presencaExistente = $presencasDoDiaRegistradas ? $presencasDoDiaRegistradas->firstWhere('colaborador_id', $colaborador->id) : null;
                
                if ($presencaExistente) {
                    $presencasDoDia->push($presencaExistente);
                } else {
                    // Criar objeto de presença "virtual" para colaborador sem registro
                    $presencaVirtual = new \stdClass();
                    $presencaVirtual->colaborador = $colaborador;
                    $presencaVirtual->data = $dataFormatada;
                    $presencaVirtual->status = null; // Não registrado
                    $presencaVirtual->observacoes = null;
                    $presencaVirtual->status_formatado = 'Não Registrado';
                    $presencaVirtual->status_cor = 'secondary';
                    
                    $presencasDoDia->push($presencaVirtual);
                }
            }
            
            // Só adiciona o dia se tiver pelo menos uma presença registrada OU se for dentro do período solicitado
            if ($presencasDoDia->count() > 0) {
                $presencas->put($dataFormatada, $presencasDoDia->sortBy('colaborador.nome'));
            }
        }
        
        return view('admin.presencas.historico', compact('presencas', 'dataInicio', 'dataFim'));
    }
    
    public function historicoAlteracoes(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));
        $colaboradorId = $request->get('colaborador_id');
        
        $query = HistoricoPresenca::with(['adminUser', 'colaborador'])
            ->where('admin_user_id', Auth::id())
            ->whereBetween('data_presenca', [$dataInicio, $dataFim]);
            
        if ($colaboradorId) {
            $query->where('colaborador_id', $colaboradorId);
        }
        
        $historico = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Buscar colaboradores para o filtro
        $colaboradores = Colaborador::where('admin_user_id', Auth::id())
            ->orderBy('nome')
            ->get();
            
        return view('admin.presencas.historico-alteracoes', compact('historico', 'dataInicio', 'dataFim', 'colaboradorId', 'colaboradores'));
    }
}
