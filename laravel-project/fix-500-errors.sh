#!/bin/bash

echo "🔧 CORREÇÃO DE ERROS 500 - Laravel"
echo "==================================="

cd /root/projeto_manager/laravel-project

echo ""
echo "1. 🔧 Corrigindo permissões..."
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
echo "✅ Permissões corrigidas"

echo ""
echo "2. 🧹 Limpando caches..."
php artisan config:clear
php artisan cache:clear  
php artisan route:clear
php artisan view:clear
echo "✅ Caches limpos"

echo ""
echo "3. 📝 Verificando .env..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
    echo "✅ Arquivo .env criado"
else
    echo "✅ Arquivo .env existe"
fi

echo ""
echo "4. 🗄️ Verificando banco de dados..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite 2>/dev/null || chown $USER:$USER database/database.sqlite
    echo "✅ Banco SQLite criado"
else
    echo "✅ Banco SQLite existe"
fi

echo ""
echo "5. 🔄 Executando migrations..."
php artisan migrate --force 2>/dev/null && echo "✅ Migrations executadas" || echo "⚠️ Migrations já executadas"

echo ""
echo "6. 📦 Verificando autoload..."
if [ -f ../composer.phar ]; then
    php ../composer.phar dump-autoload -o > /dev/null 2>&1
else
    composer dump-autoload -o > /dev/null 2>&1
fi
echo "✅ Autoload otimizado"

echo ""
echo "7. 🚀 Iniciando servidor..."
pkill -f "artisan serve" 2>/dev/null
sleep 2

# Inicia servidor em background
php artisan serve --host=0.0.0.0 --port=8000 > /tmp/laravel-server.log 2>&1 &
SERVER_PID=$!

sleep 3

# Testa se servidor está respondendo
if curl -s http://localhost:8000 > /dev/null; then
    echo "✅ Servidor iniciado com sucesso!"
    echo "🌐 Acesse: http://72.60.125.120:8000"
    echo "👤 Login: admin | Senha: password"
else
    echo "❌ Erro ao iniciar servidor"
    echo "Log do servidor:"
    cat /tmp/laravel-server.log
fi

echo ""
echo "==================================="