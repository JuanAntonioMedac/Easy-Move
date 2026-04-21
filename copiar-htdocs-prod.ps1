# Stop on any error
$ErrorActionPreference = 'Stop'

# Rutas locales
$root   = Split-Path -Parent $MyInvocation.MyCommand.Path
$source = Join-Path $root 'htdocs'
$target = Join-Path $root 'htdocs-prod'

# Verifica carpeta de origen
if (-not (Test-Path -LiteralPath $source -PathType Container)) {
    throw "No existe la carpeta origen: $source"
}

# Borra destino previo con limpieza profunda
if (Test-Path -LiteralPath $target) {
    Remove-Item -LiteralPath $target -Recurse -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 1 # Pequeña pausa para q Windows termine de soltar handles de carpetas
}

New-Item -ItemType Directory -Path $target | Out-Null

# Lista blanca de archivos y carpetas
$includeItems = @(
    'app',
    'bootstrap',
    'config',
    'database',
    'public',
    'resources',
    'routes',
    'storage',
    'vendor',
    'artisan',
    'composer.json',
    'composer.lock'
    
)

foreach ($item in $includeItems) {
    $srcPath = Join-Path $source $item
    if (Test-Path -LiteralPath $srcPath) {
        Copy-Item -LiteralPath $srcPath -Destination $target -Recurse -Force
    }
}

# Exclusiones por seguridad
$excludeFilePatterns = @(
    '.env',
    '.env.*',
    'phpunit.xml',
    'package.json',
    'package-lock.json',
    'yarn.lock',
    'pnpm-lock.yaml',
    'vite.config.js',
    'postcss.config.js',
    'tailwind.config.js',
    '*.sql',
    'hot'
)

foreach ($pattern in $excludeFilePatterns) {
    Get-ChildItem -Path $target -Recurse -File -Filter $pattern -ErrorAction SilentlyContinue |
        Remove-Item -Force -ErrorAction SilentlyContinue
}

$excludeDirs = @(
    'tests',
    'node_modules',
    '.git',
    '.github',
    'storage\logs',
    'storage\framework\cache',
    'storage\framework\sessions',
    'storage\framework\testing',
    'storage\framework\views',
    'bootstrap\cache',
    'resources\css',
    'resources\js'
)

foreach ($dir in $excludeDirs) {
    $dirPath = Join-Path $target $dir
    if (Test-Path -LiteralPath $dirPath) {
        Remove-Item -LiteralPath $dirPath -Recurse -Force
    }
}

# Recrea directorios runtime necesarios
$runtimeDirs = @(
    'storage\framework\cache\data',
    'storage\framework\sessions',
    'storage\framework\views',
    'storage\logs',
    'bootstrap\cache'
)

foreach ($dir in $runtimeDirs) {
    New-Item -ItemType Directory -Path (Join-Path $target $dir) -Force | Out-Null
}

# Crear archivo .gitkeep para asegurar permisos en hosting gratuito
foreach ($dir in $runtimeDirs) {
    $keepFile = Join-Path $target $dir
    $keepFile = Join-Path $keepFile '.gitkeep'
    New-Item -ItemType File -Path $keepFile -Force | Out-Null
}

# Manejo de Vite omitido: public/build ya fue empaquetado y copiado en public/

Write-Host "¡Empaquetado completado! Listo para subir a producción." -ForegroundColor Green