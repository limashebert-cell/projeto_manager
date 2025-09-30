@echo off
cls
echo ========================================
echo    INICIANDO SERVIDOR LARAVEL - FIX
echo ========================================

cd /d "c:\projeto_manager\laravel-project"

echo Parando processos anteriores...
taskkill /f /im php.exe >nul 2>&1

echo Limpando cache...
php artisan config:clear >nul 2>&1

echo Verificando PHP...
php --version | findstr "PHP"

echo.
echo Tentativa 1: Artisan Serve (porta 8000)
echo ========================================
timeout /t 2 >nul
start "Laravel-8000" cmd /k "cd /d c:\projeto_manager\laravel-project && php artisan serve --host=127.0.0.1 --port=8000"

timeout /t 5 >nul

echo Testando conectividade...
curl -s -I http://127.0.0.1:8000 >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Servidor OK na porta 8000
    start http://127.0.0.1:8000
    goto end
)

echo.
echo Tentativa 2: PHP direto (porta 8001)
echo ========================================
cd public
start "Laravel-Direct-8001" cmd /k "php -S 127.0.0.1:8001"
cd ..

timeout /t 3 >nul
start http://127.0.0.1:8001

:end
echo.
echo Servidores iniciados! Verifique as janelas abertas.
echo Pressione qualquer tecla para sair...
pause >nul