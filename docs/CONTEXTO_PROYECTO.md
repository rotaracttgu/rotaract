# 📋 Contexto del Proyecto Rotaract - Flujo Integrado

**Fecha:** Noviembre 23, 2025  
**Estado:** En Desarrollo (Dev Branch)  
**Última Actualización:** Implementación de Gestión de Participantes

---

## 🎯 Objetivo Principal

Implementar el **Flujo Integrado (Opción A)** que conecta dos sistemas previamente separados:

```
Presidente crea Proyecto 
    ↓
ProyectoObserver detecta creación
    ↓
Auto-crea Evento de Calendario
    ↓
Presidente gestiona Participantes del Proyecto
    ↓
Sistema actualiza ambas tablas automáticamente
```

---

## ✅ Historial de Tareas Completadas

### Fase 1: Correcciones de Base de Datos
- **6 Stored Procedures (SPs) corregidos:**
  - Errores de collation (utf8mb4_unicode_ci vs utf8_general_ci)
  - Nombres de columnas incorrectos
  - Joins mal definidos
  
- **Errores 500 solucionados:**
  - Consultas: undefined property error
  - Asistencias: column names en SP
  - Rol display: ahora muestra RolPerfil correctamente

### Fase 2: Sistema de Observadores
- ✅ **Creado ProyectoObserver** (`app/Observers/ProyectoObserver.php`)
  - Hook `created()`: crea calendario cuando se crea proyecto
  - Hook `updated()`: actualiza calendario si cambian fechas
  - Hook `deleted()`: elimina calendario cuando se elimina proyecto
  
- ✅ **Registrado en AppServiceProvider**
  - Agregado: `Proyecto::observe(ProyectoObserver::class);`

### Fase 3: Sincronización de Datos Históricos
- ✅ **Comando creado:** `php artisan sync:proyectos-calendarios`
- ✅ **Ejecutado en servidor:** 1 proyecto sincronizado
  - Proyecto: "Reparacion de pupitres" (ProyectoID=1)
  - Ahora existe en: `proyectos` + `calendarios` (CalendarioID=16)
  - TipoEvento: 'InicioProyecto'

### Fase 4: Gestión de Participantes - PRESIDENTE ✅
Implementado en: `/presidente/estado/proyectos`

**Features:**
- 📌 Botón azul con icono de personas para gestionar participantes
- 📋 Modal que muestra:
  - Tabla con participantes actuales
  - Columnas: Miembro (nombre completo), Rol Perfil, Acciones
  - Botón "Eliminar" para cada participante
  
- ➕ Form para agregar participantes:
  - Dropdown con lista de miembros
  - Formato: "Nombre Apellido - Rol Perfil"
  - Selector de rol en proyecto (Responsable, Participante, Colaborador)
  - Botón "Agregar Participante"

**API Endpoints:**
```
GET    /presidente/proyectos/{id}/participantes          → getParticipantes()
POST   /presidente/proyectos/{id}/participantes          → addParticipante()
DELETE /presidente/proyectos/{id}/participantes/{partId} → removeParticipante()
```

### Fase 5: Gestión de Participantes - VICEPRESIDENTE ✅
Implementado en: `/vicepresidente/estado/proyectos`

**Funcionalidad:** Idéntica a Presidente
- Mismo modal
- Mismo botón
- Mismas rutas (con prefijo `vicepresidente`)
- Métodos heredados vía trait `ManagesProjects`

---

## 🔧 Stack Técnico

| Componente | Versión |
|-----------|---------|
| **Framework** | Laravel 12.37.0 |
| **PHP** | 8.3.x |
| **MySQL** | 8.0.44 |
| **Node.js** | (para build frontend) |
| **Vite** | (bundler CSS/JS) |
| **Tailwind CSS** | (estilos) |
| **Alpine.js** | (interactividad) |

### Infraestructura
- **Servidor:** DigitalOcean
- **IP:** 64.23.239.0
- **Ruta Proyecto:** `/var/www/laravel`
- **Versionado:** GitHub (`rotaracttgu/rotaract`)
- **Branch Activa:** `Dev`

---

## 📊 Estructura Base de Datos - Tablas Clave

### ✅ `proyectos`
```sql
ProyectoID (PK)
Nombre
Descripcion
FechaInicio
FechaFin
Presupuesto
ResponsableID (FK → miembros)
Estatus (Activo, Inactivo, Cancelado)
EstadoProyecto (Planificación, En Ejecución, Finalizado)
Area (Educación, Salud, etc)
```

### ✅ `calendarios`
```sql
CalendarioID (PK)
TituloEvento
Descripcion
TipoEvento (InicioProyecto, Evento, Reunión, etc) ← Auto-generado por Observer
HoraInicio
HoraFin
Fecha (o similar para eventos de calendario)
```

### ⚠️ `participaciones` - **ESTRUCTURA ACTUAL**
```sql
ParticipacionID (PK)
MiembroID (FK → miembros)
ProyectoID (FK → proyectos)
Rol (Responsable, Participante, Colaborador) ← Rol en el proyecto
FechaIngreso
FechaSalida
EstadoParticipacion (Activo, Inactivo, etc)

❌ NO TIENE: horasDedicadas (fue corregido en todas las queries)
```

