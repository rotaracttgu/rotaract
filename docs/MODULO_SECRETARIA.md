# Módulo de Secretaría - Documentación Completa

## 📋 Tabla de Contenidos
1. [Visión General](#visión-general)
2. [Características Principales](#características-principales)
3. [Estructura del Módulo](#estructura-del-módulo)
4. [Modelos y Base de Datos](#modelos-y-base-de-datos)
5. [Controladores y Rutas](#controladores-y-rutas)
6. [Stored Procedures](#stored-procedures)
7. [Vistas y Frontend](#vistas-y-frontend)
8. [Guía de Uso](#guía-de-uso)
9. [Testing](#testing)
10. [Solución de Problemas](#solución-de-problemas)

---

## Visión General

El **Módulo de Secretaría** es un sistema integral para la gestión administrativa del Club Rotaract, diseñado para optimizar la administración de consultas, actas, diplomas y documentos oficiales.

### Tecnologías Utilizadas
- **Backend**: Laravel 10+ con PHP 8.1+
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Base de Datos**: MySQL con Stored Procedures
- **Testing**: PHPUnit con Laravel Testing

---

## Características Principales

### 🗨️ Gestión de Consultas
- ✅ Visualización de consultas de miembros
- ✅ Filtrado por estado (pendiente, respondida, cerrada)
- ✅ Sistema de respuestas con notificaciones
- ✅ Asignación de prioridades
- ✅ Estadísticas en tiempo real

### 📝 Gestión de Actas
- ✅ Creación y edición de actas de reuniones
- ✅ Tipos de reunión: ordinaria, extraordinaria, junta, asamblea
- ✅ Carga de archivos PDF (máx. 5MB)
- ✅ Lista de asistentes y contenido detallado
- ✅ Versionamiento automático

### 🏆 Gestión de Diplomas
- ✅ Emisión de diplomas personalizados
- ✅ Tipos: participación, reconocimiento, mérito, asistencia
- ✅ Envío automático por email
- ✅ Carga opcional de diseño PDF
- ✅ Registro de emisión y entrega

### 📁 Gestión de Documentos
- ✅ Archivo centralizado de documentos
- ✅ Categorización flexible (oficial, interno, comunicado, carta, informe)
- ✅ Soporte multi-formato (PDF, DOC, DOCX, XLS, XLSX)
- ✅ Sistema de permisos de visibilidad
- ✅ Búsqueda avanzada con Stored Procedures

---

## Estructura del Módulo

```
Módulo de Secretaría/
├── Controllers/
│   └── SecretariaController.php      # Controlador principal
├── Models/
│   ├── Consulta.php                  # Modelo de consultas
│   ├── Acta.php                      # Modelo de actas
│   ├── Diploma.php                   # Modelo de diplomas
│   └── Documento.php                 # Modelo de documentos
├── Views/
│   └── modulos/secretaria/
│       ├── dashboard.blade.php       # Panel principal
│       ├── consultas.blade.php       # Gestión de consultas
│       ├── actas.blade.php           # Gestión de actas
│       ├── diplomas.blade.php        # Gestión de diplomas
│       └── documentos.blade.php      # Gestión de documentos
├── Database/
│   ├── migrations/
│   │   ├── *_create_consultas_table.php
│   │   ├── *_create_actas_table.php
│   │   ├── *_create_diplomas_table.php
│   │   ├── *_create_documentos_table.php
│   │   ├── *_create_sp_estadisticas_secretaria_proc.php
│   │   ├── *_create_sp_reporte_diplomas_proc.php
│   │   ├── *_create_sp_busqueda_documentos_proc.php
│   │   └── *_create_sp_resumen_actas_proc.php
│   └── factories/
│       ├── ConsultaFactory.php
│       ├── ActaFactory.php
│       ├── DiplomaFactory.php
│       └── DocumentoFactory.php
├── Tests/
│   └── Feature/
│       └── SecretariaModuleTest.php  # Tests automatizados
└── Routes/
    └── web.php                        # Definición de rutas
```

---

## Modelos y Base de Datos

### Modelo: Consulta

**Tabla**: `consultas`

**Campos**:
```php
- id (bigint, PK)
- usuario_id (FK -> users.id)
- asunto (varchar 255)
- mensaje (text)
- estado (enum: pendiente, respondida, cerrada)
- prioridad (enum: baja, media, alta)
- respuesta (text, nullable)
- respondido_por (FK -> users.id, nullable)
- respondido_at (datetime, nullable)
- created_at, updated_at (timestamps)
```

**Relaciones**:
- `usuario()` - Pertenece al usuario que creó la consulta
- `respondedor()` - Pertenece al usuario que respondió

---

### Modelo: Acta

**Tabla**: `actas`

**Campos**:
```php
- id (bigint, PK)
- titulo (varchar 255)
- fecha_reunion (date)
- tipo_reunion (enum: ordinaria, extraordinaria, junta, asamblea)
- contenido (text)
- asistentes (text)
- archivo_path (varchar 255, nullable)
- creado_por (FK -> users.id)
- created_at, updated_at (timestamps)
```

**Relaciones**:
- `creador()` - Pertenece al usuario que creó el acta

**Accessors**:
- `archivo_url` - Retorna URL completa del archivo PDF

---

### Modelo: Diploma

**Tabla**: `diplomas`

**Campos**:
```php
- id (bigint, PK)
- miembro_id (FK -> users.id)
- tipo (enum: participacion, reconocimiento, merito, asistencia)
- motivo (varchar 500)
- fecha_emision (date)
- archivo_path (varchar 255, nullable)
- emitido_por (FK -> users.id)
- enviado_email (boolean, default: false)
- fecha_envio_email (datetime, nullable)
- created_at, updated_at (timestamps)
```

**Relaciones**:
- `miembro()` - Pertenece al usuario que recibe el diploma
- `emisor()` - Pertenece al usuario que emitió el diploma

**Accessors**:
- `archivo_url` - Retorna URL completa del archivo PDF

---

### Modelo: Documento

**Tabla**: `documentos`

**Campos**:
```php
- id (bigint, PK)
- titulo (varchar 255)
- tipo (enum: oficial, interno, comunicado, carta, informe, otro)
- descripcion (text, max 1000 chars)
- archivo_path (varchar 255)
- archivo_nombre (varchar 255)
- categoria (varchar 100)
- visible_para_todos (boolean, default: true)
- creado_por (FK -> users.id)
- created_at, updated_at (timestamps)
```

**Relaciones**:
- `creador()` - Pertenece al usuario que creó el documento

**Accessors**:
- `archivo_url` - Retorna URL completa del archivo

---

## Controladores y Rutas

### SecretariaController

**Namespace**: `App\Http\Controllers`

#### Métodos Principales

##### 1. Dashboard
```php
GET /secretaria/dashboard
Método: dashboard()
Descripción: Panel principal con estadísticas optimizadas via SP_EstadisticasSecretaria
Retorna: View con estadísticas y datos recientes
```

##### 2. Gestión de Consultas
```php
GET    /secretaria/consultas              -> consultas()
GET    /secretaria/consultas/{id}         -> getConsulta($id)
POST   /secretaria/consultas/{id}/responder -> responderConsulta(Request, $id)
DELETE /secretaria/consultas/{id}         -> eliminarConsulta($id)
```

##### 3. Gestión de Actas
```php
GET    /secretaria/actas                  -> actas()
GET    /secretaria/actas/{id}             -> getActa($id)
POST   /secretaria/actas                  -> storeActa(Request)
POST   /secretaria/actas/{id}             -> updateActa(Request, $id)
DELETE /secretaria/actas/{id}             -> eliminarActa($id)
```

**Validación de Actas**:
```php
'titulo' => 'required|string|max:255'
'fecha_reunion' => 'required|date'
'tipo_reunion' => 'required|in:ordinaria,extraordinaria,junta,asamblea'
'contenido' => 'required|string'
'asistentes' => 'required|string'
'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120' // 5MB max
```

##### 4. Gestión de Diplomas
```php
GET    /secretaria/diplomas               -> diplomas()
GET    /secretaria/diplomas/{id}          -> getDiploma($id)
POST   /secretaria/diplomas               -> storeDiploma(Request)
DELETE /secretaria/diplomas/{id}          -> eliminarDiploma($id)
POST   /secretaria/diplomas/{id}/enviar-email -> enviarEmailDiploma($id)
```

**Validación de Diplomas**:
```php
'miembro_id' => 'required|exists:users,id'
'tipo' => 'required|in:participacion,reconocimiento,merito,asistencia'
'motivo' => 'required|string|max:500'
'fecha_emision' => 'required|date'
'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120'
```

##### 5. Gestión de Documentos
```php
GET    /secretaria/documentos             -> documentos()
GET    /secretaria/documentos/{id}        -> getDocumento($id)
POST   /secretaria/documentos             -> storeDocumento(Request)
POST   /secretaria/documentos/{id}        -> updateDocumento(Request, $id)
DELETE /secretaria/documentos/{id}        -> eliminarDocumento($id)
```

**Validación de Documentos**:
```php
'titulo' => 'required|string|max:255'
'tipo' => 'required|in:oficial,interno,comunicado,carta,informe,otro'
'categoria' => 'required|string|max:100'
'descripcion' => 'nullable|string|max:1000'
'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240' // 10MB max
```

##### 6. Reportes con Stored Procedures
```php
POST /secretaria/reportes/diplomas              -> reporteDiplomas(Request)
POST /secretaria/reportes/documentos/buscar     -> buscarDocumentos(Request)
POST /secretaria/reportes/actas/resumen         -> resumenActas(Request)
```

---

## Stored Procedures

### 1. SP_EstadisticasSecretaria()

**Propósito**: Obtener estadísticas globales optimizadas para el dashboard

**Parámetros**: Ninguno

**Retorna**: 4 conjuntos de resultados
1. **Consultas**: total, pendientes, respondidas, cerradas, hoy, este_mes
2. **Actas**: total, ordinarias, extraordinarias, juntas, este_mes, este_anio
3. **Diplomas**: total, participacion, reconocimiento, merito, asistencia, enviados
4. **Documentos**: total, oficiales, internos, categorias, este_mes, este_anio

**Uso en Controller**:
```php
$results = DB::select('CALL SP_EstadisticasSecretaria()');
$estadisticas = [
    'consultas_total' => $results[0]->total,
    'consultas_pendientes' => $results[0]->pendientes,
    // ... etc
];
```

---

### 2. SP_ReporteDiplomas(fecha_inicio, fecha_fin, tipo)

**Propósito**: Generar reporte detallado de diplomas por período

**Parámetros**:
- `p_fecha_inicio` (DATE): Fecha inicial del rango
- `p_fecha_fin` (DATE): Fecha final del rango
- `p_tipo` (VARCHAR, nullable): Filtro opcional por tipo

**Retorna**: 2 conjuntos
1. **Diplomas detallados**: Lista completa con datos del miembro y emisor
2. **Resumen**: Totales por tipo y estado de envío

**Ejemplo de uso**:
```javascript
fetch('/secretaria/reportes/diplomas', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        fecha_inicio: '2025-01-01',
        fecha_fin: '2025-12-31',
        tipo: 'participacion' // o null para todos
    })
})
.then(response => response.json())
.then(data => {
    console.log('Diplomas:', data.diplomas);
    console.log('Resumen:', data.resumen);
});
```

---

### 3. SP_BusquedaDocumentos(busqueda, tipo, categoria, fecha_inicio, fecha_fin)

**Propósito**: Búsqueda avanzada de documentos con múltiples filtros

**Parámetros**:
- `p_busqueda` (VARCHAR, nullable): Término de búsqueda en título, descripción o nombre archivo
- `p_tipo` (VARCHAR, nullable): Filtro por tipo de documento
- `p_categoria` (VARCHAR, nullable): Filtro por categoría
- `p_fecha_inicio` y `p_fecha_fin` (DATE, nullable): Rango de fechas

**Retorna**: 2 conjuntos
1. **Documentos encontrados**: Lista con tipo de archivo identificado
2. **Resumen**: Total encontrados, distribución por tipo, categorías

**Ejemplo de uso**:
```javascript
fetch('/secretaria/reportes/documentos/buscar', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        busqueda: 'acta',
        tipo: 'oficial',
        categoria: null,
        fecha_inicio: '2025-01-01',
        fecha_fin: null
    })
})
.then(response => response.json())
.then(data => {
    console.log('Documentos:', data.documentos);
    console.log('Total encontrados:', data.resumen.total_encontrados);
});
```

---

### 4. SP_ResumenActas(anio, mes)

**Propósito**: Generar resumen estadístico de actas por período

**Parámetros**:
- `p_anio` (INT, nullable): Año para filtrar (ej: 2025)
- `p_mes` (INT, nullable): Mes para filtrar (1-12)

**Retorna**: 3 conjuntos
1. **Resumen por período**: Agrupación por mes/año y tipo de reunión
2. **Estadísticas generales**: Totales, promedios, fechas límite
3. **Top 5 actas**: Actas más recientes del período

**Ejemplo de uso**:
```javascript
fetch('/secretaria/reportes/actas/resumen', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        anio: 2025,
        mes: 11 // Noviembre
    })
})
.then(response => response.json())
.then(data => {
    console.log('Resumen por período:', data.resumen_por_periodo);
    console.log('Estadísticas:', data.estadisticas_generales);
    console.log('Top actas:', data.top_actas);
});
```

---

## Vistas y Frontend

### Componentes Principales

#### 1. Dashboard (dashboard.blade.php)
- **Tarjetas de estadísticas** con enlace directo a cada sección
- **Botones de acción rápida** (Crear Nuevo dropdown)
- **Listas de elementos recientes** (últimas 5 consultas, actas, diplomas, documentos)
- **Integración con Alpine.js** para interactividad

#### 2. Consultas (consultas.blade.php)
**Modales**:
- `modalVerConsulta`: Visualización de detalles
- `modalResponderConsulta`: Formulario de respuesta

**Funciones JavaScript**:
```javascript
verConsulta(id)          // Cargar y mostrar consulta
responderConsulta()      // Enviar respuesta vía AJAX
eliminarConsulta(id)     // Eliminar con confirmación
cerrarModal(modalId)     // Cerrar modales
```

#### 3. Actas (actas.blade.php)
**Modales**:
- `modalActa`: Crear/editar acta con upload PDF
- `modalVerActa`: Visualización detallada con descarga

**Funciones JavaScript**:
```javascript
nuevaActa()              // Abrir modal vacío
verActa(id)              // Cargar y mostrar acta
editarActa(id)           // Cargar para edición
eliminarActa(id)         // Eliminar con confirmación
cerrarModalActa()        // Cerrar modales
```

**Validación de archivos**:
- Formato: Solo PDF
- Tamaño máximo: 5MB
- Validación cliente y servidor

#### 4. Diplomas (diplomas.blade.php)
**Modales**:
- `modalDiploma`: Crear diploma con selector de miembro
- `modalVerDiploma`: Detalles con botón enviar email

**Funciones JavaScript**:
```javascript
nuevoDiploma()           // Abrir modal con lista de usuarios
verDiploma(id)           // Cargar detalles
eliminarDiploma(id)      // Eliminar con confirmación
enviarEmailDiploma(id)   // Enviar email al miembro
cerrarModalDiploma()     // Cerrar modales
```

**Tipos de diploma**:
- **Participación**: Por asistencia a actividades
- **Reconocimiento**: Por logros destacados
- **Mérito**: Por excelencia en gestión
- **Asistencia**: Por asistencia perfecta

#### 5. Documentos (documentos.blade.php)
**Modales**:
- `modalDocumento`: Crear/editar con multi-formato
- `modalVerDocumento`: Detalles con icono dinámico según tipo

**Funciones JavaScript**:
```javascript
nuevoDocumento()         // Abrir modal vacío
verDocumento(id)         // Cargar detalles
editarDocumento(id)      // Cargar para edición
eliminarDocumento(id)    // Eliminar archivo y registro
cerrarModalDocumento()   // Cerrar modales
```

**Iconos dinámicos**:
- PDF: `fa-file-pdf` (rojo)
- Word: `fa-file-word` (azul)
- Excel: `fa-file-excel` (verde)

---

## Guía de Uso

### Para Secretarios

#### Crear una Nueva Acta
1. Navegar a **Secretaría > Actas**
2. Click en botón **"Nueva Acta"**
3. Llenar formulario:
   - Título descriptivo
   - Fecha de reunión
   - Tipo de reunión (ordinaria/extraordinaria/junta/asamblea)
   - Contenido detallado
   - Lista de asistentes (separados por comas)
   - Opcional: cargar PDF con acta firmada
4. Click en **"Guardar Acta"**
5. Verificar en la lista de actas

#### Responder una Consulta
1. Ir a **Secretaría > Consultas**
2. Filtrar por "Pendientes" si es necesario
3. Click en el botón **Ver** (ojo) de la consulta
4. Click en **"Responder"**
5. Escribir respuesta detallada
6. Seleccionar nuevo estado (Respondida/Cerrada)
7. Click en **"Enviar Respuesta"**
8. El usuario recibirá notificación automática

#### Emitir un Diploma
1. Acceder a **Secretaría > Diplomas**
2. Click en **"Nuevo Diploma"**
3. Seleccionar miembro del dropdown
4. Elegir tipo de diploma
5. Escribir motivo (máx. 500 caracteres)
6. Establecer fecha de emisión
7. Opcional: cargar diseño PDF personalizado
8. Click en **"Crear Diploma"**
9. Para enviarlo: Click en **Ver** > **"Enviar por Email"**

#### Archivar un Documento
1. Navegar a **Secretaría > Documentos**
2. Click en **"Nuevo Documento"**
3. Completar datos:
   - Título
   - Tipo (oficial/interno/comunicado/carta/informe)
   - Categoría personalizada
   - Descripción (máx. 1000 caracteres)
   - Seleccionar archivo (PDF, DOC, DOCX, XLS, XLSX)
4. Marcar "Visible para todos" si aplica
5. Click en **"Guardar Documento"**

### Para Administradores

#### Generar Reporte de Diplomas
```bash
# Vía cURL (ejemplo)
curl -X POST http://tu-dominio.com/secretaria/reportes/diplomas \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: tu-csrf-token" \
  -d '{
    "fecha_inicio": "2025-01-01",
    "fecha_fin": "2025-12-31",
    "tipo": null
  }'
```

#### Buscar Documentos Avanzado
```bash
curl -X POST http://tu-dominio.com/secretaria/reportes/documentos/buscar \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: tu-csrf-token" \
  -d '{
    "busqueda": "acta",
    "tipo": "oficial",
    "categoria": null,
    "fecha_inicio": "2025-01-01",
    "fecha_fin": null
  }'
```

---

## Testing

### Ejecutar Tests

```bash
# Ejecutar todos los tests del módulo
php artisan test --filter=SecretariaModuleTest

# Ejecutar test específico
php artisan test --filter=SecretariaModuleTest::dashboard_carga_correctamente

# Con coverage
php artisan test --filter=SecretariaModuleTest --coverage
```

### Tests Disponibles

1. ✅ `dashboard_carga_correctamente` - Verifica carga del dashboard
2. ✅ `stored_procedure_estadisticas_funciona` - Valida SP_EstadisticasSecretaria
3. ✅ `puede_ver_lista_de_consultas` - Listado de consultas
4. ✅ `puede_responder_consulta` - Responder consulta con actualización DB
5. ✅ `puede_crear_acta_con_pdf` - Crear acta con archivo PDF
6. ✅ `puede_crear_diploma` - Emisión de diploma
7. ✅ `puede_crear_documento_con_archivo` - Archivar documento
8. ✅ `puede_eliminar_consulta` - Eliminar consulta soft/hard delete
9. ✅ `reporte_diplomas_funciona` - SP_ReporteDiplomas
10. ✅ `busqueda_documentos_funciona` - SP_BusquedaDocumentos
11. ✅ `resumen_actas_funciona` - SP_ResumenActas
12. ✅ `validacion_falla_con_datos_invalidos` - Validaciones de formulario

---

## Solución de Problemas

### Error: "SQLSTATE[HY000]: Procedure does not exist"

**Causa**: Los stored procedures no se han ejecutado en la base de datos.

**Solución**:
```bash
php artisan migrate:fresh  # Recrear base de datos
# o
php artisan migrate        # Si solo faltan los SPs
```

### Error: "Storage path not found"

**Causa**: Los directorios de almacenamiento no existen.

**Solución**:
```bash
# Windows (PowerShell)
New-Item -ItemType Directory -Path storage\app\public\actas
New-Item -ItemType Directory -Path storage\app\public\diplomas
New-Item -ItemType Directory -Path storage\app\public\documentos

# Linux/Mac
mkdir -p storage/app/public/{actas,diplomas,documentos}

# Crear enlace simbólico
php artisan storage:link
```

### Error: "The file size exceeds the maximum allowed"

**Causa**: Límites de PHP o Laravel para upload de archivos.

**Solución**:
Editar `php.ini`:
```ini
upload_max_filesize = 20M
post_max_size = 20M
```

Y en `config/validation.php` (si existe) o en las validaciones del controller, ajustar el tamaño máximo.

### Error: "Call to undefined method illuminate..."

**Causa**: Falta un método o servicio no está registrado.

**Solución**:
```bash
php artisan optimize:clear
composer dump-autoload
```

---

## Mantenimiento

### Respaldo de Datos

```bash
# Respaldo completo de archivos
tar -czf backup_secretaria_$(date +%Y%m%d).tar.gz \
  storage/app/public/actas \
  storage/app/public/diplomas \
  storage/app/public/documentos

# Respaldo de base de datos (solo módulo secretaría)
mysqldump -u usuario -p base_datos \
  consultas actas diplomas documentos \
  > secretaria_backup_$(date +%Y%m%d).sql
```

### Limpieza de Archivos Huérfanos

```php
// Ejecutar en tinker o crear comando artisan
use App\Models\{Acta, Diploma, Documento};
use Illuminate\Support\Facades\Storage;

// Archivos de actas que no están en BD
$actasEnUso = Acta::whereNotNull('archivo_path')->pluck('archivo_path')->toArray();
$archivosActas = Storage::disk('public')->files('actas');
foreach ($archivosActas as $archivo) {
    if (!in_array($archivo, $actasEnUso)) {
        Storage::disk('public')->delete($archivo);
        echo "Eliminado: $archivo\n";
    }
}
```

---

## Changelog

### Versión 1.0.0 (Noviembre 2025)
- ✅ Implementación completa del módulo de secretaría
- ✅ CRUD de Consultas, Actas, Diplomas, Documentos
- ✅ 4 Stored Procedures para optimización
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Sistema de modales con Alpine.js
- ✅ Tests automatizados con PHPUnit
- ✅ Soporte multi-formato para documentos
- ✅ Sistema de notificaciones por email
- ✅ Validaciones robustas cliente y servidor

---

## Soporte y Contribución

Para reportar bugs o solicitar features:
1. Crear issue en el repositorio
2. Incluir pasos para reproducir
3. Adjuntar logs relevantes
4. Especificar versión de Laravel/PHP

**Desarrollado por**: [Tu Equipo]
**Última actualización**: Noviembre 6, 2025
**Licencia**: [Tu Licencia]
