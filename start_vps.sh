#!/bin/bash

# Script para iniciar/reiniciar todos os serviços do VPS
echo "Iniciando todos os serviços necessários para o VPS..."

# Reiniciar o banco de dados
echo -e "\n[1] Reiniciando banco de dados MariaDB..."
systemctl restart mariadb
systemctl status mariadb --no-pager

# Reiniciar o PHP-FPM
echo -e "\n[2] Reiniciando PHP-FPM..."
systemctl restart php8.3-fpm
systemctl status php8.3-fpm --no-pager

# Reiniciar o servidor web
echo -e "\n[3] Reiniciando servidor web Nginx..."
systemctl restart nginx
systemctl status nginx --no-pager

# Definir diretório de trabalho
cd /root/projeto_manager-1

# Limpar cache do Laravel
echo -e "\n[4] Limpando cache do Laravel..."
cd laravel-project
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan optimize
cd ..

# Verificar conexão com o banco de dados
echo -e "\n[5] Verificando conexão com o banco de dados..."
mysql -u pm_user -p'@Hebert19890' -e "SHOW DATABASES;"

# Verificar acessibilidade do site
echo -e "\n[6] Verificando acessibilidade do site..."
curl -I http://localhost | head -n 5

# Verificar permissões de diretórios essenciais
echo -e "\n[7] Verificando permissões de diretórios essenciais..."
ls -la /root/projeto_manager-1/laravel-project/storage/ | head -n 5
ls -la /root/projeto_manager-1/laravel-project/bootstrap/cache/ | head -n 5

echo -e "\nTodos os serviços do VPS foram iniciados com sucesso!"
echo -e "Você pode acessar o site através do navegador no endereço: http://seu_ip_ou_dominio"
echo -e "Login: admin"
echo -e "Senha: admin123"
