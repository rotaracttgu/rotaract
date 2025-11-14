# 👔 MÓDULO VICEPRESIDENTE - Documentación Completa

## 📋 Resumen del Módulo

Este módulo permite al Vicepresidente del Club Rotaract gestionar y consultar información crítica para su rol:

### ✅ Funcionalidades Principales:
- ✉️ **Cartas de Patrocinio** - Gestión completa de solicitudes de patrocinio
- 📧 **Cartas Formales** - Creación y seguimiento de correspondencia oficial
- 📊 **Estado de Proyectos** - Consulta del estado y progreso de proyectos
- 📋 **Asistencia a Reuniones** - Registro y seguimiento de asistencias
- 👥 **Participación en Proyectos** - Gestión de participantes y horas dedicadas

---

## 🗂️ Estructura de Archivos

### 📁 Vistas (Blade Templates)
```
resources/views/modulos/vicepresidente/
├── dashboard.blade.php                 # Panel principal con tabs integrados
├── cartas-patrocinio.blade.php        # Gestión de cartas de patrocinio
├── cartas-formales.blade.php          # Gestión de cartas formales
├── estado-proyectos.blade.php         # Vista de proyectos (consulta)
├── asistencia-reuniones.blade.php     # Vista de asistencias (consulta)
└── asistencia-proyectos.blade.php     # Vista de participación (consulta)
```

### 🎯 Controlador
```
app/Http/Controllers/VicepresidenteController.php
```

**Métodos disponibles:**
| Método | Ruta | Descripción |
|--------|------|-------------|
| `dashboard()` | `/vicepresidente/dashboard` | Panel principal con métricas |
| `cartasPatrocinio()` | `/vicepresidente/cartas/patrocinio` | Gestión de cartas de patrocinio |
| `cartasFormales()` | `/vicepresidente/cartas/formales` | Gestión de cartas formales |
| `estadoProyectos()` | `/vicepresidente/estado/proyectos` | Consulta de proyectos |
| `asistenciaReuniones()` | `/vicepresidente/asistencia/reuniones` | Consulta de asistencias |
| `asistenciaProyectos()` | `/vicepresidente/asistencia/proyectos` | Consulta de participación |

### 🗄️ Modelos

```
app/Models/
├── CartaPatrocinio.php           # Cartas de patrocinio
├── CartaFormal.php               # Cartas formales/oficiales
├── Proyecto.php                  # Proyectos del club (usa tabla existente)
├── Reunion.php                   # Reuniones programadas
├── AsistenciaReunion.php         # Asistencias a reunions
└── ParticipacionProyecto.php     # Participación en proyectos
```

### 💾 Tablas de Base de Datos

#### **Tablas NUEVAS** (creadas para el módulo):

##### 1. `carta_patrocinios`
```sql
- id (PK)
- numero_carta (UNIQUE)
- destinatario
- descripcion
- monto_solicitado
- estado (Pendiente, Aprobada, Rechazada, En Revision)
- fecha_solicitud
- fecha_respuesta
- proyecto_id (FK -> proyectos.ProyectoID)
- usuario_id (FK -> users.id)
- observaciones
- timestamps
```

##### 2. `carta_formals`
```sql
- id (PK)
- numero_carta (UNIQUE)
- destinatario
- asunto
- contenido
- tipo (Invitacion, Agradecimiento, Solicitud, Notificacion, Otro)
- estado (Borrador, Enviada, Recibida)
- fecha_envio
- usuario_id (FK -> users.id)
- observaciones
- timestamps
```

##### 3. `reunions`
```sql
- id (PK)
- titulo
- descripcion
- fecha_hora
- lugar
- tipo (Ordinaria, Extraordinaria, Junta Directiva, Comite)
- estado (Programada, En Curso, Finalizada, Cancelada)
- asistentes_esperados
- observaciones
- timestamps
```

##### 4. `asistencias_reunions`
```sql
- id (PK)
- reunion_id (FK -> reunions.id)
- usuario_id (FK -> users.id)
- asistio (boolean)
- hora_llegada
- tipo_asistencia (Presente, Ausente, Justificada, Tardanza)
- observaciones
- timestamps
- UNIQUE(reunion_id, usuario_id)
```

