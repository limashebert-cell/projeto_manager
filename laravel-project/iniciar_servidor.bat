@echo off
cls
echo ===========================================
echo      INICIANDO SERVIDOR LARAVEL OTIMIZADO
echo ===========================================

cd /d "c:\projeto_manager\laravel-project"

echo Verificando PHP...
php --version | findstr "PHP" >nul
if errorlevel 1 (
    echo ERRO: PHP nao encontrado!
    pause
    exit /b 1
)

echo Limpando cache e otimizando...
php artisan optimize:clear >nul 2>&1
php artisan config:cache >nul 2>&1

echo Aplicando configuracao otimizada...
copy ".env.development" ".env" >nul 2>&1

echo Verificando banco de dados...
if not exist "database\database.sqlite" (
    echo Criando banco SQLite...
    type nul > "database\database.sqlite"
)

echo Executando migracoes...
php artisan migrate --force >nul 2>&1

echo.
echo ===========================================
echo  SERVIDOR OTIMIZADO: http://127.0.0.1:8000
echo ===========================================
echo  Login: admin / Senha: 123456
echo ===========================================
echo.

REM Inicia o servidor com configurações de performance
start "Laravel Server Otimizado" php -c php_performance.ini artisan serve --host=127.0.0.1 --port=8000

echo Servidor iniciado com configuracoes otimizadas.
echo Pressione qualquer tecla para monitorar...
pause >nul

REM Abre o navegador automaticamente
start http://127.0.0.1:8000

echo Servidor rodando. Feche esta janela para parar o servidor.
pause >nul