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
    
    /**
     * Exportar histórico de alterações para CSV
     */
    public function exportarHistoricoCSV(Request $request)
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
        
        $historico = $query->orderBy('created_at', 'desc')->get();
        
        // Nome do arquivo
        $fileName = 'historico_presencas_' . $dataInicio . '_a_' . $dataFim . '.csv';
        
        // Headers do CSV
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($historico) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8 (para Excel reconhecer acentos)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho do CSV
            fputcsv($file, [
                'Data/Hora da Alteração',
                'Colaborador',
                'Prontuário',
                'Data da Presença',
                'Ação',
                'Status Anterior',
                'Novo Status',
                'Observações Anteriores',
                'Novas Observações',
                'Usuário Responsável',
                'IP Address',
                'User Agent'
            ], ';');
            
            // Dados
            foreach ($historico as $item) {
                fputcsv($file, [
                    $item->created_at->format('d/m/Y H:i:s'),
                    $item->colaborador->nome ?? 'N/A',
                    $item->colaborador->prontuario ?? 'N/A',
                    \Carbon\Carbon::parse($item->data_presenca)->format('d/m/Y'),
                    ucfirst($item->acao),
                    $item->status_anterior ? ucfirst(str_replace('_', ' ', $item->status_anterior)) : '-',
                    ucfirst(str_replace('_', ' ', $item->status_novo)),
                    $item->observacoes_anterior ?? '-',
                    $item->observacoes_nova ?? '-',
                    $item->adminUser->name ?? 'N/A',
                    $item->ip_address ?? '-',
                    $item->user_agent ?? '-'
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Exportar histórico geral de presenças para CSV
     */
    public function exportarHistoricoGeralCSV(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->subDays(3)->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));
        $userId = Auth::id();
        
        // Buscar presenças registradas no período
        $presencasRegistradas = Presenca::with('colaborador')
            ->where('admin_user_id', $userId)
            ->whereDate('data', '>=', $dataInicio)
            ->whereDate('data', '<=', $dataFim)
            ->orderBy('data', 'desc')
            ->orderBy('colaborador_id')
            ->get();
        
        // Nome do arquivo
        $fileName = 'historico_geral_presencas_' . $dataInicio . '_a_' . $dataFim . '.csv';
        
        // Headers do CSV
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($presencasRegistradas, $dataInicio, $dataFim, $userId) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8 (para Excel reconhecer acentos)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho do CSV
            fputcsv($file, [
                'Data',
                'Colaborador',
                'Prontuário',
                'Status',
                'Observações',
                'Data de Registro',
                'Responsável'
            ], ';');
            
            // Buscar todos os colaboradores para incluir dias não registrados
            $todosColaboradores = Colaborador::where('admin_user_id', $userId)
                ->where('status', 'ativo')
                ->orderBy('nome')
                ->get();
            
            // Criar período de datas
            $periodo = \Carbon\CarbonPeriod::create($dataInicio, $dataFim)->toArray();
            
            foreach ($periodo as $data) {
                $dataFormatada = $data->format('Y-m-d');
                
                // Presenças registradas neste dia
                $presencasDoDia = $presencasRegistradas->where('data', $dataFormatada);
                
                foreach ($todosColaboradores as $colaborador) {
                    $presenca = $presencasDoDia->where('colaborador_id', $colaborador->id)->first();
                    
                    if ($presenca) {
                        // Presença registrada
                        fputcsv($file, [
                            $data->format('d/m/Y'),
                            $colaborador->nome,
                            $colaborador->prontuario,
                            ucfirst(str_replace('_', ' ', $presenca->status)),
                            $presenca->observacoes ?? '-',
                            $presenca->created_at->format('d/m/Y H:i:s'),
                            $presenca->adminUser->name ?? 'N/A'
                        ], ';');
                    } else {
                        // Presença não registrada
                        fputcsv($file, [
                            $data->format('d/m/Y'),
                            $colaborador->nome,
                            $colaborador->prontuario,
                            'Não Registrado',
                            '-',
                            '-',
                            '-'
                        ], ';');
                    }
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
