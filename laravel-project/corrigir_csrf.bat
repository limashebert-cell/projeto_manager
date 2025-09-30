@echo off
cls
echo =====================================================
echo           CORRECAO COMPLETA - ERRO 419 CSRF
echo =====================================================

cd /d "c:\projeto_manager\laravel-project"

echo [1/8] Limpando cache completo...
php artisan optimize:clear >nul 2>&1

echo [2/8] Removendo arquivos de sessao antigos...
del /q "storage\framework\sessions\*" >nul 2>&1

echo [3/8] Recriando diretorio de sessoes...
rmdir /s /q "storage\framework\sessions" >nul 2>&1
mkdir "storage\framework\sessions" >nul 2>&1

echo [4/8] Configurando permissoes...
echo. > "storage\framework\sessions\.gitignore"
echo * >> "storage\framework\sessions\.gitignore"
echo !.gitignore >> "storage\framework\sessions\.gitignore"

echo [5/8] Aplicando configuracao otimizada...
(
echo APP_NAME="Painel Admin"
echo APP_ENV=local
echo APP_KEY=base64:AkAneDRCE2C6zEmhJStLZev9BcGhFZPgDrXd5Kjdo6s=
echo APP_DEBUG=true
echo APP_URL=http://127.0.0.1:8000
echo.
echo LOG_CHANNEL=single
echo LOG_LEVEL=debug
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
echo.
echo MAIL_MAILER=smtp
echo MAIL_HOST=mailhog
echo MAIL_PORT=1025
) > ".env"

echo [6/8] Criando cache de configuracao...
php artisan config:cache >nul 2>&1

echo [7/8] Verificando banco de dados...
if not exist "database\database.sqlite" (
    echo Criando banco SQLite...
    type nul > "database\database.sqlite"
)

echo [8/8] Iniciando servidor...
echo.
echo =====================================================
echo  SERVIDOR CORRIGIDO: http://127.0.0.1:8000
echo =====================================================
echo  Login: admin / Senha: 123456
echo  CSRF Token: Corrigido
echo =====================================================
echo.

start "Laravel Server - CSRF Corrigido" php artisan serve --host=127.0.0.1 --port=8000

timeout /t 3 >nul
start http://127.0.0.1:8000

echo Servidor iniciado! Teste o login agora.
pause