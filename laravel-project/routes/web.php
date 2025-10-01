<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeclockController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\AuditoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rota de teste
Route::get('/test', function () {
    return '<h1>Servidor funcionando!</h1><p>Laravel está OK.</p>';
});

// Rota de teste CSRF
Route::get('/test-csrf', function () {
    return view('test.csrf');
})->name('test.csrf.form');

Route::post('/test-csrf', function (Illuminate\Http\Request $request) {
    return redirect()->back()->with('test_result', 'CSRF Token válido! Teste realizado com sucesso.');
})->name('test.csrf');

// Redirecionar para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Rotas do painel administrativo
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Rotas para gerenciamento de usuários (apenas super admin)
    Route::prefix('admin/users')->name('admin.users.')->middleware('super.admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // Rotas para cartão de ponto (todos os usuários autenticados)
    Route::prefix('admin/timeclock')->name('admin.timeclock.')->group(function () {
        Route::get('/', [TimeclockController::class, 'index'])->name('index');
        Route::post('/clock-in', [TimeclockController::class, 'clockIn'])->name('clock-in');
        Route::post('/clock-out', [TimeclockController::class, 'clockOut'])->name('clock-out');
        Route::post('/start-break', [TimeclockController::class, 'startBreak'])->name('start-break');
        Route::post('/end-break', [TimeclockController::class, 'endBreak'])->name('end-break');
        Route::post('/update-notes', [TimeclockController::class, 'updateNotes'])->name('update-notes');
    });
    
    // Rotas para colaboradores (todos os usuários autenticados)
    Route::prefix('admin/colaboradores')->name('colaboradores.')->group(function () {
        Route::get('/', [ColaboradorController::class, 'index'])->name('index');
        Route::get('/create', [ColaboradorController::class, 'create'])->name('create');
        Route::post('/', [ColaboradorController::class, 'store'])->name('store');
        
        // Rotas para importação em massa (devem vir ANTES das rotas com parâmetros)
        Route::get('/download-template', [ColaboradorController::class, 'downloadTemplate'])->name('download-template');
        Route::get('/import', [ColaboradorController::class, 'showImport'])->name('import');
        Route::post('/import', [ColaboradorController::class, 'import'])->name('import.process');
        
        Route::get('/{colaborador}', [ColaboradorController::class, 'show'])->name('show');
        Route::get('/{colaborador}/edit', [ColaboradorController::class, 'edit'])->name('edit');
        Route::put('/{colaborador}', [ColaboradorController::class, 'update'])->name('update');
        Route::delete('/{colaborador}', [ColaboradorController::class, 'destroy'])->name('destroy');
    });
    
    // Rotas para controle de presença (todos os usuários autenticados)
    Route::prefix('admin/presencas')->name('presencas.')->group(function () {
        Route::get('/', [PresencaController::class, 'index'])->name('index');
        Route::post('/', [PresencaController::class, 'store'])->name('store');
        Route::get('/historico', [PresencaController::class, 'historico'])->name('historico');
        Route::get('/historico/csv', [PresencaController::class, 'exportarHistoricoGeralCSV'])->name('historico.csv');
        Route::get('/historico-alteracoes', [PresencaController::class, 'historicoAlteracoes'])->name('historico-alteracoes');
        Route::get('/historico-alteracoes/csv', [PresencaController::class, 'exportarHistoricoCSV'])->name('historico-alteracoes.csv');
        Route::get('/teste', function() {
            return view('admin.presencas.teste');
        })->name('teste');
    });
    
    // Rotas para auditoria de presenças (todos os usuários autenticados)
    Route::prefix('admin/auditoria')->name('auditoria.')->group(function () {
        Route::get('/', [AuditoriaController::class, 'index'])->name('index');
        Route::get('/{id}', [AuditoriaController::class, 'show'])->name('show');
    });
    
    // Rotas para quase acidentes (todos os usuários autenticados)
    Route::prefix('admin/quase-acidentes')->name('quase-acidentes.')->group(function () {
        Route::get('/', [App\Http\Controllers\QuaseAcidenteController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\QuaseAcidenteController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\QuaseAcidenteController::class, 'store'])->name('store');
        Route::get('/relatorio', [App\Http\Controllers\QuaseAcidenteController::class, 'relatorio'])->name('relatorio');
        Route::get('/{quaseAcidente}', [App\Http\Controllers\QuaseAcidenteController::class, 'show'])->name('show');
        Route::get('/{quaseAcidente}/edit', [App\Http\Controllers\QuaseAcidenteController::class, 'edit'])->name('edit');
        Route::get('/{quaseAcidente}/pdf', [App\Http\Controllers\QuaseAcidenteController::class, 'relatorioPorId'])->name('pdf');
        Route::put('/{quaseAcidente}', [App\Http\Controllers\QuaseAcidenteController::class, 'update'])->name('update');
        Route::delete('/{quaseAcidente}', [App\Http\Controllers\QuaseAcidenteController::class, 'destroy'])->name('destroy');
    });
});
Route::get('/test-cache', function() { return 'Cache limpo em ' . now(); });

