@echo off
echo --- Exportando Banco de Dados Local (LosFit) ---
echo.

set MYSQL_PATH=c:\xampp\mysql\bin\mysqldump.exe
set DB_NAME=ecommerce
set OUTPUT_FILE=backup_losfit.sql

if not exist "%MYSQL_PATH%" (
    echo [ERRO] Nao encontrei o mysqldump em: %MYSQL_PATH%
    echo Verifique se o XAMPP esta instalado em C:\xampp
    pause
    exit /b
)

echo Tentando exportar o banco '%DB_NAME%'...
echo (Se pedir senha e voce nao tiver configurado, apenas aperte ENTER)
echo.

"%MYSQL_PATH%" -u root -p %DB_NAME% > %OUTPUT_FILE%

if %ERRORLEVEL% equ 0 (
    echo.
    echo [SUCESSO] Arquivo gerado: %OUTPUT_FILE%
    echo.
    echo AGORA:
    echo 1. Acesse o PHPMyAdmin da Hostinger (Banco u488238372_losfit)
    echo 2. Clique em 'Importar'
    echo 3. Selecione o arquivo '%OUTPUT_FILE%' que esta nesta pasta.
) else (
    echo.
    echo [ERRO] Falha ao exportar. Verifique se o nome do banco local eh '%DB_NAME%'.
)

pause
