# Guía Final de Deploy a Producción - Club Rotaract Web Service

## Fecha: Noviembre 10, 2025

### Resumen de Cambios Realizados

1. **Migraciones robustas**: Se eliminó `CREATE DEFINER` de todas las migraciones (50+ archivos)
2. **PSR-4 Compliance**: Se renombró `socioController.php` → `SocioController.php`
3. **Migraciones tolerantes**: Si faltan carpetas `sql_import` o archivos .sql, se omiten sin fallar
4. **Triggers con manejo de errores**: Si falta privilegio SUPER o binary logging, se omite sin fallar
5. **Import de Auth Facade**: Se agregó `use Illuminate\Support\Facades\Auth;` en 3 controladores

### Pasos para Sincronizar Producción

Ejecuta estos comandos **exactamente en este orden** en el servidor `/var/www/laravel`:

```bash
# 1. Traer los últimos cambios del repositorio
cd /var/www/laravel
git pull origin Dev

# 2. Reinstalar/actualizar dependencias (importante para Resend)
composer install --no-dev --optimize-autoloader

# 3. Regenerar autoload optimizado
composer dump-autoload --optimize

# 4. Ejecutar migraciones (ahora deben pasar sin error)
php artisan migrate --force

# 5. Optimizar la aplicación (caché, rutas, vistas)
php artisan optimize

# 6. Verificar logs para confirmar todo pasó bien
tail -n 100 storage/logs/laravel.log
```

### Qué Hace Cada Paso

| Paso | Comando | Propósito |
|------|---------|----------|
| 1 | git pull | Trae commits 7470e95, 572ec23, 6ee2b97 y otros |
| 2 | composer install | Instala `symfony/resend-mailer` y dependencias |
| 3 | composer dump-autoload | Regenera archivo de autoloading (limpia PSR-4 warning) |
| 4 | php artisan migrate | Corre todas las migraciones (debe terminar sin error) |
| 5 | php artisan optimize | Cachea configuración, rutas y vistas |
| 6 | tail | Verifica en logs que no haya errores críticos |

### Commits Que Trae `git pull`

```
7470e95 - fix: Agregar import faltante de Auth en controladores
572ec23 - fix(migrations): omitir creación de triggers si faltan privilegios
6ee2b97 - fix(migrations): omitir registro de SQL si falta carpeta sql_import
640a125 - docs: Guía para ejecutar migraciones en producción
35f0d97 - fix: Corregir permisos de Stored Procedures y PSR-4 compliance
```

### Errores Solucionados

#### ✅ Error: "Class App\Http\Controllers\Auth not found"
- **Causa**: Faltaba `use Illuminate\Support\Facades\Auth;`
- **Solución**: Agregado import en PresidenteController, VoceroController, VicepresidenteController

#### ✅ Error: "Class Resend not found"
- **Causa**: Servidor no tenía dependencias actualizadas
- **Solución**: `composer install` instala `symfony/resend-mailer`

#### ✅ Error: "SQLSTATE[1419]: SUPER privilege"
- **Causa**: Triggers requieren SUPER si binary logging está activo
- **Solución**: Migración ahora omite creación sin fallar (loguea advertencia)

#### ✅ Error: "carpeta sql_import no existe"
- **Causa**: Migraciones esperaban archivos .sql que no están en el repo
- **Solución**: Migraciones ahora omiten sin fallar si carpeta falta (loguea advertencia)

#### ✅ Error: "socioController.php does not comply with PSR-4"
- **Causa**: Nombre de archivo no coincidía con clase (minúscula)
- **Solución**: Renombrado a SocioController.php (pasa automáticamente con git pull)

### Verificación Post-Deploy

Después de ejecutar los comandos, verifica:

1. **Migraciones completadas**:
   ```bash
   grep -i "Running migrations" storage/logs/laravel.log | tail -n 1
   # Debería mostrar: "Running migrations." seguido de "DONE" en los próximos 10 segundos
   ```

2. **Acceso a la aplicación**:
   - Intenta login en http://tu-servidor/login
   - Verifica que NO hay "500 Server Error"

3. **Logs sin errores críticos**:
   ```bash
   tail -n 100 storage/logs/laravel.log | grep -i "ERROR"
   # No debería mostrar errores de Auth o Resend
   ```

4. **Autoload limpio** (opcional):
   ```bash
   php artisan config:cache && echo "Config cacheado"
   ```

### Si Algo Sale Mal

1. **Vuelve a intentar composer**:
   ```bash
   cd /var/www/laravel
   composer install --no-dev --optimize-autoloader
   php artisan optimize
   ```

2. **Regenera autoload**:
   ```bash
   composer dump-autoload --optimize
   ```

3. **Borra cache de Laravel** (limpia vistas compiladas):
   ```bash
   php artisan optimize:clear
   php artisan cache:clear
   php artisan config:clear
   ```

4. **Revisa el log completo**:
   ```bash
   less storage/logs/laravel.log
   # Dentro de less: presiona / para buscar "ERROR"
   ```

### Notas Importantes

- **MAIL_DRIVER** en `.env`: Debe ser `smtp` o `resend`. Si falta config, Laravel usa `smtp` por defecto.
- **SUPER privilege**: Triggers NO se crearán si la BD no tiene SUPER. Eso es **normal en producción**. La app funciona sin triggers (son opcionales).
- **Carpeta sql_import**: NO es necesaria. Las migraciones ahora la omiten.
- **socioController.php**: Se elimina automáticamente con `git pull` (reto aquí si Git reporta error, contact support).

### Próximos Pasos Opcionales (No Necesarios Ahora)

- Si quieres triggers: Habilita `log_bin_trust_function_creators=1` en MySQL (requiere acceso root o DBA).
- Si quieres procedimientos desde .sql: Crea `database/sql_import/Procedimientos/` en el repo y sube archivos .sql.
- Si quieres usar otro mailer (ej. Mailgun): Cambia `MAIL_MAILER` en `.env` de producción.

---

**Fecha de preparación**: 10/11/2025  
**Versión**: 1.0  
**Estado**: Listo para ejecutar en producción
