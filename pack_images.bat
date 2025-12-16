@echo off
echo --- Compactando Imagens Locais (LosFit) ---
echo.

set TARGET_DIR=storage\app\public
set OUTPUT_FILE=imagens_losfit.zip

if not exist "%TARGET_DIR%" (
    echo [ERRO] Pasta de imagens nao encontrada: %TARGET_DIR%
    pause
    exit /b
)

echo Compactando conteudo de '%TARGET_DIR%'...
echo Isso pode levar alguns segundos...

powershell -Command "Compress-Archive -Path '%TARGET_DIR%\*' -DestinationPath '%OUTPUT_FILE%' -Force"

if %ERRORLEVEL% equ 0 (
    echo.
    echo [SUCESSO] Arquivo gerado: %OUTPUT_FILE%
    echo.
    echo AGORA (Na Hostinger):
    echo 1. Va no Gerenciador de Arquivos
    echo 2. Entre na pasta 'ecommerce-hp/storage/app/public'
    echo 3. Faca UPLOAD deste arquivo zip.
    echo 4. Clique com botao direito e 'Extrair' (Extract).
) else (
    echo.
    echo [ERRO] Falha ao criar zip.
)

pause