### ✅ `miembros`
```sql
MiembroID (PK)
user_id (FK → users)
Rol (Socio, Participante, Aspirante, Excedencia) ← RolPerfil
FechaIngreso
Apuntes
```

### ✅ `users`
```sql
id (PK)
name (Nombre)
apellidos (Apellidos) ← Importante: campo separado
email
username
dni
telefono
rotary_id
activo (tinyint boolean)
... (otros campos de seguridad, 2FA, etc)
```

---

## 🔑 Conceptos Importantes

### Dos Sistemas Ahora Integrados

| Sistema | Tabla | Propósito | Gestión |
|---------|-------|----------|---------|
| **Macero (Calendar)** | `calendarios` | Eventos de reuniones y actividades | Presidente (Macero) |
| **Estado Proyectos** | `proyectos` | Proyectos reales del club | Presidente/Vicepresidente |
| **Integrador** | ProyectoObserver | Sincronización automática | Sistema |

**Conexión:** Cuando se crea un proyecto con `FechaInicio`, el Observer auto-crea un evento en `calendarios` con `TipoEvento='InicioProyecto'`

### Roles del Perfil (miembros.Rol)
```
Socio         → Miembro activo con todos los derechos
Participante  → Puede participar en actividades
Aspirante     → En proceso de ingreso al club
Excedencia    → Temporalmente inactivo
```

### Roles en Participación (participaciones.Rol)
```
Responsable  → Lidera/coordina el proyecto
Participante → Participa activamente
Colaborador  → Ofrece apoyo
```

### Dropdown de Miembros - Formato Display
```
"Carlos García - Socio"
"Pedro López - Participante"
"Andrea Ruiz - Socio"
```
Formato: `{name} {apellidos} - {miembros.Rol}`

---

## 📁 Archivos Modificados / Creados

### NUEVOS Archivos
```
app/Observers/ProyectoObserver.php
├─ created()        → Crea calendario
├─ updated()        → Actualiza calendario
└─ deleted()        → Elimina calendario

app/Console/Commands/CheckParticipaciones.php
└─ Comando para verificar estructura de participaciones
```

### MODIFICADOS - Backend
```
app/Providers/AppServiceProvider.php
├─ Agregó: Proyecto::observe(ProyectoObserver::class);

app/Traits/ManagesProjects.php
├─ getParticipantes($id)
│  └─ Query: Joins participaciones→miembros→users
│  └─ Returns: JSON con miembro_nombre, rol_perfil, participacion_id
├─ addParticipante(Request $request, $id)
│  └─ Valida: miembro_id, rol
│  └─ Previene duplicados
├─ removeParticipante($id, $participacionId)
│  └─ Autoriza y elimina

routes/web.php
├─ PRESIDENTE: 3 rutas nuevas
│  ├─ GET    /presidente/proyectos/{id}/participantes
│  ├─ POST   /presidente/proyectos/{id}/participantes
│  └─ DELETE /presidente/proyectos/{id}/participantes/{participacionId}
├─ VICEPRESIDENTE: 3 rutas nuevas (mismo patrón)
```

### MODIFICADOS - Frontend
```
resources/views/modulos/presidente/estado-proyectos.blade.php
├─ Botón participantes (icono personas azul)
├─ Modal #modalParticipantes
│  ├─ Tabla con participantes actuales
│  ├─ Form para agregar participante
│  └─ Funciones JS para CRUD
├─ Dropdown mostra: nombre + apellido + rol
├─ Funciones JavaScript:
│  ├─ abrirModalParticipantes(proyectoId)
│  ├─ cerrarModalParticipantes()
│  ├─ cargarParticipantes(proyectoId)
│  ├─ agregarParticipante(event)
│  ├─ eliminarParticipante(proyectoId, participacionId)
│  └─ baseRoute = 'presidente'

resources/views/modulos/vicepresidente/estado-proyectos.blade.php
├─ (Idéntica estructura a presidente)
├─ baseRoute = 'vicepresidente'
└─ (Reutiliza mismo código pero con prefijo diferente)
```

---

## ⚠️ Errores Corregidos - Aprende de Ellos

### Error 1: Columna `horasDedicadas` que NO EXISTE
```php
// ❌ MALO - Intentaba seleccionar columna inexistente
SELECT participaciones.horasDedicadas as horas_dedicadas

// ✅ BUENO - Usa valor fijo o columna que existe
SELECT 0 as horas_dedicadas
```

### Error 2: Case Sensitivity en JSON
```php
// ❌ MALO - Field names inconsistentes
$p->horasDedicadas    // camelCase en DB
$p->horas_dedicadas   // snake_case esperado en JS

// ✅ BUENO - Usar alias correcto en SELECT
SELECT participaciones.Rol as rol_participacion,
       miembros.Rol as rol_perfil
```

### Error 3: Nombre vs Nombre + Apellido
```php
// ❌ MALO - Solo nombre
SELECT users.name as miembro_nombre

// ✅ BUENO - Concatenado
SELECT CONCAT(users.name, ' ', COALESCE(users.apellidos, '')) as miembro_nombre
```

