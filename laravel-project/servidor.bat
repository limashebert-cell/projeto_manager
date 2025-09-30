@echo off
title Projeto Manager - Servidor Laravel
cd /d "C:\projeto_manager\laravel-project"

echo [SISTEMA] Iniciando Projeto Manager...
echo [SISTEMA] Limpando cache...

php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1

echo [SISTEMA] Cache limpo com sucesso!
echo [SISTEMA] Verificando permissoes...

:: Criar diretórios se não existirem
if not exist "storage\logs" mkdir storage\logs
if not exist "storage\framework\cache" mkdir storage\framework\cache
if not exist "storage\framework\sessions" mkdir storage\framework\sessions
if not exist "storage\framework\views" mkdir storage\framework\views

echo [SISTEMA] Estrutura verificada!
echo [SISTEMA] Iniciando servidor na porta 3000...
echo [INFO] Acesse: http://localhost:3000
echo [INFO] Para parar o servidor: Ctrl+C
echo.

:start
php artisan serve --host=0.0.0.0 --port=3000 --tries=0

if %errorlevel% neq 0 (
    echo [ERRO] Servidor parou inesperadamente! Tentando reiniciar em 3 segundos...
    timeout /t 3 /nobreak >nul
    goto start
) else (
    echo [INFO] Servidor encerrado normalmente.
)

pause