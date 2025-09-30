#!/bin/bash

echo "=== TESTE DE DOWNLOAD TEMPLATE COM AUTENTICAÇÃO ==="

# Criar arquivo temporário para cookies
COOKIE_JAR="/tmp/test_cookies.txt"
rm -f $COOKIE_JAR

echo "1. Obtendo página de login..."
LOGIN_PAGE=$(curl -s -c $COOKIE_JAR "http://72.60.125.120:8000/login")

# Extrair token CSRF
CSRF_TOKEN=$(echo "$LOGIN_PAGE" | grep -o 'name="_token" value="[^"]*' | cut -d'"' -f4)
echo "Token CSRF obtido: $CSRF_TOKEN"

if [ -z "$CSRF_TOKEN" ]; then
    echo "ERRO: Não foi possível obter o token CSRF"
    exit 1
fi

echo "2. Fazendo login..."
LOGIN_RESULT=$(curl -s -b $COOKIE_JAR -c $COOKIE_JAR \
    -X POST "http://72.60.125.120:8000/login" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -d "_token=$CSRF_TOKEN&username=admin&password=admin123" \
    -L)

# Verificar se o login foi bem-sucedido
if echo "$LOGIN_RESULT" | grep -q "Dashboard\|Colaboradores\|Painel"; then
    echo "✓ Login realizado com sucesso!"
    
    echo "3. Testando download do template..."
    curl -b $COOKIE_JAR -I "http://72.60.125.120:8000/admin/colaboradores/download-template"
    
    echo "4. Fazendo download real do arquivo..."
    curl -b $COOKIE_JAR -o "/tmp/template_colaboradores.csv" "http://72.60.125.120:8000/admin/colaboradores/download-template"
    
    echo "5. Verificando arquivo baixado..."
    if [ -f "/tmp/template_colaboradores.csv" ]; then
        echo "✓ Arquivo baixado com sucesso!"
        echo "Tamanho do arquivo: $(wc -c < /tmp/template_colaboradores.csv) bytes"
        echo "Primeiras linhas:"
        head -3 "/tmp/template_colaboradores.csv"
    else
        echo "✗ Arquivo não foi baixado"
    fi
else
    echo "✗ Falha no login. Verificar credenciais."
    echo "Resposta do login (primeiras 200 chars):"
    echo "$LOGIN_RESULT" | head -c 200
fi

# Limpar arquivo de cookies
rm -f $COOKIE_JAR