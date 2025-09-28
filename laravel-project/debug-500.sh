#!/bin/bash

echo "🔍 DIAGNÓSTICO DE ERROS 500 - Laravel"
echo "====================================="

cd /root/projeto_manager/laravel-project

echo ""
echo "1. 🔧 Verificando permissões..."
echo "Storage:" $(ls -ld storage/)
echo "Bootstrap/cache:" $(ls -ld bootstrap/cache/)

echo ""
echo "2. 📁 Verificando arquivos críticos..."
echo ".env existe: " $(test -f .env && echo "✅ SIM" || echo "❌ NÃO")
echo "vendor/ existe: " $(test -d vendor && echo "✅ SIM" || echo "❌ NÃO")
echo "database.sqlite existe: " $(test -f database/database.sqlite && echo "✅ SIM" || echo "❌ NÃO")

echo ""
echo "3. 🗄️ Testando conexão com banco..."
php artisan tinker --execute="
try {
    \DB::connection()->getPdo();
    echo 'Database: ✅ CONECTADO\n';
} catch (Exception \$e) {
    echo 'Database: ❌ ERRO - ' . \$e->getMessage() . '\n';
}
exit();
" 2>/dev/null

echo ""
echo "4. 🌐 Testando rotas..."
php artisan route:cache 2>/dev/null && echo "Routes: ✅ CACHE OK" || echo "Routes: ❌ ERRO NO CACHE"

echo ""
echo "5. 📝 Últimos logs de erro..."
echo "Últimas linhas do log:"
tail -5 storage/logs/laravel.log 2>/dev/null || echo "Nenhum log encontrado"

echo ""
echo "6. 🚀 Status do servidor..."
if pgrep -f "artisan serve" > /dev/null; then
    echo "Servidor: ✅ RODANDO"
else
    echo "Servidor: ❌ PARADO"
fi

echo ""
echo "7. 🧪 Teste de rota simples..."
php artisan tinker --execute="
try {
    \$response = \Illuminate\Support\Facades\Route::has('login');
    echo 'Rota login existe: ' . (\$response ? '✅ SIM' : '❌ NÃO') . '\n';
} catch (Exception \$e) {
    echo 'Erro ao verificar rotas: ❌ ' . \$e->getMessage() . '\n';
}
exit();
" 2>/dev/null

echo ""
echo "====================================="
echo "Diagnóstico concluído!"