<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;
use App\Models\Colaborador;
use App\Models\Presenca;
use App\Models\HistoricoPresenca;
use App\Models\AuditoriaPresenca;
use App\Models\TimeclockRecord;
use App\Models\QuaseAcidente;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = AdminUser::select('id', 'name', 'username', 'area', 'role', 'active', 'created_at')
                          ->where('role', '!=', 'super_admin')
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin_users,username',
            'password' => 'required|string|min:6|confirmed',
            'area' => 'required|string|max:255',
            'role' => 'required|string|in:gerente,gestor,administrativo,prevencao,sesmit,agente_01,agente_02,agente_03,agente_04',
            'nivel' => 'required|string|in:Gerente,Gestor,Administrativo,Prevenção,SESMIT,Agente 01,Agente 02,Agente 03,Agente 04',
        ]);

        AdminUser::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'area' => $request->area,
            'role' => $request->role,
            'nivel' => $request->nivel,
            'active' => true,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        $user = AdminUser::findOrFail($id);
        
        // Verificar relacionamentos
        $relacionamentos = [
            'colaboradores' => $user->colaboradores()->count(),
            'presencas' => Presenca::where('admin_user_id', $user->id)->count(),
            'historicos' => HistoricoPresenca::where('admin_user_id', $user->id)->count(),
            'auditorias' => AuditoriaPresenca::where('admin_user_id', $user->id)->count(),
            'timeclocks' => TimeclockRecord::where('admin_user_id', $user->id)->count(),
            'quase_acidentes' => QuaseAcidente::where('responsavel_id', $user->id)->count(),
        ];
        
        $totalRelacionamentos = array_sum($relacionamentos);
        
        return view('admin.users.show', compact('user', 'relacionamentos', 'totalRelacionamentos'));
    }

    public function edit($id)
    {
        $user = AdminUser::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = AdminUser::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin_users,username,' . $id,
            'area' => 'required|string|max:255',
            'role' => 'required|string|in:gerente,gestor,administrativo,prevencao,sesmit,agente_01,agente_02,agente_03,agente_04',
            'nivel' => 'required|string|in:Gerente,Gestor,Administrativo,Prevenção,SESMIT,Agente 01,Agente 02,Agente 03,Agente 04',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'area' => $request->area,
            'role' => $request->role,
            'nivel' => $request->nivel,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = $request->password;
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);
        
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Não é possível excluir o super administrador!');
        }

        // Verificar se existem registros relacionados
        $relacionamentos = [];
        
        // Verificar colaboradores
        $colaboradores = $user->colaboradores()->count();
        if ($colaboradores > 0) {
            $relacionamentos[] = "$colaboradores colaborador(es)";
        }
        
        // Verificar presenças
        $presencas = \App\Models\Presenca::where('admin_user_id', $user->id)->count();
        if ($presencas > 0) {
            $relacionamentos[] = "$presencas presença(s)";
        }
        
        // Verificar histórico de presenças
        $historicos = \App\Models\HistoricoPresenca::where('admin_user_id', $user->id)->count();
        if ($historicos > 0) {
            $relacionamentos[] = "$historicos histórico(s) de presença";
        }
        
        // Verificar auditorias
        $auditorias = \App\Models\AuditoriaPresenca::where('admin_user_id', $user->id)->count();
        if ($auditorias > 0) {
            $relacionamentos[] = "$auditorias auditoria(s) de presença";
        }
        
        // Verificar timeclock records
        $timeclocks = \App\Models\TimeclockRecord::where('admin_user_id', $user->id)->count();
        if ($timeclocks > 0) {
            $relacionamentos[] = "$timeclocks registro(s) de ponto";
        }
        
        // Verificar quase acidentes
        $quaseAcidentes = \App\Models\QuaseAcidente::where('responsavel_id', $user->id)->count();
        if ($quaseAcidentes > 0) {
            $relacionamentos[] = "$quaseAcidentes quase acidente(s)";
        }

        if (!empty($relacionamentos)) {
            $mensagem = 'Não é possível excluir este usuário pois ele possui os seguintes registros relacionados: ' . implode(', ', $relacionamentos) . '. ';
            $mensagem .= 'Para excluir o usuário, primeiro você deve transferir ou excluir esses registros, ou desativar o usuário em vez de excluí-lo.';
            
            return redirect()->route('admin.users.index')
                            ->with('error', $mensagem);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'Usuário excluído com sucesso!');
    }

    public function toggleStatus($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->update(['active' => !$user->active]);

        $status = $user->active ? 'ativado' : 'desativado';
        return redirect()->route('admin.users.index')
                        ->with('success', "Usuário {$status} com sucesso!");
    }
}
