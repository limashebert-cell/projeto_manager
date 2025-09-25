@echo off
echo ===================================
echo      INICIANDO LARAVEL
echo ===================================

cd /d "c:\projeto_manager\laravel-project"

echo Limpando cache...
php artisan config:clear >nul 2>&1

echo Iniciando servidor...
echo.
echo ===================================
echo  🌐 ACESSE: http://127.0.0.1:8000
echo  👤 Login: admin
echo  🔑 Senha: 123456
echo ===================================
echo.

php artisan serve --host=127.0.0.1 --port=8000

pause