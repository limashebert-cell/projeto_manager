<?php

use Illuminate\Support\Facades\Route;
use App\Models\AdminUser;

// Rota de teste para verificar a view de criação
Route::get('/test-create-user-view', function () {
    try {
        // Simular autenticação
        $user = AdminUser::find(1); // Super Admin
        auth('admin')->login($user);
        
        // Simular a variável $errors que o Laravel normalmente fornece
        $errors = session()->get('errors', new \Illuminate\Support\MessageBag());
        
        return view('admin.users.create', compact('errors'));
    } catch (\Exception $e) {
        return "Erro: " . $e->getMessage();
    }
})->name('test.create.user.view');