##### 5. `participacion_proyectos`
```sql
- id (PK)
- proyecto_id (FK -> proyectos.ProyectoID) [tabla existente]
- usuario_id (FK -> users.id)
- rol (Coordinador, Colaborador, Voluntario, Apoyo)
- fecha_inicio
- fecha_fin
- horas_dedicadas
- tareas_asignadas
- estado_participacion (Activo, Finalizado, Suspendido)
- observaciones
- timestamps
- UNIQUE(proyecto_id, usuario_id, fecha_inicio)
```

#### **Tablas EXISTENTES** (usadas por el módulo):
- ✅ `proyectos` - Proyectos del club (NO modificada)
- ✅ `users` - Usuarios del sistema (NO modificada)
- ✅ `asistencias` - Asistencias generales (NO modificada)
- ✅ `miembros` - Información de miembros (NO modificada)

---

## 🚀 Rutas del Módulo

Todas las rutas están protegidas con los middlewares:
- `auth` - Usuario autenticado
- `check.first.login` - Verificar primer login
- `RoleMiddleware::class:Vicepresidente|Presidente|Super Admin` - Roles autorizados

### Listado de Rutas:

```php
// Grupo: vicepresidente
Route::prefix('vicepresidente')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vicepresidente|Presidente|Super Admin'])->group(function () {
    
    // Dashboard Principal
    Route::get('/dashboard', [VicepresidenteController::class, 'dashboard'])
        ->name('vicepresidente.dashboard');
    
    // Gestión de Cartas de Patrocinio
    Route::get('/cartas/patrocinio', [VicepresidenteController::class, 'cartasPatrocinio'])
        ->name('vicepresidente.cartas.patrocinio');
    
    // Gestión de Cartas Formales
    Route::get('/cartas/formales', [VicepresidenteController::class, 'cartasFormales'])
        ->name('vicepresidente.cartas.formales');
    
    // Consulta de Estado de Proyectos
    Route::get('/estado/proyectos', [VicepresidenteController::class, 'estadoProyectos'])
        ->name('vicepresidente.estado.proyectos');
    
    // Consulta de Asistencia a Reuniones
    Route::get('/asistencia/reuniones', [VicepresidenteController::class, 'asistenciaReuniones'])
        ->name('vicepresidente.asistencia.reuniones');
    
    // Consulta de Participación en Proyectos
    Route::get('/asistencia/proyectos', [VicepresidenteController::class, 'asistenciaProyectos'])
        ->name('vicepresidente.asistencia.proyectos');
});
```

---

## 📊 Datos de Prueba

### Ejecutar el Seeder

Para poblar el módulo con datos de prueba:

```bash
php artisan db:seed --class=VicepresidenteModuloSeeder
```

### Datos Generados:

- **3 Cartas de Patrocinio** (Pendiente, Aprobada, En Revisión)
- **4 Cartas Formales** (Invitación, Agradecimiento, Solicitud, Notificación)
- **4 Reuniones** (2 finalizadas, 2 programadas)
- **10 Registros de Asistencia** (para reuniones finalizadas)
- **8 Participaciones en Proyectos** (vinculadas a proyectos existentes)

El seeder utiliza los **usuarios y proyectos existentes** en tu base de datos, por lo que no crea datos duplicados.

---

## 🎨 Características de las Vistas

### Dashboard Principal
- ✅ **Sistema de Tabs Integrado** - Navegación sin recargar página
- 📊 **Métricas en Tiempo Real** - Total de proyectos, reuniones, cartas pendientes
- 🎯 **5 Secciones Principales** - Todo accesible desde un solo lugar
- 🎨 **Diseño Responsivo** - Funciona en desktop, tablet y móvil
- 🌈 **Gradientes y Efectos** - Interfaz moderna y atractiva

### Gestión de Cartas de Patrocinio
- ✉️ Listado completo con filtros por estado
- 💰 Indicadores de monto solicitado y estado
- 🔗 Vinculación con proyectos existentes
- 📊 Estadísticas de cartas (pendientes, aprobadas, rechazadas)
- ✏️ Formularios para crear/editar cartas

