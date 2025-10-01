#!/bin/bash

# Script para verificar possíveis erros na aplicação Laravel

echo "Verificando ambiente Laravel e possíveis erros..."

# Verificar diretório de armazenamento
echo -e "\n### Verificando permissões de diretórios ###"
ls -la laravel-project/storage/
ls -la laravel-project/bootstrap/cache/

# Verificar configuração do banco de dados
echo -e "\n### Verificando configuração do banco de dados ###"
grep -n "DB_" laravel-project/.env

# Verificar serviço MySQL
echo -e "\n### Status do serviço MySQL ###"
systemctl status mariadb --no-pager

# Testar conexão com banco de dados
echo -e "\n### Testando conexão com banco de dados ###"
mysql -u pm_user -p'@Hebert19890' -e "SHOW DATABASES; USE projeto_manager; SHOW TABLES;"

# Verificar arquivos de log de erros recentes
echo -e "\n### Últimos erros no log do Laravel ###"
tail -n 50 laravel-project/storage/logs/laravel.log

# Verificar rotas disponíveis
echo -e "\n### Listando rotas da aplicação ###"
cd laravel-project && php artisan route:list --no-ansi | head -n 30

# Verificar dependências do dompdf
echo -e "\n### Verificando dependência dompdf ###"
grep -n "dompdf" laravel-project/composer.json

# Verificar status das migrações
echo -e "\n### Status das migrações ###"
cd laravel-project && php artisan migrate:status

# Verificar extensões PHP necessárias
echo -e "\n### Extensões PHP instaladas ###"
php -m | grep -E 'pdo|mysql|mbstring|dom|gd|fileinfo|opcache|xml'

echo -e "\n### Verificação concluída ###"