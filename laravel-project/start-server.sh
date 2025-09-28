#!/bin/bash

# 🚀 Script de Inicialização do Laravel no Ubuntu
# Autor: GitHub Copilot
# Data: $(date)

echo "🚀 Iniciando servidor Laravel..."
echo "📍 Diretório: /root/projeto_manager/laravel-project"
echo "🌐 URL: http://0.0.0.0:8000"
echo "👤 Login: admin | Senha: password"
echo ""

# Navegar para o diretório do projeto
cd /root/projeto_manager/laravel-project

# Verificar se existe arquivo .env
if [ ! -f ".env" ]; then
    echo "❌ Arquivo .env não encontrado!"
    echo "📝 Copiando .env.example para .env..."
    cp .env.example .env
    echo "🔑 Gerando nova chave de aplicação..."
    php artisan key:generate
fi

# Verificar se existe banco de dados
if [ ! -f "database/database.sqlite" ]; then
    echo "🗄️ Criando banco de dados SQLite..."
    touch database/database.sqlite
    echo "🔄 Executando migrations..."
    php artisan migrate --force
fi

# Limpar cache
echo "🧹 Limpando cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Verificar se as dependências estão instaladas
if [ ! -d "vendor" ]; then
    echo "📦 Instalando dependências do Composer..."
    composer install --no-dev
fi

# Iniciar servidor
echo ""
echo "✅ Tudo pronto! Iniciando servidor Laravel..."
echo "🛑 Para parar o servidor, pressione Ctrl+C"
echo ""

# Iniciar o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000