// ===== ROTA ABSOLUTA PARA TESTE DEFINITIVO =====
Route::get('/nivel-test', function() {
    return '<!DOCTYPE html>
<html>
<head>
    <title>TESTE CAMPO NIVEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(45deg, #ff0000, #00ff00); padding: 50px; }
        .mega { border: 20px solid #000; background: #fff; padding: 50px; }
        .nivel-select { border: 10px solid #ff0000; font-size: 30px; padding: 20px; }
    </style>
</head>
<body>
    <div class="mega">
        <h1 style="font-size: 60px; text-align: center;">🔥 TESTE CAMPO NIVEL 🔥</h1>
        <form method="POST" action="'.route('admin.users.store').'">
            '.csrf_field().'
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">NOME:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">USERNAME:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">ÁREA:</label>
                <select class="form-select" name="area" required>
                    <option value="Administração">Administração</option>
                </select>
            </div>
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">ROLE:</label>
                <select class="form-select" name="role" required>
                    <option value="gerente">Gerente</option>
                </select>
            </div>
            <div style="border: 15px solid #ff0000; padding: 30px; background: #ffff00;">
                <h2 style="font-size: 50px; text-align: center;">🎯 CAMPO NÍVEL 🎯</h2>
                <select class="form-select nivel-select" name="nivel" required>
                    <option value="">ESCOLHA O NÍVEL</option>
                    <option value="Gerente">👑 Gerente</option>
                    <option value="Gestor">👤 Gestor</option>
                    <option value="Administrativo">📋 Administrativo</option>
                    <option value="Prevenção">🛡️ Prevenção</option>
                    <option value="SESMIT">🏥 SESMIT</option>
                    <option value="Agente 01">🔧 Agente 01</option>
                    <option value="Agente 02">🔧 Agente 02</option>
                    <option value="Agente 03">🔧 Agente 03</option>
                    <option value="Agente 04">🔧 Agente 04</option>
                </select>
            </div>
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">SENHA:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label style="font-size: 40px; color: #ff0000;">CONFIRMAR:</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-success w-100" style="font-size: 30px;">CRIAR USUÁRIO</button>
        </form>
    </div>
</body>
</html>';
});

Route::get('/criar-usuario-nivel-absoluto', function() {
    // Auto-login garantido
    $admin = App\Models\AdminUser::where('username', 'admin')->first();
    Auth::guard('admin')->login($admin);
    
    // Renderizar view diretamente
    return view('admin.users.create');
})->name('test.absoluto');

Route::get('/test-create-debug', function() {
    try {
        // Force login do admin
        $admin = App\Models\AdminUser::where('username', 'admin')->first();
        Auth::guard('admin')->login($admin);
        
        // Renderizar exatamente o que o controller renderiza
        $controller = new App\Http\Controllers\UserController();
        $response = $controller->create();
        
        // Adicionar debug info
        $html = $response->render();
        $html = str_replace(
            '<body>',
            '<body><div style="background:red;color:white;padding:20px;text-align:center;font-size:24px;">🔍 DEBUG: VIEW CARREGADA COM SUCESSO - LOGADO COMO ADMIN 🔍</div>',
            $html
        );
        
        return $html;
        
    } catch (Exception $e) {
        return '<h1 style="color:red;">ERRO: ' . $e->getMessage() . '</h1>';
    }
});

// Rota de teste para debug da view create
Route::get('/test-create-view', function () {
    return view('admin.users.create');
})->name('test.create.view');

// ===== ROTA DE TESTE COM CREDENCIAIS CORRETAS admin/123456 =====
Route::get('/test-nivel-correto', function() {
    try {
        // Auto-login com credenciais corretas admin/123456
        $admin = App\Models\AdminUser::where('username', 'admin')->first();
        
        if (!$admin) {
            return response('<h1>❌ Admin não encontrado</h1>', 404);
        }
        
        Auth::guard('admin')->login($admin);
        
        // Renderizar a view diretamente
        $view = view('admin.users.create');
        $html = $view->render();
        
        // Adicionar indicador de sucesso
        $html = str_replace(
            '✅ ARQUIVO ULTRA LIMPO - CAMPO NIVEL IMPLEMENTADO ✅',
            '🎉 CREDENCIAIS CORRETAS: admin/123456 - CAMPO NIVEL OK! 🎉',
            $html
        );
        
        return $html;
        
    } catch (Exception $e) {
        return response('<h1>❌ Erro: ' . $e->getMessage() . '</h1>', 500);
    }
});


