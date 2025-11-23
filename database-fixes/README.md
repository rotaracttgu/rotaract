# Database Fixes 🔧

Scripts importantes para correcciones y sincronización de la base de datos.

## Archivos

### Fixes de Stored Procedures (SPs)

- **`fix_sp_consultas_collation.php`** - Arregla collations en `SP_MisConsultas`
  - Problema: Mezcla de collations utf8mb4_unicode_ci y utf8mb4_0900_ai_ci
  - Solución: Especificar COLLATE utf8mb4_general_ci en comparaciones

- **`fix_sp_misnotas_collation.php`** - Arregla collations en `SP_MisNotas`
  - Problema: Errores en operaciones LIKE con collations inconsistentes
  - Solución: Aplicar COLLATE uniforme a todas las comparaciones

- **`fix_sp_misproyectos_servidor.php`** - Arregla `SP_MisProyectos`
  - Problema: Referencia a columna `m_resp.Nombre` que no existe
  - Solución: Cambiar a `u_resp.name` (de tabla users)

- **`fix_sp_consultas.php`** - Fix general de SP_MisConsultas (versión anterior)

### Limpieza y Sincronización

- **`limpiar_datos_completo.php`** - Limpia BD para fresh start
  - Elimina todos los usuarios excepto Admin
  - Elimina todos los miembros excepto Admin
  - Borra datos asociados (notas, consultas, participaciones, asistencias)
  - Resetea auto_increment

- **`vincular_admin.php`** - Vincula Admin correctamente
  - Asegura que MiembroID 1 esté conectado a UserID 1

- **`actualizar_sps.php`** - Actualiza/sincroniza todos los SPs

## Cómo Usar

### En Servidor de Desarrollo

```bash
# Aplicar un fix específico
php fix_sp_consultas_collation.php

# Aplicar todos los fixes
php actualizar_sps.php
```

### En Servidor de Producción

```bash
# SSH al servidor
ssh root@64.23.239.0

# Navegar a app
cd /var/www/laravel

# Copiar script desde local (en otra terminal):
scp fix_sp_*.php root@64.23.239.0:/var/www/laravel/

# Ejecutar en servidor
php database-fixes/fix_sp_consultas_collation.php
php database-fixes/fix_sp_misproyectos_servidor.php
php database-fixes/fix_sp_misnotas_collation.php
```

## Problemas Conocidos Resueltos

### Collations Mismatch
- **Síntoma**: `SQLSTATE[HY000]: Illegal mix of collations`
- **Causa**: BD tenía `utf8mb4_0900_ai_ci`, tablas tenían `utf8mb4_unicode_ci`
- **Solución**: Archivos `fix_sp_*_collation.php`

### Columnas No Existentes
- **Síntoma**: `Unknown column 'm_resp.Nombre'`
- **Causa**: Stored Procedures referenciaban columnas inexistentes en miembros
- **Solución**: `fix_sp_misproyectos_servidor.php`

### Datos Huérfanos
- **Síntoma**: Usuarios sin perfiles vinculados
- **Causa**: Limpieza incompleta o errores en observers
- **Solución**: `limpiar_datos_completo.php`

## Comandos Útiles

```bash
# Ver estado de la BD
php diagnostics/ver_miembros_reales.php

# Verificar SPs
php diagnostics/test_todos_sps.php

# Ver collations
php diagnostics/diagnostico_collations.php
```

---

📌 **Nota**: Los archivos en esta carpeta deben ejecutarse solo cuando sea necesario, no en rutina.
