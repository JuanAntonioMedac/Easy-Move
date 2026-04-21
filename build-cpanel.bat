@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion

REM ============================================================
REM  EASY-MOVE - COMPILADOR PARA CPANEL
REM  Solución Profesional para Deploy en cPanel
REM ============================================================

color 0A
cls
title Easy-Move - Build para cPanel

echo.
echo    ███████████████████████████████████████████████████████
echo    ██                                                     ██
echo    ██          EASY-MOVE - BUILD PARA CPANEL            ██
echo    ██                                                     ██
echo    ███████████████████████████████████████████████████████
echo.

REM ============================================================
REM  VARIABLES GLOBALES
REM ============================================================

set BUILD_DIR=Easy-Move-Production
set ZIP_FILE=Easy-Move-Production.zip
set BACKUP_ZIP=Easy-Move-Backup-%date:~-4%%date:~-10,2%%date:~-7,2%-%time:~0,2%%time:~3,2%.zip
set TIMESTAMP=%date% %time%
set FOLDERS_TO_COPY=app bootstrap config database public resources routes storage vendor
set FILES_TO_COPY=.env.example artisan composer.json composer.lock package.json package-lock.json vite.config.js tailwind.config.js postcss.config.js phpunit.xml README.md
set FOLDERS_TO_EXCLUDE=node_modules .git tests .vscode .idea __pycache__ .pytest_cache

REM ============================================================
REM  VALIDACIONES INICIALES
REM ============================================================

echo [*] Validando ambiente...
if not exist "composer.json" (
    color 0C
    echo.
    echo    ERROR: Este script debe ejecutarse desde la raiz del proyecto
    echo    Ubicación esperada: C:\xampp\htdocs\Easy-Move\
    echo    Ubicación actual:   %cd%
    echo.
    pause
    exit /b 1
)

if not exist "npm" (
    for /f %%i in ('where npm') do set NPM_PATH=%%i
    if "!NPM_PATH!"=="" (
        echo    ⚠️  ADVERTENCIA: npm no encontrado en PATH
        echo    Pero continuaremos (asumimos que ya compilaste npm run build)
        echo.
    )
)

echo    ✓ Proyecto detectado correctamente
echo.

REM ============================================================
REM  CREAR DIRECTORIO DE BUILD
REM ============================================================

echo [*] Preparando estructura...

if exist "%BUILD_DIR%" (
    echo    Limpiando build anterior...
    rmdir /s /q "%BUILD_DIR%" 2>nul
    timeout /t 1 /nobreak >nul
)

mkdir "%BUILD_DIR%"
if errorlevel 1 (
    color 0C
    echo    ERROR: No se pudo crear carpeta de build
    pause
    exit /b 1
)

echo    ✓ Carpeta de build creada: %BUILD_DIR%\
echo.

REM ============================================================
REM  COPIAR CARPETAS PRINCIPALES
REM ============================================================

echo [*] Copiando carpetas principales (esto puede tardar)...

setlocal enabledelayedexpansion
set count=0
for %%A in (%FOLDERS_TO_COPY%) do (
    if exist "%%A" (
        xcopy "%%A" "%BUILD_DIR%\%%A" /E /I /Y /Q 2>nul
        set /a count+=1
        echo    ✓ Carpeta: %%A
    )
)

echo    Total de carpetas copiadas: !count!
echo.

REM ============================================================
REM  COPIAR ARCHIVOS DE CONFIGURACION
REM ============================================================

echo [*] Copiando archivos de configuración...

set count=0
for %%A in (%FILES_TO_COPY%) do (
    if exist "%%A" (
        copy "%%A" "%BUILD_DIR%\%%A" /Y >nul 2>&1
        set /a count+=1
        echo    ✓ Archivo: %%A
    )
)

echo    Total de archivos copiados: !count!
echo.

REM ============================================================
REM  VALIDACIONES DE SEGURIDAD
REM ============================================================

echo [*] Aplicando validaciones de seguridad...

if exist "%BUILD_DIR%\.env" (
    del "%BUILD_DIR%\.env"
    echo    ✓ Archivo .env eliminado (por seguridad)
)

if exist "%BUILD_DIR%\.env.local" (
    del "%BUILD_DIR%\.env.local"
    echo    ✓ Archivo .env.local eliminado (por seguridad)
)

if exist "%BUILD_DIR%\.git" (
    rmdir /s /q "%BUILD_DIR%\.git" 2>nul
    echo    ✓ Carpeta .git eliminada
)

if exist "%BUILD_DIR%\node_modules" (
    rmdir /s /q "%BUILD_DIR%\node_modules" 2>nul
    echo    ✓ Carpeta node_modules eliminada
)

if exist "%BUILD_DIR%\tests" (
    rmdir /s /q "%BUILD_DIR%\tests" 2>nul
    echo    ✓ Carpeta tests eliminada
)

echo.