### Gestión de Cartas Formales
- 📧 Tipos de carta: Invitación, Agradecimiento, Solicitud, Notificación
- 📋 Estados: Borrador, Enviada, Recibida
- 📅 Seguimiento de fechas de envío
- 🔍 Búsqueda y filtrado avanzado

### Estado de Proyectos
- 📊 Vista completa de todos los proyectos
- 👥 Información de participantes y responsables
- 💰 Montos de patrocinio aprobados
- ⏱️ Horas totales dedicadas
- 📈 Progreso y estado actual

### Asistencia a Reuniones
- 📅 Listado de todas las reuniones
- ✅ Porcentaje de asistencia calculado
- 👥 Detalle de asistentes por reunión
- 🕐 Registro de hora de llegada
- 📝 Observaciones y justificaciones

### Participación en Proyectos
- 👥 Participantes por proyecto
- 🎯 Roles asignados (Coordinador, Colaborador, Voluntario, Apoyo)
- ⏱️ Horas dedicadas por participante
- 📋 Tareas asignadas
- 📊 Estado de participación

---

## 🔒 Permisos y Roles

### Roles con Acceso:
- ✅ **Vicepresidente** - Acceso completo al módulo
- ✅ **Presidente** - Acceso completo (supervisión)
- ✅ **Super Admin** - Acceso completo (administración)

### Roles SIN Acceso:
- ❌ Tesorero
- ❌ Secretario
- ❌ Vocero
- ❌ Aspirante

---

## 🧪 Testing y Verificación

### Verificar Rutas
```bash
php artisan route:list --name=vicepresidente
```

### Verificar Tablas
```bash
php artisan tinker

# Contar registros
CartaPatrocinio::count();
CartaFormal::count();
Reunion::count();
AsistenciaReunion::count();
ParticipacionProyecto::count();
```

### Verificar Relaciones
```bash
php artisan tinker

# Obtener un proyecto con sus participaciones
$proyecto = Proyecto::with('participaciones')->first();

# Obtener una reunión con sus asistencias
$reunion = Reunion::with('asistencias')->first();

# Obtener cartas de un usuario
$cartas = CartaPatrocinio::where('usuario_id', 1)->get();
```

---

## 🛠️ Mantenimiento

### Limpiar Cachés
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Rollback de Migraciones (si es necesario)
```bash
# Ver las últimas 5 migraciones
php artisan migrate:status

# Hacer rollback de las migraciones del módulo
php artisan migrate:rollback --step=5
```

### Reejecutar Migraciones
```bash
# Ejecutar solo las nuevas migraciones
php artisan migrate
```

---

## 📝 Notas Importantes

### ⚠️ TABLAS PROTEGIDAS
El módulo **NO modifica ni elimina** las siguientes tablas existentes:
- ✅ `users` - Mantiene todos los usuarios
- ✅ `roles` - Mantiene todos los roles
- ✅ `proyectos` - Usa la tabla existente sin modificar
- ✅ `asistencias` - Tabla original intacta
- ✅ `miembros` - Información de miembros intacta

### 🔄 RELACIONES CON TABLAS EXISTENTES
- `carta_patrocinios.proyecto_id` → `proyectos.ProyectoID`
- `participacion_proyectos.proyecto_id` → `proyectos.ProyectoID`
- `asistencias_reunions` es **independiente** de `asistencias`

### 🚀 PRÓXIMAS MEJORAS
- [ ] Exportar cartas a PDF
- [ ] Envío de correos automáticos
- [ ] Notificaciones push
- [ ] Dashboard con gráficos interactivos
- [ ] Reportes en Excel
- [ ] Integración con calendario

---

## 📞 Soporte

Para cualquier duda o problema:
1. Verificar la documentación arriba
2. Revisar los logs: `storage/logs/laravel.log`
3. Ejecutar `php artisan config:clear && php artisan cache:clear`
4. Verificar permisos de archivos y carpetas

---

**Última actualización:** 17 de Octubre, 2025  
**Versión del Módulo:** 1.0.0  
**Desarrollado para:** Club Rotaract - Sistema de Gestión
