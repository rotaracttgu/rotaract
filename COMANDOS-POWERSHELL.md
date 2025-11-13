# 🚀 GUÍA RÁPIDA DE INSTALACIÓN - Comandos PowerShell

## ⚡ INSTALACIÓN RÁPIDA (RECOMENDADA)

Abre PowerShell en la raíz de tu proyecto y ejecuta:

```powershell
# Ejecutar el script de instalación automática
.\instalar.ps1
```

---

## 📝 INSTALACIÓN MANUAL (Si prefieres hacerlo paso a paso)

### Paso 1: Crear estructura de carpetas

```powershell
# Navega a la raíz de tu proyecto
cd "C:\Users\Rodrigo Palma\Downloads\rotaract"

# Crea la carpeta partials
New-Item -ItemType Directory -Path "resources\views\modulos\admin\partials" -Force
```

### Paso 2: Hacer backup del dashboard actual

```powershell
# Crear backup con fecha y hora
$fecha = Get-Date -Format "yyyyMMdd-HHmmss"
Copy-Item "resources\views\modulos\admin\dashboard.blade.php" `
          "resources\views\modulos\admin\dashboard-backup-$fecha.blade.php"

Write-Host "✓ Backup creado: dashboard-backup-$fecha.blade.php" -ForegroundColor Green
```

### Paso 3: Copiar archivos nuevos

```powershell
# Copiar dashboard principal
Copy-Item "dashboard-superadmin-tabs.blade.php" `
          "resources\views\modulos\admin\dashboard-nuevo.blade.php"

# Copiar partial de overview
Copy-Item "overview-partial.blade.php" `
          "resources\views\modulos\admin\partials\overview.blade.php"

Write-Host "✓ Archivos copiados exitosamente" -ForegroundColor Green
```

### Paso 4: Verificar archivos

```powershell
# Verificar que los archivos existan
$archivos = @(
    "resources\views\modulos\admin\dashboard-nuevo.blade.php",
    "resources\views\modulos\admin\partials\overview.blade.php"
)

foreach ($archivo in $archivos) {
    if (Test-Path $archivo) {
        $tamano = (Get-Item $archivo).Length
        Write-Host "✓ $archivo ($tamano bytes)" -ForegroundColor Green
    } else {
        Write-Host "✗ $archivo NO ENCONTRADO" -ForegroundColor Red
    }
}
```

### Paso 5: Abrir archivos para editar

```powershell
# Abrir el controlador en VS Code (o tu editor preferido)
code app\Http\Controllers\Admin\DashboardController.php

# Abrir las rutas
code routes\web.php

# Abrir el archivo con el método para copiar
code DashboardController-metodo.php
```

---

## 🔧 CONFIGURACIÓN DEL CONTROLADOR

### Opción A: Editar manualmente

```powershell
# Abre el archivo
code app\Http\Controllers\Admin\DashboardController.php

# Luego:
# 1. Copia TODO el contenido de DashboardController-metodo.php
# 2. Pégalo DESPUÉS del método index() existente
# 3. Verifica las importaciones al inicio del archivo
# 4. Guarda el archivo (Ctrl+S)
```

### Opción B: Ver las diferencias

```powershell
# Mostrar contenido actual del controlador
Get-Content app\Http\Controllers\Admin\DashboardController.php

# Mostrar método nuevo a agregar
Get-Content DashboardController-metodo.php
```

---

## 🛣️ ACTUALIZAR RUTAS

```powershell
# Abrir archivo de rutas
code routes\web.php

# Buscar esta línea:
# Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

# Cambiarla por:
# Route::get('/dashboard', [DashboardController::class, 'indexTabs'])->name('dashboard');

# O hacer el cambio con PowerShell (¡CUIDADO! Hacer backup primero)
$rutasContent = Get-Content routes\web.php -Raw
$rutasContent = $rutasContent -replace "DashboardController::class, 'index']", "DashboardController::class, 'indexTabs']"
Set-Content routes\web.php $rutasContent

Write-Host "✓ Rutas actualizadas" -ForegroundColor Green
```

---

## ✅ VERIFICACIÓN DE INSTALACIÓN

```powershell
# Verificar estructura de carpetas
Write-Host "`n=== VERIFICANDO ESTRUCTURA ===" -ForegroundColor Cyan
Get-ChildItem resources\views\modulos\admin\ -Recurse

# Verificar que Alpine.js esté en el layout
Write-Host "`n=== VERIFICANDO ALPINE.JS ===" -ForegroundColor Cyan
Select-String -Path resources\views\layouts\app.blade.php -Pattern "alpine" -CaseSensitive:$false

# Limpiar caché de Laravel
Write-Host "`n=== LIMPIANDO CACHÉ ===" -ForegroundColor Cyan
php artisan view:clear
php artisan config:clear
php artisan cache:clear

Write-Host "`n✓ Caché limpiado" -ForegroundColor Green
```

---

## 🧪 PROBAR EL SISTEMA

```powershell
# Iniciar servidor de desarrollo
Write-Host "`n=== INICIANDO SERVIDOR ===" -ForegroundColor Cyan
php artisan serve

# El servidor estará en: http://127.0.0.1:8000
# Dashboard estará en: http://127.0.0.1:8000/admin/dashboard

Write-Host "`nAbre tu navegador en: http://127.0.0.1:8000/admin/dashboard" -ForegroundColor Yellow
```

---

## 🔄 ROLLBACK (Si algo sale mal)

```powershell
# Ver backups disponibles
Write-Host "=== BACKUPS DISPONIBLES ===" -ForegroundColor Cyan
Get-ChildItem resources\views\modulos\admin\ -Filter "dashboard-backup-*.blade.php"

