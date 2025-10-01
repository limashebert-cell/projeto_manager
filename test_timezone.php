<?php

echo "=== TESTE DE TIMEZONE ===\n";
echo "Timezone do Sistema: " . date_default_timezone_get() . "\n";
echo "Data/Hora do Sistema: " . date('Y-m-d H:i:s') . "\n";
echo "Data/Hora UTC: " . gmdate('Y-m-d H:i:s') . "\n";

// Teste com Carbon (Laravel)
require_once '/root/projeto_manager-1/laravel-project/vendor/autoload.php';

use Carbon\Carbon;

Carbon::setLocale('pt_BR');
echo "Carbon Timezone: " . Carbon::now()->getTimezone()->getName() . "\n";
echo "Carbon Now: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
echo "Carbon Now (Brasil): " . Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s') . "\n";

// Teste de conexão com banco
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=projeto_manager', 'pm_user', '@Hebert19890');
    $stmt = $pdo->query("SELECT NOW() as mysql_time");
    $result = $stmt->fetch();
    echo "MySQL NOW(): " . $result['mysql_time'] . "\n";
} catch (Exception $e) {
    echo "Erro MySQL: " . $e->getMessage() . "\n";
}

echo "========================\n";