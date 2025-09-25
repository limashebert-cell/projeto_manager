<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuaseAcidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quaseAcidentes = \App\Models\QuaseAcidente::latest()->paginate(10);
        return view('quase-acidentes.index', compact('quaseAcidentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quase-acidentes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_ocorrencia' => 'required|date',
            'local' => 'required|string|max:255',
            'descricao' => 'required|string',
            'colaborador_envolvido' => 'nullable|string|max:255',
            'gravidade' => 'required|in:baixa,media,alta',
            'acoes_tomadas' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluido',
        ]);

        \App\Models\QuaseAcidente::create([
            'data_ocorrencia' => $request->data_ocorrencia,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'colaborador_envolvido' => $request->colaborador_envolvido,
            'gravidade' => $request->gravidade,
            'acoes_tomadas' => $request->acoes_tomadas,
            'status' => $request->status,
            'responsavel_id' => auth('admin')->id(),
        ]);

        return redirect()->route('quase-acidentes.index')
                         ->with('success', 'Quase acidente registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quaseAcidente = \App\Models\QuaseAcidente::with('responsavel')->findOrFail($id);
        return view('quase-acidentes.show', compact('quaseAcidente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quaseAcidente = \App\Models\QuaseAcidente::findOrFail($id);
        
        // Verificar se o usuário tem permissão para excluir
        // Apenas o responsável pelo registro ou super admin podem excluir
        if (auth('admin')->user()->isSuperAdmin() || 
            $quaseAcidente->responsavel_id == auth('admin')->id()) {
            
            $quaseAcidente->delete();
            
            return redirect()->route('quase-acidentes.index')
                           ->with('success', 'Quase acidente excluído com sucesso!');
        }
        
        return redirect()->route('quase-acidentes.index')
                       ->with('error', 'Você não tem permissão para excluir este registro.');
    }
    
    /**
     * Gerar relatório PDF dos quase acidentes
     *
     * @return \Illuminate\Http\Response
     */
    public function relatorio(Request $request)
    {
        $query = \App\Models\QuaseAcidente::with('responsavel')->latest();
        
        // Filtros opcionais
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_ocorrencia', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_ocorrencia', '<=', $request->data_fim);
        }
        
        if ($request->filled('gravidade')) {
            $query->where('gravidade', $request->gravidade);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $quaseAcidentes = $query->get();
        
        $pdf = Pdf::loadView('quase-acidentes.relatorio-pdf', [
            'quaseAcidentes' => $quaseAcidentes,
            'filtros' => $request->all(),
            'dataGeracao' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->download('relatorio-quase-acidentes-' . now()->format('Y-m-d') . '.pdf');
    }
    
    /**
     * Gerar relatório de um quase acidente específico
     */
    public function relatorioPorId($id)
    {
        $quaseAcidente = \App\Models\QuaseAcidente::with('responsavel')->findOrFail($id);
        
        $pdf = Pdf::loadView('quase-acidentes.relatorio-individual-pdf', [
            'quaseAcidente' => $quaseAcidente,
            'dataGeracao' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->download('quase-acidente-' . $id . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
