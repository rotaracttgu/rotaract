# 📋 Módulo de Secretaría - Sistema Rotaract

## 🎨 Paleta de Colores

El módulo de secretaría utiliza una paleta de colores moderna y profesional con gradientes dinámicos:

### Colores Principales

1. **Turquoise (Turquesa)**
   - From: `#74B6C0` (RGB: 116, 182, 192)
   - To: `#00ADDB` (RGB: 0, 173, 219)
   - Uso: Estadísticas de actas, elementos informativos

2. **Orange (Naranja)**
   - From: `#FF7D00` (RGB: 255, 125, 0)
   - To: `#C0A656` (RGB: 192, 166, 86)
   - Uso: Diplomas, acciones destacadas

3. **Violet (Violeta)**
   - From: `#9B01F3` (RGB: 155, 1, 243)
   - To: `#631B47` (RGB: 99, 27, 71)
   - Uso: Consultas, elementos primarios

4. **Grass (Verde)**
   - From: `#009759` (RGB: 0, 151, 89)
   - To: `#C1C100` (RGB: 193, 193, 0)
   - Uso: Documentos, estados exitosos

5. **Powder Blue (Azul Polvo)**
   - From: `#B8D4DA` (RGB: 184, 212, 218)
   - To: `#6217B235` (RGB: 98, 23, 178, 0.21)
   - Uso: Elementos secundarios, fondos suaves

## 🚀 Características

### Dashboard Principal
- **Estadísticas en Tiempo Real**: Visualización de métricas clave con iconos animados
- **Gradientes Dinámicos**: Cada tarjeta utiliza gradientes suaves para mejor experiencia visual
- **Tarjetas Interactivas**: Efectos hover con transformaciones 3D
- **Accesos Rápidos**: Navegación directa a todas las secciones del módulo

### Funcionalidades

1. **Gestión de Consultas**
   - Recepción y seguimiento de consultas
   - Sistema de estados (pendiente/respondida)
   - Notificaciones de consultas nuevas

2. **Gestión de Actas**
   - Registro de actas ordinarias y extraordinarias
   - Almacenamiento de orden del día y acuerdos
   - Control de asistentes y estados

3. **Gestión de Diplomas**
   - Emisión de diplomas de reconocimiento, participación y excelencia
   - Sistema de envío por email
   - Seguimiento de diplomas emitidos

4. **Gestión de Documentos**
   - Archivo general de documentos
   - Categorización por tipo (oficial, administrativo, general)
   - Búsqueda y descarga de archivos

## 📊 Componentes del Dashboard

### Header
- Título con gradiente violeta-turquesa
- Botones de acción:
  - Actualizar datos
  - Ir al inicio
  - Crear nuevo (menú desplegable)
  - Cerrar sesión

### Estadísticas Principales (Grid 4 columnas)
1. **Consultas Pendientes** (Violeta)
2. **Actas Registradas** (Turquesa)
3. **Diplomas Emitidos** (Naranja)
4. **Documentos Archivados** (Verde)

### Accesos Rápidos
- 4 tarjetas con acceso directo a cada módulo
- Badges con contadores actualizados

### Contenido en Dos Columnas

**Columna Izquierda:**
- Consultas Recientes
- Documentos Recientes

**Columna Derecha:**
- Últimas Actas
- Últimos Diplomas
- Actividad Reciente

## 🗄️ Base de Datos

### Tablas Utilizadas

#### `consultas`
```sql
- id
- nombre
- apellido
- email
- telefono
- asunto
- consulta
- estado (pendiente/respondida)
- respuesta
- fecha_respuesta
- timestamps
```

#### `actas`
```sql
- id
- titulo
- tipo_documento
- tipo_acta (ordinaria/extraordinaria)
- fecha_reunion
- lugar_reunion
- hora_inicio
- hora_fin
- asistentes (JSON)
- orden_dia (JSON)
- desarrollo
- acuerdos (JSON)
- ruta_archivo
- estado (borrador/aprobada)
- timestamps
```

#### `diplomas`
```sql
- id
- titulo
- tipo_documento
- tipo_diploma (reconocimiento/participacion/excelencia)
- beneficiario
- motivo
- fecha_emision
- firmante
- ruta_archivo
- estado (borrador/emitido)
- enviado_email
- timestamps
```