# Restaurar backup (cambia la fecha por tu backup)
$backup = "dashboard-backup-20251110-155030.blade.php"  # Cambia esto
Copy-Item "resources\views\modulos\admin\$backup" `
          "resources\views\modulos\admin\dashboard.blade.php" -Force

Write-Host "✓ Dashboard restaurado desde backup" -ForegroundColor Green

# Restaurar ruta en web.php
$rutasContent = Get-Content routes\web.php -Raw
$rutasContent = $rutasContent -replace "DashboardController::class, 'indexTabs']", "DashboardController::class, 'index']"
Set-Content routes\web.php $rutasContent

Write-Host "✓ Rutas restauradas" -ForegroundColor Green

# Limpiar caché
php artisan view:clear
php artisan config:clear

Write-Host "✓ Rollback completado" -ForegroundColor Green
```

---

## 🐛 COMANDOS DE DEBUG

```powershell
# Ver logs en tiempo real
Write-Host "=== MONITOREANDO LOGS ===" -ForegroundColor Cyan
Get-Content storage\logs\laravel.log -Wait -Tail 50

# Verificar permisos
Write-Host "`n=== VERIFICANDO PERMISOS ===" -ForegroundColor Cyan
Get-Acl storage\logs\laravel.log | Format-List

# Ver errores recientes
Write-Host "`n=== ERRORES RECIENTES ===" -ForegroundColor Cyan
Select-String -Path storage\logs\laravel.log -Pattern "ERROR" | Select-Object -Last 10

# Verificar base de datos
Write-Host "`n=== VERIFICANDO BASE DE DATOS ===" -ForegroundColor Cyan
php artisan migrate:status
```

---

## 📚 COMANDOS ÚTILES ADICIONALES

```powershell
# Ver rutas del admin
php artisan route:list --path=admin

# Ver todas las vistas
Get-ChildItem resources\views\ -Recurse -Filter "*.blade.php"

# Compilar assets (si usas Vite o Mix)
npm run dev
# o para producción
npm run build

# Optimizar autoload
composer dump-autoload

# Optimizar configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎯 CHECKLIST DE INSTALACIÓN

Marca cada paso al completarlo:

```powershell
# Copiar y pegar esto para crear tu checklist
@"
[ ] 1. Descargué todos los archivos
[ ] 2. Creé la carpeta partials
[ ] 3. Copié dashboard-superadmin-tabs.blade.php
[ ] 4. Copié overview-partial.blade.php
[ ] 5. Agregué método indexTabs() al DashboardController
[ ] 6. Actualicé la ruta en web.php
[ ] 7. Limpié el caché de Laravel
[ ] 8. Probé ingresar como Super Admin
[ ] 9. Verifiqué que todas las pestañas funcionan
[ ] 10. Las estadísticas se muestran correctamente
"@ | Out-File checklist.txt

Write-Host "✓ Checklist creado en checklist.txt" -ForegroundColor Green
notepad checklist.txt
```

---

## 💡 TIPS PROFESIONALES

```powershell
# Crear alias para comandos frecuentes
function Clear-LaravelCache {
    php artisan view:clear
    php artisan config:clear
    php artisan cache:clear
    Write-Host "✓ Caché limpiado" -ForegroundColor Green
}

# Usar:
Clear-LaravelCache

# Ver archivo del dashboard nuevo
code resources\views\modulos\admin\dashboard-nuevo.blade.php

# Comparar archivos
code --diff resources\views\modulos\admin\dashboard.blade.php `
              resources\views\modulos\admin\dashboard-nuevo.blade.php
```

---

## 🆘 AYUDA RÁPIDA

```powershell
# Si tienes problemas, ejecuta este diagnóstico:

Write-Host "=== DIAGNÓSTICO DEL SISTEMA ===" -ForegroundColor Cyan

# 1. Verificar Laravel
Write-Host "`n1. Versión de Laravel:" -ForegroundColor Yellow
php artisan --version

# 2. Verificar PHP
Write-Host "`n2. Versión de PHP:" -ForegroundColor Yellow
php -v

# 3. Verificar Composer
Write-Host "`n3. Versión de Composer:" -ForegroundColor Yellow
composer --version

# 4. Verificar NPM
Write-Host "`n4. Versión de NPM:" -ForegroundColor Yellow
npm -v

# 5. Verificar archivos
Write-Host "`n5. Archivos críticos:" -ForegroundColor Yellow
$critical = @(
    "resources\views\modulos\admin\dashboard-nuevo.blade.php",
    "resources\views\modulos\admin\partials\overview.blade.php",
    "app\Http\Controllers\Admin\DashboardController.php",
    "routes\web.php"
)
foreach ($file in $critical) {
    if (Test-Path $file) {
        Write-Host "  ✓ $file" -ForegroundColor Green
    } else {
        Write-Host "  ✗ $file" -ForegroundColor Red
    }
}

Write-Host "`n=== FIN DEL DIAGNÓSTICO ===" -ForegroundColor Cyan
```

---

## 📞 SOPORTE

Si encuentras errores, verifica:
1. Que Alpine.js esté cargado en tu layout
2. Que todas las rutas de los módulos existan
3. Los logs de Laravel: `storage\logs\laravel.log`
4. La consola del navegador (F12) para errores de JavaScript

---

**¡Listo! Ahora tienes todos los comandos necesarios para instalar el sistema.** 🚀

Ejecuta: `.\instalar.ps1` para comenzar de forma automática.
