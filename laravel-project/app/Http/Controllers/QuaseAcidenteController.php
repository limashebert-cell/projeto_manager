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
            'imagem_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'imagem_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'houve_dano_material' => 'required|boolean',
            'houve_prejuizo' => 'required|boolean',
            'valor_estimado' => 'nullable|numeric|min:0|required_if:houve_prejuizo,1',
        ]);

        $data = [
            'data_ocorrencia' => $request->data_ocorrencia,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'colaborador_envolvido' => $request->colaborador_envolvido,
            'gravidade' => $request->gravidade,
            'acoes_tomadas' => $request->acoes_tomadas,
            'status' => $request->status,
            'responsavel_id' => auth('admin')->id(),
            'houve_dano_material' => $request->houve_dano_material,
            'houve_prejuizo' => $request->houve_prejuizo,
            'valor_estimado' => $request->houve_prejuizo ? $request->valor_estimado : null,
        ];

        // Upload das imagens
        $uploadPath = public_path('uploads/quase_acidentes');
        
        // Garantir que o diretório existe
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($request->hasFile('imagem_1')) {
            $imagem1 = $request->file('imagem_1');
            $nomeImagem1 = 'quase_acidente_' . time() . '_' . uniqid() . '_1.' . $imagem1->getClientOriginalExtension();
            $imagem1->move($uploadPath, $nomeImagem1);
            $data['imagem_1'] = $nomeImagem1;
        }

        if ($request->hasFile('imagem_2')) {
            $imagem2 = $request->file('imagem_2');
            $nomeImagem2 = 'quase_acidente_' . time() . '_' . uniqid() . '_2.' . $imagem2->getClientOriginalExtension();
            $imagem2->move($uploadPath, $nomeImagem2);
            $data['imagem_2'] = $nomeImagem2;
        }

        \App\Models\QuaseAcidente::create($data);

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
        $quaseAcidente = \App\Models\QuaseAcidente::findOrFail($id);
        
        // Verificar permissões - apenas super admin ou responsável pode editar
        if (!auth('admin')->user()->isSuperAdmin() && 
            $quaseAcidente->responsavel_id != auth('admin')->id()) {
            abort(403, 'Não autorizado.');
        }
        
        return view('quase-acidentes.edit', compact('quaseAcidente'));
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
        $quaseAcidente = \App\Models\QuaseAcidente::findOrFail($id);
        
        // Verificar permissões
        if (!auth('admin')->user()->isSuperAdmin() && 
            $quaseAcidente->responsavel_id != auth('admin')->id()) {
            abort(403, 'Não autorizado.');
        }
        
        $request->validate([
            'data_ocorrencia' => 'required|date',
            'local' => 'required|string|max:255',
            'descricao' => 'required|string',
            'colaborador_envolvido' => 'nullable|string|max:255',
            'gravidade' => 'required|in:baixa,media,alta',
            'acoes_tomadas' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluido',
            'imagem_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'imagem_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'houve_dano_material' => 'required|boolean',
            'houve_prejuizo' => 'required|boolean',
            'valor_estimado' => 'nullable|numeric|min:0|required_if:houve_prejuizo,1',
        ]);

        $data = [
            'data_ocorrencia' => $request->data_ocorrencia,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'colaborador_envolvido' => $request->colaborador_envolvido,
            'gravidade' => $request->gravidade,
            'acoes_tomadas' => $request->acoes_tomadas,
            'status' => $request->status,
            'houve_dano_material' => $request->houve_dano_material,
            'houve_prejuizo' => $request->houve_prejuizo,
            'valor_estimado' => $request->houve_prejuizo ? $request->valor_estimado : null,
        ];

        // Upload das novas imagens
        $uploadPath = public_path('uploads/quase_acidentes');
        
        // Garantir que o diretório existe
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Processar imagem 1
        if ($request->hasFile('imagem_1')) {
            // Remover imagem antiga se existir
            if ($quaseAcidente->imagem_1 && file_exists($uploadPath . '/' . $quaseAcidente->imagem_1)) {
                unlink($uploadPath . '/' . $quaseAcidente->imagem_1);
            }
            
            $imagem1 = $request->file('imagem_1');
            $nomeImagem1 = 'quase_acidente_' . time() . '_' . uniqid() . '_1.' . $imagem1->getClientOriginalExtension();
            $imagem1->move($uploadPath, $nomeImagem1);
            $data['imagem_1'] = $nomeImagem1;
        } elseif ($request->has('remove_imagem_1')) {
            // Remover imagem se marcado para remoção
            if ($quaseAcidente->imagem_1 && file_exists($uploadPath . '/' . $quaseAcidente->imagem_1)) {
                unlink($uploadPath . '/' . $quaseAcidente->imagem_1);
            }
            $data['imagem_1'] = null;
        }

        // Processar imagem 2
        if ($request->hasFile('imagem_2')) {
            // Remover imagem antiga se existir
            if ($quaseAcidente->imagem_2 && file_exists($uploadPath . '/' . $quaseAcidente->imagem_2)) {
                unlink($uploadPath . '/' . $quaseAcidente->imagem_2);
            }
            
            $imagem2 = $request->file('imagem_2');
            $nomeImagem2 = 'quase_acidente_' . time() . '_' . uniqid() . '_2.' . $imagem2->getClientOriginalExtension();
            $imagem2->move($uploadPath, $nomeImagem2);
            $data['imagem_2'] = $nomeImagem2;
        } elseif ($request->has('remove_imagem_2')) {
            // Remover imagem se marcado para remoção
            if ($quaseAcidente->imagem_2 && file_exists($uploadPath . '/' . $quaseAcidente->imagem_2)) {
                unlink($uploadPath . '/' . $quaseAcidente->imagem_2);
            }
            $data['imagem_2'] = null;
        }

        $quaseAcidente->update($data);

        return redirect()->route('quase-acidentes.show', $quaseAcidente->id)
                         ->with('success', 'Quase acidente atualizado com sucesso!');
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
