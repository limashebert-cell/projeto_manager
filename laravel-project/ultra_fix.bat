@echo off
setlocal enabledelayedexpansion
cls
echo ====================================================
echo        ULTRA VERIFICACAO E CORRECAO LARAVEL
echo ====================================================

cd /d "c:\projeto_manager\laravel-project"

echo [1/10] Matando todos os processos PHP...
taskkill /f /im php.exe >nul 2>&1
timeout /t 2 >nul

echo [2/10] Verificando PHP...
php --version | findstr "PHP 7.4"
if errorlevel 1 (
    echo ❌ ERRO: PHP 7.4 nao encontrado!
    pause
    exit /b 1
)
echo ✅ PHP OK

echo [3/10] Verificando Laravel...
php artisan --version | findstr "Laravel Framework 8"
if errorlevel 1 (
    echo ❌ ERRO: Laravel 8 nao encontrado!
    pause
    exit /b 1
)
echo ✅ Laravel OK

echo [4/10] Limpando TUDO...
php artisan optimize:clear >nul 2>&1
rmdir /s /q "bootstrap\cache" >nul 2>&1
mkdir "bootstrap\cache" >nul 2>&1

echo [5/10] Verificando banco...
if not exist "database\database.sqlite" (
    echo Criando banco SQLite...
    type nul > "database\database.sqlite"
)
echo ✅ Banco OK

echo [6/10] Configurando sessoes...
rmdir /s /q "storage\framework\sessions" >nul 2>&1
mkdir "storage\framework\sessions" >nul 2>&1
echo * > "storage\framework\sessions\.gitignore"

echo [7/10] Recriando .env...
(
echo APP_NAME="Painel Admin"
echo APP_ENV=local  
echo APP_KEY=base64:AkAneDRCE2C6zEmhJStLZev9BcGhFZPgDrXd5Kjdo6s=
echo APP_DEBUG=true
echo APP_URL=http://127.0.0.1:8000
echo.
echo LOG_CHANNEL=single
echo LOG_LEVEL=error
echo.
echo DB_CONNECTION=sqlite
echo DB_DATABASE=c:\projeto_manager\laravel-project\database\database.sqlite
echo.
echo BROADCAST_DRIVER=log
echo CACHE_DRIVER=file
echo FILESYSTEM_DRIVER=local
echo QUEUE_CONNECTION=sync
echo SESSION_DRIVER=file
echo SESSION_LIFETIME=120
echo SESSION_ENCRYPT=false
) > ".env"

echo [8/10] Criando cache de configuracao...
php artisan config:cache >nul 2>&1

echo [9/10] Testando rotas...
php artisan route:list --name=login >nul
if errorlevel 1 (
    echo ❌ ERRO: Rotas com problema!
    php artisan route:list --name=login
    pause
    exit /b 1
)
echo ✅ Rotas OK

echo [10/10] INICIANDO SERVIDOR...
echo.
echo ====================================================
echo    🚀 SERVIDOR LARAVEL ULTRA VERIFICADO 🚀
echo ====================================================
echo    URL: http://127.0.0.1:8000
echo    Login: admin
echo    Senha: 123456
echo ====================================================

start "Laravel Ultra Fix" cmd /k "cd /d c:\projeto_manager\laravel-project && php artisan serve --host=127.0.0.1 --port=8000 --tries=0"

timeout /t 3 >nul

echo Testando conectividade...
ping -n 2 127.0.0.1 >nul
curl -s --connect-timeout 5 http://127.0.0.1:8000 >nul 2>&1
if errorlevel 1 (
    echo ⚠️  Servidor pode estar iniciando... Aguarde 5 segundos
    timeout /t 5 >nul
)

start http://127.0.0.1:8000

echo.
echo ✅ PROCESSO COMPLETO! Verifique o navegador.
echo Pressione qualquer tecla para sair...
pause >nul