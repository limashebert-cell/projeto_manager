#!/bin/bash

echo "=== DIAGNÓSTICO DE ERRO 404 ==="

# Verificar se o Nginx está rodando
echo -e "\n1. Status do Nginx:"
systemctl is-active nginx && echo "✓ Nginx ativo" || echo "✗ Nginx inativo"

# Verificar se as rotas estão carregadas
echo -e "\n2. Verificar rotas de colaboradores:"
cd /root/projeto_manager-1/laravel-project
php artisan route:list | grep colaboradores | head -5

# Testar acesso às páginas principais
echo -e "\n3. Testando acessos (deve retornar 302 para login):"

echo "- Página principal:"
curl -s -I http://localhost:8000/ | head -2

echo "- Login:"
curl -s -I http://localhost:8000/login | head -2

echo "- Colaboradores (deve redirecionar para login):"
curl -s -I http://localhost:8000/admin/colaboradores | head -2

echo "- Download template (deve redirecionar para login):"
curl -s -I http://localhost:8000/admin/colaboradores/download-template | head -2

# Verificar logs de erro do Nginx
echo -e "\n4. Últimos erros do Nginx:"
tail -n 10 /var/log/nginx/error.log 2>/dev/null || echo "Nenhum erro recente no Nginx"

# Verificar se há erros 404 nos logs do Laravel
echo -e "\n5. Procurar por erros 404 no Laravel:"
grep -i "404\|not found" /root/projeto_manager-1/laravel-project/storage/logs/laravel.log | tail -5 || echo "Nenhum erro 404 encontrado nos logs do Laravel"

# Verificar permissões
echo -e "\n6. Verificar permissões do público:"
ls -la /root/projeto_manager-1/laravel-project/public/index.php

# Verificar configuração do Nginx
echo -e "\n7. Configuração do Nginx:"
cat /etc/nginx/sites-enabled/projeto_manager | grep -E "listen|server_name|root"

echo -e "\n=== DIAGNÓSTICO COMPLETO ==="