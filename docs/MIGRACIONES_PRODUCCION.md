# 🚀 Instrucciones para Ejecutar Migraciones en Producción

## Problema Resuelto
El error `SQLSTATE[42000]: Syntax error or access violation: 1227 Access denied; you need (at least one of) the SUPER or SET_USER_ID privilege(s)` ha sido corregido.

### Causas
1. Migraciones creaban Stored Procedures con `DEFINER=root@localhost`
2. Usuario de MySQL en producción no tiene permisos SUPER
3. Clase `socioController.php` no cumplía con PSR-4

### Soluciones Aplicadas
✅ Removidos todos los `DEFINER=root@localhost` de 46+ Stored Procedures
✅ Renombrado `socioController.php` → `SocioController.php` (PSR-4 compliance)

## Pasos a Ejecutar en Producción

### 1. Actualizar el código
```bash
cd /var/www/laravel
git pull origin Dev
```

### 2. Instalar dependencias
```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 3. Ejecutar migraciones
```bash
# Responder "Yes" cuando pregunte sobre producción
php artisan migrate --force
```

Ahora debería ejecutarse sin errores de permisos.

### 4. Verificar que todo está OK
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ¿Qué cambió?

### Antes (Error)
```sql
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_evento_calendario`(...)
```
❌ Requiere permisos SUPER

### Después (Funciona)
```sql
CREATE PROCEDURE `sp_crear_evento_calendario`(...)
```
✅ Usa el usuario actual (sin permisos especiales)

## Verificar Migraciones
```bash
php artisan migrate:status
```

Todas las migraciones deben mostrar "DONE" ✅

## Soporte
Si hay problemas:
1. Verifica que el usuario de MySQL tiene permisos CREATE PROCEDURE
2. Revisa `/var/www/laravel/storage/logs/laravel.log`
3. Asegúrate de tener Git actualizado: `git pull origin Dev`

---
**Última actualización**: 10 Nov 2025
**Commit**: 35f0d97
**Status**: ✅ Listo para producción
