@echo off
title Monitor de Estabilidade - Laravel

:monitor
cls
echo ========================================
echo     MONITOR DE ESTABILIDADE LARAVEL
echo ========================================
echo.
echo Servidor: http://127.0.0.1:8080
echo Status: Verificando...
echo.

REM Verifica se o servidor está respondendo
curl -s -o nul -w "Status: %%{http_code}" http://127.0.0.1:8080
if errorlevel 1 (
    echo OFFLINE - Tentando reiniciar...
    taskkill /f /im php.exe >nul 2>&1
    timeout /t 2 >nul
    cd /d "c:\projeto_manager\laravel-project"
    start "Laravel Server" php artisan serve --host=127.0.0.1 --port=8080
    echo Servidor reiniciado!
) else (
    echo ONLINE
)

echo.
echo Uso de memoria PHP:
wmic process where "name='php.exe'" get ProcessId,WorkingSetSize /format:table

echo.
echo Pressione Ctrl+C para parar o monitoramento
echo Proximo check em 10 segundos...
timeout /t 10 >nul
goto monitor