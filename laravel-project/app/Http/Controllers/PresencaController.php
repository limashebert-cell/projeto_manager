<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenca;
use App\Models\Colaborador;
use App\Models\AuditoriaPresenca;
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
        $presencasExistentes = Presenca::where('user_id', Auth::id())
            ->where('data', $data)
            ->get()
            ->keyBy('colaborador_id');
        
        return view('admin.presencas.index', compact('colaboradores', 'presencasExistentes', 'data', 'dataFormatada'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'presencas' => 'required|array',
            'presencas.*.colaborador_id' => 'required|exists:colaboradores,id',
            'presencas.*.status' => 'required|in:presente,falta,atestado,banco_horas',
            'presencas.*.observacoes' => 'nullable|string|max:500'
        ]);
        
        $data = $request->data;
        $userId = Auth::id();
        
        // Deletar registros existentes para esta data (para permitir edição)
        Presenca::where('user_id', $userId)->where('data', $data)->delete();
        
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
                // Criar registro de presença
                Presenca::create([
                    'user_id' => $userId,
                    'colaborador_id' => $presencaData['colaborador_id'],
                    'data' => $data,
                    'status' => $presencaData['status'],
                    'observacoes' => $presencaData['observacoes'] ?? null
                ]);
                
                // Preparar dados para auditoria
                $dadosPresenca[] = [
                    'colaborador_id' => $colaborador->id,
                    'colaborador_nome' => $colaborador->nome,
                    'status' => $presencaData['status'],
                    'observacoes' => $presencaData['observacoes'] ?? null
                ];
                
                // Contar status
                $contadores[$presencaData['status']]++;
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
        
        return redirect()->back()->with('success', 'Presenças registradas com sucesso! Registro de auditoria criado.');
    }
    
    public function historico(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));
        
        $presencas = Presenca::with('colaborador')
            ->where('user_id', Auth::id())
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->orderBy('data', 'desc')
            ->orderBy('colaborador_id')
            ->get()
            ->groupBy('data');
            
        return view('admin.presencas.historico', compact('presencas', 'dataInicio', 'dataFim'));
    }
}
