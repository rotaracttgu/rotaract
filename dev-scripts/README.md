# Development Scripts

Esta carpeta contiene scripts de testing, debugging y desarrollo que **NO son parte de la aplicación en producción**.

## Categorías:

### Análisis y Verificación
- `analizar_consultas.php` - Analiza estructura de tabla consultas
- `analizar_reuniones.php` - Verifica calendarios y asistencias
- `check_asistencias.php` - Verifica columnas de asistencias
- `check_notas.php` - Revisa tablas de notas
- `check_permisos.php` - Valida permisos del sistema
- `verificar_columnas_dashboard.php` - Estructura de tablas
- `verificar_comprobantes.php` - Prueba SPs de consultas

### Creación de Stored Procedures
- `create_sp_consultas.php` - SPs de consultas
- `create_sp_dashboard_socio.php` - SP dashboard socio
- `create_sp_misproyectos.php` - SP mis proyectos
- `create_sp_misreuniones.php` - SP mis reuniones

### Corrección y Testing
- `fix_sp_dashboard.php` - Corrige SPs de dashboard
- `fix_sp_misnotas.php` - Corrige SP_MisNotas
- `test_ajax.php` - Pruebas AJAX
- `test_dashboard_view.php` - Testing de vistas
- `test_notas.php` - Testing de notas
- `test_sp_dashboard.php` - Testing de SPs

### Datos de Prueba
- `create_test_consultas.php` - Crea consultas de prueba
- `create_test_proyectos.php` - Crea proyectos de prueba

## Nota
Estos scripts están organizados aquí para mantener el root del proyecto limpio. Se pueden ejecutar manualmente cuando sea necesario para debugging o desarrollo.
