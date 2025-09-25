<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode ver todos os colaboradores, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaboradores = Colaborador::with('adminUser')->paginate(10);
        } else {
            $colaboradores = $user->colaboradores()->with('adminUser')->paginate(10);
        }
        
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
            'status' => 'required|in:ativo,inativo',
            'tipo_inatividade' => 'nullable|required_if:status,inativo|in:afastado,desligado'
        ]);

        $adminUser = Auth::guard('admin')->user();
        
        $colaborador = new Colaborador($request->all());
        $colaborador->admin_user_id = $adminUser->id;
        $colaborador->save();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador cadastrado com sucesso!');
    }

    public function show($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode ver qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::with('adminUser')->findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->with('adminUser')->findOrFail($id);
        }
        
        return view('admin.colaboradores.show', compact('colaborador'));
    }

    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode editar qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::with('adminUser')->findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->with('adminUser')->findOrFail($id);
        }
        
        return view('admin.colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode atualizar qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->findOrFail($id);
        }
        
        $request->validate([
            'prontuario' => 'required|string|max:50|unique:colaboradores,prontuario,' . $colaborador->id,
            'nome' => 'required|string|max:255',
            'data_admissao' => 'required|date',
            'contato' => 'required|string|max:255',
            'data_aniversario' => 'required|date',
            'cargo' => 'required|in:Auxiliar,Conferente,Adm,Op Empilhadeira',
            'status' => 'required|in:ativo,inativo',
            'tipo_inatividade' => 'nullable|required_if:status,inativo|in:afastado,desligado'
        ]);

        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode excluir qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->findOrFail($id);
        }
        
        $colaborador->delete();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador removido com sucesso!');
    }
}