#### `documentos`
```sql
- id
- titulo
- tipo_documento
- categoria
- descripcion
- ruta_archivo
- fecha_subida
- timestamps
```

## 🌱 Seeders

### Ejecutar el Seeder

```bash
php artisan db:seed --class=SecretariaModuloSeeder
```

Este seeder crea:
- 3 consultas de ejemplo
- 2 actas (ordinaria y extraordinaria)
- 3 diplomas (reconocimiento, participación, excelencia)
- 4 documentos generales

## 🎯 Rutas Principales

```php
Route::prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('/dashboard', [SecretariaController::class, 'dashboard'])->name('dashboard');
    
    // Consultas
    Route::get('/consultas', [SecretariaController::class, 'consultas'])->name('consultas');
    Route::get('/consultas/{id}', [SecretariaController::class, 'getConsulta']);
    Route::post('/consultas/{id}/responder', [SecretariaController::class, 'responderConsulta']);
    Route::delete('/consultas/{id}', [SecretariaController::class, 'eliminarConsulta']);
    
    // Actas
    Route::get('/actas', [SecretariaController::class, 'actas'])->name('actas');
    Route::post('/actas', [SecretariaController::class, 'storeActa']);
    Route::post('/actas/{id}', [SecretariaController::class, 'updateActa']);
    Route::delete('/actas/{id}', [SecretariaController::class, 'eliminarActa']);
    
    // Diplomas
    Route::get('/diplomas', [SecretariaController::class, 'diplomas'])->name('diplomas');
    Route::post('/diplomas', [SecretariaController::class, 'storeDiploma']);
    Route::post('/diplomas/{id}', [SecretariaController::class, 'updateDiploma']);
    Route::delete('/diplomas/{id}', [SecretariaController::class, 'eliminarDiploma']);
    Route::post('/diplomas/{id}/enviar-email', [SecretariaController::class, 'enviarEmailDiploma']);
    
    // Documentos
    Route::get('/documentos', [SecretariaController::class, 'documentos'])->name('documentos');
});
```

## 💡 Mejoras Implementadas

### Diseño Visual
- ✅ Paleta de colores personalizada con gradientes
- ✅ Animaciones suaves y transiciones fluidas
- ✅ Efectos hover interactivos con transformaciones 3D
- ✅ Sombras dinámicas y profundidad visual
- ✅ Tipografía mejorada con pesos variables

### Funcionalidad
- ✅ Botón de cerrar sesión en el header
- ✅ Botón de regreso al inicio
- ✅ Dropdown mejorado para crear nuevos elementos
- ✅ Tarjetas clickeables con navegación directa
- ✅ Estados visuales claros (pendiente, aprobado, etc.)

### Organización
- ✅ Header destacado con información clara
- ✅ Estadísticas en grid responsive
- ✅ Accesos rápidos organizados
- ✅ Contenido en dos columnas para mejor aprovechamiento del espacio
- ✅ Empty states informativos

## 📱 Responsive Design

El dashboard es completamente responsive:
- **Desktop (>1400px)**: Grid de 4 columnas
- **Tablet (1024px - 1400px)**: Grid de 2 columnas
- **Mobile (<768px)**: Grid de 1 columna

## 🔐 Permisos y Roles

El módulo está protegido por middleware y solo es accesible para usuarios con los roles:
- Secretario
- Presidente
- Super Admin

## 📝 Notas de Implementación

1. Todas las variables CSS están definidas en `:root` para fácil mantenimiento
2. Los gradientes utilizan las funciones nativas de CSS para mejor rendimiento
3. Las animaciones usan `cubic-bezier` para transiciones más naturales
4. Los componentes son modulares y reutilizables
5. El código sigue las convenciones de Laravel y Blade

## 🎨 Personalización

Para modificar los colores, edita las variables CSS en el archivo del dashboard:

```css
:root {
    --color-turquoise-from: #74B6C0;
    --color-turquoise-to: #00ADDB;
    /* ... más variables ... */
}
```

## 📞 Soporte

Para cualquier duda o sugerencia sobre el módulo de secretaría, contacta al equipo de desarrollo.

---

**Versión**: 2.0  
**Última actualización**: Octubre 2025  
**Desarrollado para**: Sistema de Gestión Rotaract TGU
