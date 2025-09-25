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
