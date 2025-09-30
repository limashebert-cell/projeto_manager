#!/bin/bash

echo "Verificando status completo do VPS..."

# Verificar serviços
echo -e "\n=== STATUS DOS SERVIÇOS ==="
systemctl is-active nginx && echo "✓ Nginx: Ativo" || echo "✗ Nginx: Inativo"
systemctl is-active mariadb && echo "✓ MariaDB: Ativo" || echo "✗ MariaDB: Inativo"  
systemctl is-active php8.3-fpm && echo "✓ PHP-FPM: Ativo" || echo "✗ PHP-FPM: Inativo"

# Verificar portas
echo -e "\n=== PORTAS ABERTAS ==="
netstat -tlnp | grep :8000 && echo "✓ Porta 8000: Aberta" || echo "✗ Porta 8000: Fechada"

# Testar conectividade
echo -e "\n=== TESTE DE CONECTIVIDADE ==="
curl -s -I http://localhost:8000/login | head -n 1 && echo "✓ Acesso local: OK" || echo "✗ Acesso local: Falhou"
curl -s -I http://72.60.125.120:8000/login | head -n 1 && echo "✓ Acesso externo: OK" || echo "✗ Acesso externo: Falhou"

# Verificar banco de dados
echo -e "\n=== BANCO DE DADOS ==="
mysql -u pm_user -p'@Hebert19890' -e "SELECT 1" >/dev/null 2>&1 && echo "✓ Conexão BD: OK" || echo "✗ Conexão BD: Falhou"

# Verificar permissões
echo -e "\n=== PERMISSÕES ==="
[ -r /root/projeto_manager-1/laravel-project/public/index.php ] && echo "✓ Permissões público: OK" || echo "✗ Permissões público: Problema"
[ -w /root/projeto_manager-1/laravel-project/storage ] && echo "✓ Permissões storage: OK" || echo "✗ Permissões storage: Problema"

echo -e "\n=== RESUMO ==="
echo "Acesse o site em: http://72.60.125.120:8000/login"
echo "Login: admin"
echo "Senha: admin123"
echo ""
echo "Se o site ainda não estiver acessível externamente, verifique:"
echo "1. Firewall do provedor VPS (painel de controle)"
echo "2. Configurações de rede do servidor"
echo "3. Regras de segurança do datacenter"