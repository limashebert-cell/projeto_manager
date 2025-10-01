#!/bin/bash

# Script para diagnosticar e corrigir erros 500 no Laravel

echo "Diagnóstico e correção de erros 500 no Laravel"
echo "==============================================="

# Verificar e corrigir permissões
echo -e "\n[1] Verificando e corrigindo permissões..."
chmod -R 755 laravel-project
chown -R www-data:www-data laravel-project/storage
chown -R www-data:www-data laravel-project/bootstrap/cache
chmod -R 775 laravel-project/storage
chmod -R 775 laravel-project/bootstrap/cache

# Verificar logs
echo -e "\n[2] Verificando logs recentes..."
tail -n 50 laravel-project/storage/logs/laravel.log

# Verificar e reiniciar serviços
echo -e "\n[3] Verificando e reiniciando serviços..."
systemctl restart mariadb
systemctl restart nginx

# Limpar cache do Laravel
echo -e "\n[4] Limpando cache do Laravel..."
cd laravel-project
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# Verificar conexão ao banco de dados
echo -e "\n[5] Verificando conexão ao banco de dados..."
php -r "try { new PDO('mysql:host=127.0.0.1;dbname=projeto_manager', 'pm_user', '@Hebert19890'); echo 'Conexão ao banco de dados OK\n'; } catch (Exception \$e) { echo 'Erro de conexão: ' . \$e->getMessage() . \"\n\"; }"

# Testar rotas específicas via curl
echo -e "\n[6] Testando rotas via curl..."
echo "Testando rota principal:"
curl -I http://localhost

echo -e "\nTestando rota de login:"
curl -I http://localhost/login

echo -e "\nTestando rota de dashboard:"
curl -I http://localhost/admin

echo -e "\n[7] Verificando se o dominio utiliza HTTPS..."
# Se estiver usando HTTPS, certos cookies podem estar marcados como secure
# o que pode causar problemas se acessado via HTTP

echo -e "\n[8] Verificar PHP Modules (GD e DOM para PDF)..."
php -m | grep -E 'gd|dom'

echo -e "\n[9] Diagóstico completo! Verifique os resultados acima para identificar problemas."