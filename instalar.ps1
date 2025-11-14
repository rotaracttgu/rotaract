# Script de instalación automática del Sistema de Pestañas para Super Admin
# Ejecutar desde la raíz del proyecto Laravel

Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host "  Sistema de Pestañas para Super Administrador - Instalación" -ForegroundColor Cyan
Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host ""

# Verificar que estamos en la carpeta correcta
if (-not (Test-Path "artisan")) {
    Write-Host "ERROR: No se encontró el archivo 'artisan'" -ForegroundColor Red
    Write-Host "Por favor, ejecuta este script desde la raíz de tu proyecto Laravel" -ForegroundColor Yellow
    exit 1
}

Write-Host "[1/5] Creando estructura de carpetas..." -ForegroundColor Green
$partidalsPath = "resources\views\modulos\admin\partials"
if (-not (Test-Path $partidalsPath)) {
    New-Item -ItemType Directory -Path $partidalsPath -Force | Out-Null
    Write-Host "  ✓ Carpeta partials creada" -ForegroundColor Gray
} else {
    Write-Host "  ✓ Carpeta partials ya existe" -ForegroundColor Gray
}

Write-Host ""
Write-Host "[2/5] Haciendo backup del dashboard actual..." -ForegroundColor Green
$dashboardPath = "resources\views\modulos\admin\dashboard.blade.php"
$backupPath = "resources\views\modulos\admin\dashboard-backup-" + (Get-Date -Format "yyyyMMdd-HHmmss") + ".blade.php"

if (Test-Path $dashboardPath) {
    Copy-Item $dashboardPath $backupPath
    Write-Host "  ✓ Backup creado: $backupPath" -ForegroundColor Gray
} else {
    Write-Host "  ⚠ No se encontró dashboard.blade.php (se creará uno nuevo)" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "[3/5] Copiando archivos nuevos..." -ForegroundColor Green

# Verificar que los archivos de origen existan
$sourceFiles = @(
    @{Source="dashboard-superadmin-tabs.blade.php"; Dest="resources\views\modulos\admin\dashboard-nuevo.blade.php"},
    @{Source="overview-partial.blade.php"; Dest="resources\views\modulos\admin\partials\overview.blade.php"}
)

foreach ($file in $sourceFiles) {
    if (Test-Path $file.Source) {
        Copy-Item $file.Source $file.Dest -Force
        Write-Host "  ✓ Copiado: $($file.Dest)" -ForegroundColor Gray
    } else {
        Write-Host "  ✗ ERROR: No se encontró $($file.Source)" -ForegroundColor Red
        Write-Host "    Asegúrate de tener los archivos descargados en la carpeta actual" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "[4/5] Verificando archivos..." -ForegroundColor Green

$requiredFiles = @(
    "resources\views\modulos\admin\dashboard-nuevo.blade.php",
    "resources\views\modulos\admin\partials\overview.blade.php"
)

$allFilesExist = $true
foreach ($file in $requiredFiles) {
    if (Test-Path $file) {
        $size = (Get-Item $file).Length
        Write-Host "  ✓ $file ($size bytes)" -ForegroundColor Gray
    } else {
        Write-Host "  ✗ $file no encontrado" -ForegroundColor Red
        $allFilesExist = $false
    }
}

if (-not $allFilesExist) {
    Write-Host ""
    Write-Host "ERROR: Faltan archivos necesarios" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "[5/5] Instalación completada!" -ForegroundColor Green
Write-Host ""
Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host "  PRÓXIMOS PASOS:" -ForegroundColor Cyan
Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Abre: app\Http\Controllers\Admin\DashboardController.php" -ForegroundColor Yellow
Write-Host "   Agrega el método 'indexTabs()' (ver INSTRUCCIONES-INSTALACION.md)" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Abre: routes\web.php" -ForegroundColor Yellow
Write-Host "   Cambia la ruta del dashboard a:" -ForegroundColor Gray
Write-Host "   Route::get('/dashboard', [DashboardController::class, 'indexTabs'])->name('dashboard');" -ForegroundColor White
Write-Host ""
Write-Host "3. Para probar el nuevo dashboard:" -ForegroundColor Yellow
Write-Host "   - Inicia sesión como Super Admin" -ForegroundColor Gray
Write-Host "   - Navega a /admin/dashboard" -ForegroundColor Gray
Write-Host ""
Write-Host "4. Si algo sale mal, restaura el backup:" -ForegroundColor Yellow
Write-Host "   Copy-Item '$backupPath' '$dashboardPath' -Force" -ForegroundColor White
Write-Host ""
Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host "  Lee INSTRUCCIONES-INSTALACION.md para más detalles" -ForegroundColor Cyan
Write-Host "==================================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "¡Disfruta tu nuevo panel de Super Administrador! 🚀" -ForegroundColor Green
Write-Host ""

# Preguntar si quiere abrir las instrucciones
$response = Read-Host "¿Quieres abrir las instrucciones ahora? (S/N)"
if ($response -eq "S" -or $response -eq "s") {
    if (Test-Path "INSTRUCCIONES-INSTALACION.md") {
        Start-Process "INSTRUCCIONES-INSTALACION.md"
    } else {
        Write-Host "No se encontró INSTRUCCIONES-INSTALACION.md" -ForegroundColor Red
    }
}
