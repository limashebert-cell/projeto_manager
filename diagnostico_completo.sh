#!/bin/bash

echo "=== DIAGNÓSTICO COMPLETO DO SISTEMA ==="
echo "Data: $(date)"
echo ""

echo "1. VERIFICANDO SERVIÇOS:"
systemctl status nginx --no-pager
systemctl status php8.3-fpm --no-pager
systemctl status mariadb --no-pager
echo ""

echo "2. VERIFICANDO LOGS DO NGINX:"
echo "Últimos 10 erros do Nginx:"
tail -10 /var/log/nginx/error.log
echo ""

echo "3. VERIFICANDO LOGS DO LARAVEL:"
echo "Últimos 10 logs do Laravel:"
tail -10 /root/projeto_manager-1/laravel-project/storage/logs/laravel.log 2>/dev/null || echo "Arquivo de log não encontrado"
echo ""

echo "4. TESTANDO CONECTIVIDADE:"
cd /root/projeto_manager-1/laravel-project
php artisan route:clear
php artisan config:clear
php artisan cache:clear
echo "Cache limpo"
echo ""

echo "5. VERIFICANDO USUÁRIOS ADMIN:"
php artisan tinker --execute="
use App\Models\AdminUser;
\$users = AdminUser::all();
foreach(\$users as \$user) {
    echo 'Usuário: ' . \$user->username . ' - Nome: ' . \$user->name . ' - Role: ' . \$user->role . PHP_EOL;
}
"
echo ""

echo "6. TESTANDO ROTA ESPECÍFICA:"
curl -v http://localhost:8000/admin/colaboradores/download-template 2>&1 | head -20
echo ""

echo "=== FIM DO DIAGNÓSTICO ==="