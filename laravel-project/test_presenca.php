<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Presenca;
use App\Models\HistoricoPresenca;
use App\Models\Colaborador;

echo "=== TESTE DE PRESENÇA ===\n";

$userId = 2;
$data = '2025-09-26';
$colaboradorId = 1;
$novoStatus = 'presente';

echo "Histórico antes: " . HistoricoPresenca::count() . "\n";
echo "Presenças antes: " . Presenca::count() . "\n";

// Buscar colaborador
$colaborador = Colaborador::find($colaboradorId);
if (!$colaborador) {
    echo "Colaborador não encontrado!\n";
    exit;
}

// Buscar registro existente
$presencaExistente = Presenca::where('admin_user_id', $userId)
    ->where('colaborador_id', $colaboradorId)
    ->whereDate('data', $data)
    ->first();

$acao = '';
if ($presencaExistente) {
    echo "Atualizando registro existente...\n";
    $presencaExistente->update(['status' => $novoStatus]);
    $acao = 'editado';
} else {
    echo "Criando novo registro...\n";
    Presenca::create([
        'admin_user_id' => $userId,
        'colaborador_id' => $colaboradorId,
        'data' => $data,
        'status' => $novoStatus
    ]);
    $acao = 'criado';
}

// Criar histórico
$historico = HistoricoPresenca::create([
    'admin_user_id' => $userId,
    'colaborador_id' => $colaboradorId,
    'data_presenca' => $data,
    'status_novo' => $novoStatus,
    'acao' => $acao,
    'dados_completos' => [
        'colaborador_nome' => $colaborador->nome,
        'data_registro' => now()->toDateTimeString()
    ]
]);

echo "Histórico criado: ID " . $historico->id . "\n";
echo "Histórico depois: " . HistoricoPresenca::count() . "\n";
echo "Presenças depois: " . Presenca::count() . "\n";