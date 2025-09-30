#!/bin/bash

# Script para testar autenticação e acessos de páginas

# Criar uma sessão com curl
echo "Testando autenticação e acessos de páginas..."

# Primeiro, obtém os cookies da página inicial
COOKIE_JAR="/tmp/cookies.txt"
rm -f $COOKIE_JAR

# Obter CSRF token da página de login
echo "1. Obtendo CSRF token da página de login..."
curl -c $COOKIE_JAR -s "http://localhost/login" > /tmp/login.html

# Extrair o CSRF token
CSRF_TOKEN=$(grep -o 'name="_token" value="[^"]*' /tmp/login.html | cut -d'"' -f4)
echo "CSRF Token: $CSRF_TOKEN"

# Tentar autenticação
echo "2. Tentando login..."
curl -b $COOKIE_JAR -c $COOKIE_JAR -s -L -X POST "http://localhost/login" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -d "_token=$CSRF_TOKEN&username=admin&password=admin123" \
    -o /tmp/after_login.html

# Verificar se o login foi bem-sucedido
if grep -q "Dashboard" /tmp/after_login.html; then
    echo "Login bem-sucedido!"
else
    echo "Login falhou. Verifique as credenciais."
    # Pode ser útil ver o conteúdo da página para diagnóstico
    cat /tmp/after_login.html | head -n 20
    exit 1
fi

# Testar acesso à página do dashboard
echo "3. Testando acesso ao dashboard..."
curl -b $COOKIE_JAR -c $COOKIE_JAR -s -L "http://localhost/admin" -o /tmp/dashboard.html

# Testar acesso à página de quase acidentes
echo "4. Testando acesso à página de quase acidentes..."
curl -b $COOKIE_JAR -c $COOKIE_JAR -s -L "http://localhost/admin/quase-acidentes" -o /tmp/quase_acidentes.html

# Verificar se há erros 500
if grep -q "500" /tmp/quase_acidentes.html || grep -q "Server Error" /tmp/quase_acidentes.html; then
    echo "ERRO: A página de quase acidentes retornou erro 500!"
    cat /tmp/quase_acidentes.html | head -n 50
else
    echo "Página de quase acidentes carregada com sucesso!"
fi

echo "5. Verificando outras páginas com possíveis erros 500..."
# Lista de páginas para testar
PAGES=(
    "admin/colaboradores"
    "admin/presencas"
    "admin/presencas/historico"
    "admin/auditoria"
    "admin/timeclock"
    "admin/users"
)

for PAGE in "${PAGES[@]}"; do
    echo "Testando acesso à página: $PAGE"
    curl -b $COOKIE_JAR -c $COOKIE_JAR -s -L "http://localhost/$PAGE" -o /tmp/page_test.html
    
    if grep -q "500" /tmp/page_test.html || grep -q "Server Error" /tmp/page_test.html; then
        echo "ERRO: A página $PAGE retornou erro 500!"
    else
        echo "Página $PAGE carregada com sucesso!"
    fi
done

echo "Testes completos!"