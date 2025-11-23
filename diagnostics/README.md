# Diagnostics Scripts 🔍

Scripts para análisis, verificación y debugging del sistema. Estos archivos NO afectan la BD, solo leen información.

## Uso

Estos scripts son útiles para:
- Verificar estado actual del sistema
- Analizar problemas
- Comparar datos
- Hacer auditorías

## Categorías de Scripts

### Verificación de Datos

- **`ver_miembros_reales.php`** - Ver estructura de usuarios y miembros
- **`diagnostico_datos.php`** - Mostrar datos de usuarios con resultados
- **`diagnostico_sesion.php`** - Ver información de sesión del usuario actual
- **`diagnostico_usuarios.php`** - Listar todos los usuarios

### Análisis de Stored Procedures

- **`test_todos_sps.php`** - Ejecutar pruebas de todos los SPs
- **`exportar_sps.php`** - Exportar definiciones de SPs
- **`inspeccionar_sp.php`** - Inspeccionar un SP específico
- **`ver_sp_misnotas.php`** - Ver definición de SP_MisNotas
- **`ver_sp_problemas.php`** - Identificar problemas en SPs

### Análisis de Estructura

- **`revisar_estructura.php`** - Ver columnas de tablas principales
- **`revisar_tablas.php`** - Revisar todas las tablas de la BD
- **`diagnostico_collations.php`** - Verificar collations de tablas y columnas
- **`check_problem_collations.php`** - Detectar problemas de collations
- **`ver_estructura_chat.php`** - Ver estructura tabla conversaciones_chat
- **`ver_estructura_sp.php`** - Ver estructura de resultados de SPs
- **`verificar_tablas_membresias.php`** - Verificar tablas de membresías

### Comparación y Análisis Específico

- **`comparar_datos_usuarios.php`** - Comparar datos entre usuarios
- **`analizar_perfiles_conflicto.php`** - Analizar conflictos en perfiles
- **`check_miembros_local.php`** - Verificar miembros en BD local
- **`check_relacion.php`** - Verificar relaciones users-miembros
- **`sincronizar_servidor.php`** - Comparar BD local vs servidor

### Backup y Limpieza

- **`backup_antes_limpiar.php`** - Mostrar qué se va a limpiar (sin ejecutar)
- **`limpiar_miembros_legacy.php`** - Limpiar datos legacy de miembros
- **`verificar_limpieza.php`** - Verificar estado post-limpieza

### Pruebas Funcionales

- **`probar_funcionalidades_tesorero.php`** - Probar módulo Tesorero

## Cómo Usar

```bash
# En local
php diagnostics/ver_miembros_reales.php

# En servidor
ssh root@64.23.239.0 "cd /var/www/laravel && php diagnostics/test_todos_sps.php"

# O copiar y ejecutar
scp diagnostics/verificar_limpieza.php root@64.23.239.0:/var/www/laravel/
ssh root@64.23.239.0 "cd /var/www/laravel && php diagnostics/verificar_limpieza.php"
```

## Output Típico

Todos los scripts retornan información en formato legible, generalmente con:
- ✅ Éxito
- ❌ Error
- ⚠️ Advertencia
- 📊 Datos/estadísticas

## Ejemplos Útiles

### Verificar si un usuario tiene datos

```bash
php diagnostics/diagnostico_datos.php
# Muestra count de datos para cada usuario
```

### Ver definición actual de un SP

```bash
php diagnostics/ver_sp_misnotas.php
# Muestra el SQL completo del stored procedure
```

### Detectar problemas antes de subir

```bash
php diagnostics/diagnostico_collations.php
php diagnostics/test_todos_sps.php
# Si hay problemas, usar archivos en database-fixes/
```

---

💡 **Tip**: Estos scripts son seguros de ejecutar en producción para diagnosticar, pero mejor hacerlo en horarios de bajo uso.
