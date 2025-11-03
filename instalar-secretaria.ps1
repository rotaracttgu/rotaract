# Script de Instalación del Módulo de Secretaría
# Para Windows PowerShell

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "   Instalación Módulo Secretaría    " -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Paso 1: Ejecutar el seeder
Write-Host "Paso 1: Ejecutando seeder..." -ForegroundColor Yellow
php artisan db:seed --class=SecretariaModuloSeeder

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Seeder ejecutado correctamente" -ForegroundColor Green
} else {
    Write-Host "✗ Error al ejecutar el seeder" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Paso 2: Limpiar caché
Write-Host "Paso 2: Limpiando caché..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan view:clear

Write-Host "✓ Caché limpiada correctamente" -ForegroundColor Green
Write-Host ""

# Paso 3: Verificar archivos
Write-Host "Paso 3: Verificando archivos..." -ForegroundColor Yellow

$archivos = @(
    "resources\views\modulos\secretaria\dashboard.blade.php",
    "app\Http\Controllers\SecretariaController.php",
    "database\seeders\SecretariaModuloSeeder.php"
)

$todosCorrecto = $true

foreach ($archivo in $archivos) {
    if (Test-Path $archivo) {
        Write-Host "  ✓ $archivo" -ForegroundColor Green
    } else {
        Write-Host "  ✗ $archivo - NO ENCONTRADO" -ForegroundColor Red
        $todosCorrecto = $false
    }
}

Write-Host ""

# Resumen
if ($todosCorrecto) {
    Write-Host "=====================================" -ForegroundColor Green
    Write-Host "   ¡Instalación Completada! ✓       " -ForegroundColor Green
    Write-Host "=====================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Accede al dashboard en:" -ForegroundColor Cyan
    Write-Host "http://localhost/secretaria/dashboard" -ForegroundColor White
    Write-Host ""
    Write-Host "Datos creados:" -ForegroundColor Cyan
    Write-Host "  • 3 consultas de ejemplo" -ForegroundColor White
    Write-Host "  • 2 actas (ordinaria y extraordinaria)" -ForegroundColor White
    Write-Host "  • 3 diplomas (reconocimiento, participación, excelencia)" -ForegroundColor White
    Write-Host "  • 4 documentos generales" -ForegroundColor White
    Write-Host ""
    Write-Host "Paleta de colores implementada:" -ForegroundColor Cyan
    Write-Host "  • Violeta (#9B01F3 → #631B47) - Consultas" -ForegroundColor Magenta
    Write-Host "  • Turquesa (#74B6C0 → #00ADDB) - Actas" -ForegroundColor Cyan
    Write-Host "  • Naranja (#FF7D00 → #C0A656) - Diplomas" -ForegroundColor Yellow
    Write-Host "  • Verde (#009759 → #C1C100) - Documentos" -ForegroundColor Green
    Write-Host ""
} else {
    Write-Host "=====================================" -ForegroundColor Red
    Write-Host "   Instalación Incompleta            " -ForegroundColor Red
    Write-Host "=====================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Por favor, verifica que todos los archivos estén presentes." -ForegroundColor Yellow
}

Write-Host "Presiona cualquier tecla para continuar..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
