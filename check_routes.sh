#!/bin/bash

# Script simplificado para testar o acesso às rotas

echo "Habilitando o modo de depuração para visualizar erros detalhados..."

# Garantir que APP_DEBUG esteja habilitado no arquivo .env
if grep -q "APP_DEBUG=false" laravel-project/.env; then
    sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' laravel-project/.env
fi

# Criar um usuário admin se não existir
echo "Verificando se existe usuário admin..."
cd laravel-project
php artisan tinker --execute="
if (\\App\\Models\\AdminUser::where('username', 'admin')->count() == 0) {
    \\App\\Models\\AdminUser::create([
        'name' => 'Administrador',
        'username' => 'admin',
        'password' => 'admin123',
        'area' => 'TI',
        'role' => 'super_admin',
        'active' => 1
    ]);
    echo 'Usuário admin criado com sucesso!';
} else {
    echo 'Usuário admin já existe.';
}
"

echo "Limpando caches..."
php artisan optimize:clear

echo "Testando acesso direto às rotas com Artisan..."
php artisan route:list

echo "Verificando se o servidor web está configurado corretamente..."
cd ..
curl -I http://localhost/login

echo "Verificando permissões de arquivos e diretórios..."
find laravel-project/storage -type d -exec chmod 775 {} \;
find laravel-project/storage -type f -exec chmod 664 {} \;
chown -R www-data:www-data laravel-project/storage
chown -R www-data:www-data laravel-project/bootstrap/cache

echo "Verificando logs recentes do Laravel..."
tail -n 30 laravel-project/storage/logs/laravel.log

echo "Testes completos!"