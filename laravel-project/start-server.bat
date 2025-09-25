@echo off
cd /d "C:\projeto_manager\laravel-project"

:start
echo [%date% %time%] Iniciando servidor Laravel...
php artisan serve --host=0.0.0.0 --port=8080
echo [%date% %time%] Servidor parou. Reiniciando em 3 segundos...
timeout /t 3 /nobreak > nul
goto start