REM ============================================================
REM  CREAR ARCHIVO DE INSTRUCCIONES
REM ============================================================

echo [*] Generando archivo de instrucciones...

(
echo EASY-MOVE - INSTRUCCIONES DE DEPLOY EN CPANEL
echo =============================================
echo.
echo Fecha de generación: %TIMESTAMP%
echo.
echo 1. SUBIR ARCHIVO ZIP
echo    =====================
echo    - Usar File Manager de cPanel o SFTP
echo    - Subir a: /public_html/ o /public_html/Easy-Move/
echo    - Archivo: Easy-Move-Production.zip
echo.
echo 2. EXTRAER ZIP
echo    =============
echo    - En cPanel File Manager, click derecho en ZIP
echo    - Seleccionar "Extract"
echo    - Esperar a que termine
echo.
echo 3. CREAR .env
echo    ===========
echo    - Renombrar: .env.example a .env
echo    - O copiar .env.example y renombrar
echo    - Editar el archivo .env con las credenciales
echo.
echo 4. CONFIGURAR .env CON CREDENCIALES
echo    ==================================
echo.
echo    A. Base de Datos:
echo       DB_HOST=localhost
echo       DB_DATABASE=usuario_easymove     (tu BD en cPanel)
echo       DB_USERNAME=usuario_easymove     (tu usuario en cPanel)
echo       DB_PASSWORD=tu_password_segura   (la contraseña que creaste)
echo.
echo    B. Email SMTP (Gmail):
echo       MAIL_MAILER=smtp
echo       MAIL_HOST=smtp.gmail.com
echo       MAIL_PORT=587
echo       MAIL_USERNAME=tu_email@gmail.com
echo       MAIL_PASSWORD=tu_app_password    (NO tu contraseña normal)
echo       MAIL_FROM_ADDRESS=noreply@easymove.net
echo.
echo    C. Aplicación:
echo       APP_ENV=production
echo       APP_DEBUG=false
echo       APP_URL=https://tudominio.com
echo.
echo 5. CREAR BASE DE DATOS EN CPANEL
echo    ===============================
echo    - Ve a cPanel > MySQL Databases
echo    - Create New Database: usuario_easymove
echo    - Create MySQL User: usuario_easymove
echo    - Add user to database con ALL PRIVILEGES
echo.
echo 6. IMPORTAR SCHEMA SQL
echo    ====================
echo    - Ve a cPanel > phpMyAdmin
echo    - Selecciona tu BD: usuario_easymove
echo    - Pestaña "Import"
echo    - Selecciona: database/schema.sql
echo    - Click "Go"
echo.
echo 7. PERMISOS EN ARCHIVOS
echo    ======================
echo    En cPanel File Manager:
echo    - Click derecho en carpeta "storage" > Permissions > 755
echo    - Click derecho en carpeta "bootstrap/cache" > Permissions > 755
echo.
echo 8. VERIFICAR INSTALACION
echo    ======================
echo    - Accede a https://tudominio.com
echo    - Debería cargar la página de inicio
echo.
echo 9. TROUBLESHOOTING
echo    ================
echo    Si hay errores:
echo    - Revisa que la BD está creada
echo    - Verifica credenciales en .env
echo    - Asegúrate de que storage tiene permisos 755
echo    - Checa que vendor/ está completo
echo    - Prueba con database/schema.sql importado
echo.
echo NOTAS IMPORTANTES
echo ==================
echo - NO compartir .env en repositorio
echo - APP_KEY es generado por composer
echo - Necesita PHP 8.2+
echo - MySQL 8.0+ recomendado
echo.
echo CONTACTO Y SOPORTE
echo ===================
echo Documentación: README.md
echo Documentación Técnica: DOCUMENTACION_TECNICA.md
echo.
) > "%BUILD_DIR%\INSTRUCCIONES_CPANEL.txt"

echo    ✓ Archivo INSTRUCCIONES_CPANEL.txt generado
echo.

REM ============================================================
REM  COMPRIMIR EN ZIP
REM ============================================================

echo [*] Comprimiendo en ZIP...
echo    Esto puede tardar algunos minutos...
echo.

set ZIP_SUCCESS=0

REM Intenta con 7-Zip (mejor compresión)
if exist "C:\Program Files\7-Zip\7z.exe" (
    echo    Usando 7-Zip...
    "C:\Program Files\7-Zip\7z.exe" a -r "%ZIP_FILE%" "%BUILD_DIR%" -bb0 >nul 2>&1
    if !errorlevel! equ 0 set ZIP_SUCCESS=1
) else if exist "C:\Program Files (x86)\7-Zip\7z.exe" (
    echo    Usando 7-Zip (x86)...
    "C:\Program Files (x86)\7-Zip\7z.exe" a -r "%ZIP_FILE%" "%BUILD_DIR%" -bb0 >nul 2>&1
    if !errorlevel! equ 0 set ZIP_SUCCESS=1
)

