<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = AdminUser::select('id', 'name', 'username', 'area', 'active', 'created_at')
                          ->where('role', 'admin')
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
        ]);

        AdminUser::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'area' => $request->area,
            'role' => 'admin',
            'active' => true,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        $user = AdminUser::findOrFail($id);
        return view('admin.users.show', compact('user'));
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
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'area' => $request->area,
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