### Error 4: Collation Mismatch en Joins
```sql
-- ❌ MALO - Diferentes collations
WHERE users.name = participaciones.nombre  -- ¡Collations distintos!

-- ✅ BUENO - Joins por ID
WHERE participaciones.MiembroID = miembros.MiembroID
AND miembros.user_id = users.id
```

---

## 🚀 Flujo de Uso - Paso a Paso

### Para Presidente

**1. Acceder al módulo:**
```
Menú → Estado Proyectos
o URL: https://clubrotaractsur.com/presidente/estado/proyectos
```

**2. Ver proyectos:**
- Muestra tarjetas con todos los proyectos
- Cada proyecto tiene botones de acción

**3. Gestionar participantes:**
```
Clic en botón azul (personas) 
  → Modal se abre
  → Tabla muestra participantes actuales
  → Form para agregar nuevo
  → Clic "Agregar Participante"
    → Selecciona miembro del dropdown
    → Elige rol (Responsable/Participante/Colaborador)
    → Clic "Agregar"
    → Modal se recarga con nuevo participante
```

**4. Eliminar participante:**
```
Clic en "Eliminar" 
  → Confirmación
  → Eliminado y modal se recarga
```

### Para Vicepresidente
- **Idéntico al flujo de Presidente**
- URL: `https://clubrotaractsur.com/vicepresidente/estado/proyectos`

---

## 📡 API Response Examples

### GET /presidente/proyectos/{id}/participantes
```json
[
  {
    "participacion_id": 1,
    "miembro_nombre": "Carlos García López",
    "rol_perfil": "Socio",
    "rol_participacion": "Responsable"
  },
  {
    "participacion_id": 2,
    "miembro_nombre": "Pedro Rodríguez",
    "rol_perfil": "Participante",
    "rol_participacion": "Participante"
  }
]
```

### POST /presidente/proyectos/{id}/participantes
**Request:**
```json
{
  "miembro_id": 3,
  "rol": "Colaborador"
}
```

**Response (200):**
```json
{
  "success": true
}
```

**Response (409):**
```json
{
  "error": "Este miembro ya está en el proyecto"
}
```

### DELETE /presidente/proyectos/{id}/participantes/{participacionId}
**Response (200):**
```json
{
  "success": true
}
```

---

## 🔒 Permisos y Seguridad

### Middleware Aplicado
- `auth` - Usuario debe estar autenticado
- `check.first.login` - Verificar si es primer login

### Autorización
- Solo **Presidente** puede acceder a `/presidente/...`
- Solo **Vicepresidente** puede acceder a `/vicepresidente/...`
- Permisos basados en tabla `permissions`

---

## 📝 Notas Importantes para Próximos Desarrollos

1. **La tabla `participaciones` NO tiene `horasDedicadas`**
   - Si se necesita tracking de horas, considerar agregar columna
   - O usar tabla separada `horas_proyecto`

2. **Observer tiene lógica de calendario**
   - Si TipoEvento debe ser diferente, modificar `ProyectoObserver.php`
   - Mapeo actual: Proyecto → TipoEvento='InicioProyecto'

3. **Formato de nombre siempre es concatenado**
   - Cambiar en query si se necesita otro formato
   - Current: `CONCAT(name, ' ', apellidos)`

4. **Dropdown es READ-ONLY desde backend**
   - La lista se genera al cargar la página (Blade)
   - Para agregar filtro dinámico, considerar AJAX

5. **Modal es compartido en Presidente y Vicepresidente**
   - Código muy similar, considerar componente Blade reutilizable
   - `baseRoute` variable debe estar definida en cada blade

---

## 🧪 Testing Local

### Verificar Participantes en Proyecto
```bash
# En terminal del servidor local
php artisan tinker

# Listar participantes del proyecto 1
DB::table('participaciones')
  ->where('ProyectoID', 1)
  ->join('miembros', 'participaciones.MiembroID', '=', 'miembros.MiembroID')
  ->join('users', 'miembros.user_id', '=', 'users.id')
  ->select('users.name', 'users.apellidos', 'miembros.Rol', 'participaciones.Rol')
  ->get();
```

### Crear Proyecto de Prueba
```bash
php artisan tinker

$proyecto = App\Models\Proyecto::create([
  'Nombre' => 'Test Project',
  'Descripcion' => 'Testing',
  'FechaInicio' => now(),
  'FechaFin' => now()->addDays(7),
  'Estatus' => 'Activo'
]);

# Verificar que se creó calendario automáticamente
DB::table('calendarios')->where('TipoEvento', 'InicioProyecto')->latest()->first();
```

---

## 📞 Contacto / Documentación Adicional

**Archivos de Documentación en el Proyecto:**
- `/docs/APLICAR_REFACTORIZACION.md`
- `/docs/CAMBIOS_TESORERO_IMPLEMENTADOS.md`
- `/dev-scripts/README.md`

**Branch Activa:** `Dev`  
**Merge to Production:** Coordinado con equipo de DevOps

---

**Última Actualización:** 23 de Noviembre, 2025  
**Responsable:** Sistema Rotaract