REM Si 7-Zip no funciona, usa PowerShell
if !ZIP_SUCCESS! equ 0 (
    echo    Usando PowerShell...
    powershell -NoProfile -Command "Compress-Archive -Path '%BUILD_DIR%\*' -DestinationPath '%ZIP_FILE%' -Force -ErrorAction Stop" 2>nul
    if !errorlevel! equ 0 set ZIP_SUCCESS=1
)

REM Si nada funciona, error
if !ZIP_SUCCESS! equ 0 (
    color 0C
    echo.
    echo    ERROR: No se pudo crear el ZIP
    echo    Instala 7-Zip o actualiza PowerShell
    echo.
    pause
    exit /b 1
)

echo    ✓ ZIP creado exitosamente
echo.

REM ============================================================
REM  LIMPIAR CARPETA TEMPORAL
REM ============================================================

echo [*] Limpiando archivos temporales...
rmdir /s /q "%BUILD_DIR%" >nul 2>&1
echo    ✓ Carpeta temporal eliminada
echo.

REM ============================================================
REM  INFORMACION FINAL
REM ============================================================

color 0B
cls
echo.
echo    ███████████████████████████████████████████████████████
echo    ██                                                     ██
echo    ██             BUILD COMPLETADO EXITOSAMENTE          ██
echo    ██                                                     ██
echo    ███████████████████████████████████████████████████████
echo.

REM Obtener tamaño del archivo ZIP
for /f "tokens=5" %%A in ('dir "%ZIP_FILE%" ^| findstr "%ZIP_FILE%"') do (
    set ZIP_SIZE=%%A
)

echo    📦 ARCHIVO GENERADO
echo    ==================
echo    Nombre:  %ZIP_FILE%
echo    Tamaño:  %ZIP_SIZE% bytes
echo.

echo    📋 CONTENIDO DEL ZIP
echo    ====================
echo    ✓ app/              - Código de la aplicación
echo    ✓ bootstrap/        - Bootstrap de Laravel
echo    ✓ config/           - Configuración
echo    ✓ database/         - Migraciones y schema.sql
echo    ✓ public/           - Assets compilados (CSS/JS)
echo    ✓ resources/        - Vistas Blade y fuentes
echo    ✓ routes/           - Definición de rutas
echo    ✓ storage/          - Carpeta de almacenamiento
echo    ✓ vendor/           - Dependencias PHP compiladas
echo    ✓ .env.example      - Configuración ejemplo
echo    ✓ artisan           - Comando artisan
echo    ✓ composer.json/.lock - Dependencias PHP
echo    ✓ package.json/.lock  - Dependencias JS
echo    ✓ vite.config.js    - Configuración Vite
echo    ✓ tailwind.config.js - Configuración Tailwind
echo    ✓ postcss.config.js - Configuración PostCSS
echo.

echo    ✗ EXCLUIDO (por seguridad)
echo    ============================
echo    ✗ node_modules/     - Se descarga con npm (no necesario)
echo    ✗ .env              - Archivo de producción (crea en cPanel)
echo    ✗ .git/             - Archivos de git
echo    ✗ tests/            - Archivos de testing
echo.

echo    🚀 PROXIMO PASO: SUBIR A CPANEL
echo    ===============================
echo.
echo    1. Abre el Administrador de Archivos (File Manager) en cPanel
echo.
echo    2. Navega a: /public_html/
echo.
echo    3. Sube el archivo: %ZIP_FILE%
echo       (Arrastra y suelta o usa botón Upload)
echo.
echo    4. Espera a que termine (2-5 minutos según velocidad)
echo.
echo    5. Click derecho en %ZIP_FILE% → Extract
echo.
echo    6. Lee el archivo: INSTRUCCIONES_CPANEL.txt
echo       (Está dentro del ZIP extraído)
echo.

echo    📖 ARCHIVOS DE AYUDA
echo    ====================
echo    • INSTRUCCIONES_CPANEL.txt - Guía paso a paso en cPanel
echo    • README.md                 - Documentación del proyecto
echo    • DOCUMENTACION_TECNICA.md  - Detalles técnicos
echo.

echo    ⚠️  IMPORTANTE
echo    ==============
echo    1. NO subas el archivo .env en producción
echo    2. Crea .env nuevo en cPanel editando .env.example
echo    3. Genera una contraseña FUERTE para la BD
echo    4. Usa App Password de Gmail (no tu contraseña normal)
echo    5. Permisos: chmod 755 storage y bootstrap/cache
echo.

echo    ✓ VERIFICA QUE TENGAS:
echo    ======================
echo    □ Hosting cPanel activo
echo    □ Base de datos MySQL
echo    □ Usuario MySQL creado
echo    □ Acceso a phpMyAdmin
echo    □ Credenciales de Email SMTP (Gmail)
echo.

echo    ███████████████████████████████████████████████████████
echo.
pause
