<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = Auth::guard('admin')->user()->colaboradores()->paginate(10);
        return view('admin.colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        return view('admin.colaboradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prontuario' => 'required|string|max:50|unique:colaboradores,prontuario',
            'nome' => 'required|string|max:255',
            'data_admissao' => 'required|date',
            'contato' => 'required|string|max:255',
            'data_aniversario' => 'required|date',
            'cargo' => 'required|in:Auxiliar,Conferente,Adm,Op Empilhadeira',
            'status' => 'required|in:ativo,inativo'
        ]);

        $adminUser = Auth::guard('admin')->user();
        
        $colaborador = new Colaborador($request->all());
        $colaborador->admin_user_id = $adminUser->id;
        $colaborador->save();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador cadastrado com sucesso!');
    }

    public function show(Colaborador $colaborador)
    {
        // Verifica se o colaborador pertence ao usuário logado
        if ($colaborador->admin_user_id !== Auth::guard('admin')->id()) {
            abort(403, 'Acesso negado.');
        }
        
        return view('admin.colaboradores.show', compact('colaborador'));
    }

    public function edit(Colaborador $colaborador)
    {
        // Verifica se o colaborador pertence ao usuário logado
        if ($colaborador->admin_user_id !== Auth::guard('admin')->id()) {
            abort(403, 'Acesso negado.');
        }
        
        return view('admin.colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, Colaborador $colaborador)
    {
        // Verifica se o colaborador pertence ao usuário logado
        if ($colaborador->admin_user_id !== Auth::guard('admin')->id()) {
            abort(403, 'Acesso negado.');
        }
        
        $request->validate([
            'prontuario' => 'required|string|max:50|unique:colaboradores,prontuario,' . $colaborador->id,
            'nome' => 'required|string|max:255',
            'data_admissao' => 'required|date',
            'contato' => 'required|string|max:255',
            'data_aniversario' => 'required|date',
            'cargo' => 'required|in:Auxiliar,Conferente,Adm,Op Empilhadeira',
            'status' => 'required|in:ativo,inativo'
        ]);

        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Colaborador $colaborador)
    {
        // Verifica se o colaborador pertence ao usuário logado
        if ($colaborador->admin_user_id !== Auth::guard('admin')->id()) {
            abort(403, 'Acesso negado.');
        }
        
        $colaborador->delete();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador removido com sucesso!');
    }
}
