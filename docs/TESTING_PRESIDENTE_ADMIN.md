# Plan de Pruebas - Módulo Presidente en Admin

## 📋 Resumen de Cambios Implementados

### ✅ Correcciones Aplicadas

1. **AdminController - Método `presidenteCartasPatrocinio()`**
   - ✅ Agregadas estadísticas: total, pendientes, aprobadas, rechazadas, montoTotal
   - ✅ Incluye relación `usuario` en la consulta
   - ✅ Ordenamiento por `fecha_solicitud` DESC

2. **AdminController - Validaciones con FormRequest**
   - ✅ Importados: `CartaPatrocinioRequest`, `CartaFormalRequest`
   - ✅ `storeCartaFormal()` usa `CartaFormalRequest`
   - ✅ `updateCartaFormal()` usa `CartaFormalRequest`
   - ✅ `storeCartaPatrocinio()` usa `CartaPatrocinioRequest`
   - ✅ `updateCartaPatrocinio()` usa `CartaPatrocinioRequest`

3. **Diseño Responsivo Dashboard**
   - ✅ Reducido padding de contenedor (p-6 → p-4)
   - ✅ Reducido tamaño de encabezado (text-2xl → text-xl)
   - ✅ Estadísticas compactas (p-6 → p-4, text-4xl → text-2xl)
   - ✅ Gráfico más pequeño (height: 80 → 60)
   - ✅ Espaciado optimizado (gap-6 → gap-4)
   - ✅ Acciones rápidas compactas (p-4 → p-3, text-sm)

---

## 🧪 Plan de Pruebas Funcionales

### 1. Dashboard - Vista Principal

#### 1.1 Visualización de Estadísticas
- [ ] Verificar que muestra "Total Proyectos" con número correcto
- [ ] Verificar que muestra "Proyectos Activos" con número correcto
- [ ] Verificar que muestra "Cartas Pendientes" (suma de patrocinio + formales)
- [ ] Verificar que muestra "Reuniones Hoy" con número correcto
- [ ] Verificar que los iconos son proporcionales y no pixelados

#### 1.2 Gráfico de Actividad Mensual
- [ ] Verificar que el gráfico se renderiza correctamente
- [ ] Verificar que muestra datos de los últimos 6 meses
- [ ] Verificar que el tooltip muestra información correcta al hover
- [ ] Verificar que la leyenda es legible (Proyectos / Reuniones)
- [ ] Verificar que no se corta horizontalmente

#### 1.3 Calendario de Eventos
- [ ] Verificar que el calendario se muestra completo
- [ ] Verificar que se puede navegar entre meses
- [ ] Verificar que los eventos existentes aparecen en las fechas correctas
- [ ] Verificar colores por tipo de evento:
  - Reunión Virtual (azul)
  - Reunión Presencial (verde)
  - Inicio Proyecto (naranja)
  - Finalizar Proyecto (rojo)

#### 1.4 Acciones Rápidas
- [ ] Verificar enlace "Estado de Proyectos" → admin/presidente/estado/proyectos
- [ ] Verificar enlace "Cartas de Patrocinio" → admin/presidente/cartas/patrocinio
- [ ] Verificar enlace "Cartas Formales" → admin/presidente/cartas/formales
- [ ] Verificar que los iconos son correctos y legibles

---

### 2. Calendario - CRUD de Eventos

#### 2.1 Crear Evento
- [ ] Click en fecha vacía abre modal "Nuevo Evento"
- [ ] Validación: Título requerido (máx 100 caracteres)
- [ ] Validación: No permite más de 2 caracteres repetidos consecutivos
- [ ] Validación: Tipo de evento requerido
- [ ] Validación: Fecha fin debe ser mayor a fecha inicio
- [ ] Guardar evento exitosamente
- [ ] Evento aparece en el calendario
- [ ] Mensaje de éxito se muestra
- [ ] Se envía notificación a todos los usuarios

**Casos de Prueba:**
```
✓ Evento válido: "Reunión Mensual", reunión-virtual, fecha válida
✗ Título inválido: "Reeeeeunión" (más de 2 'e' consecutivas)
✗ Fecha inválida: Fecha fin < Fecha inicio
```

#### 2.2 Ver Detalle Evento
- [ ] Click en evento existente muestra detalles
- [ ] Modal muestra: Título, Descripción, Tipo, Estado, Fechas, Ubicación
- [ ] Botones "Editar" y "Eliminar" visibles

#### 2.3 Editar Evento
- [ ] Click en "Editar" carga datos en el formulario
- [ ] Validaciones igual que crear
- [ ] Actualizar exitosamente
- [ ] Cambios reflejados en calendario
- [ ] Se envía notificación de actualización

#### 2.4 Eliminar Evento
- [ ] Click en "Eliminar" muestra confirmación SweetAlert2
- [ ] Confirmar eliminación
- [ ] Evento desaparece del calendario
- [ ] Mensaje de éxito

#### 2.5 Drag & Drop (Mover Evento)
- [ ] Arrastrar evento a otra fecha
- [ ] Se actualiza fecha_inicio y fecha_fin
- [ ] Se envía notificación de reprogramación
- [ ] Mensaje de éxito

---

### 3. Cartas de Patrocinio

#### 3.1 Vista Principal
- [ ] Tabla muestra columnas: Fecha Envío, Destinatario, Proyecto, Monto, Estado, Acciones
- [ ] Estadísticas en la parte superior:
  - Total de cartas
  - Pendientes
  - Aprobadas
  - Rechazadas
  - Monto Total Aprobado
- [ ] Paginación funciona correctamente
- [ ] Filtros disponibles: Estado, Proyecto, Rango de fechas

#### 3.2 Crear Carta de Patrocinio
- [ ] Click en "Nueva Carta" abre modal
- [ ] Validación: Destinatario requerido (máx 255 caracteres)
- [ ] Validación: No más de 2 caracteres repetidos consecutivos
- [ ] Validación: Monto requerido, numérico, >= 0
- [ ] Validación: Proyecto requerido y existente en BD
- [ ] Número de carta se genera automáticamente si no se proporciona
- [ ] Número de carta es único (no duplicados)
- [ ] Estado por defecto: "Pendiente"
- [ ] Guardar exitosamente
- [ ] Redirección a `admin.presidente.cartas.patrocinio`
- [ ] Mensaje de éxito con número de carta

**Casos de Prueba:**
```
✓ Carta válida:
  - Destinatario: "Empresa ABC S.A."
  - Monto: 5000
  - Proyecto: ID válido
  - Descripción: "Solicitud para evento benéfico"

✗ Destinatario inválido: "Empressssssa" (más de 2 's')
✗ Monto inválido: -500 (negativo)
✗ Proyecto inválido: ID que no existe
```

#### 3.3 Ver Detalle Carta
- [ ] Click en icono "ojo" muestra modal con detalles
- [ ] Muestra: Número, Destinatario, Proyecto, Monto, Estado, Fechas, Observaciones

#### 3.4 Editar Carta
- [ ] Click en icono "lápiz" abre modal edición
- [ ] Datos precargados correctamente
- [ ] Validaciones igual que crear
- [ ] Número de carta se mantiene o genera nuevo si está vacío
- [ ] Actualizar exitosamente
- [ ] Cambios reflejados en la tabla

#### 3.5 Eliminar Carta
- [ ] Click en icono "basura" muestra confirmación
- [ ] Confirmar eliminación
- [ ] Carta desaparece de la tabla
- [ ] Mensaje de éxito con número de carta eliminada

#### 3.6 Descargar PDF
- [ ] Click en botón "PDF" descarga documento
- [ ] PDF contiene información correcta
- [ ] Formato profesional

#### 3.7 Filtros y Búsqueda
- [ ] Filtro por estado (Pendiente/Aprobada/Rechazada/En Revisión)
- [ ] Filtro por proyecto (dropdown)
- [ ] Filtro por rango de fechas
- [ ] Búsqueda por destinatario
- [ ] Botón "Limpiar filtros" restaura vista completa

---

### 4. Cartas Formales

#### 4.1 Vista Principal
- [ ] Tabla muestra columnas: Fecha Envío, Destinatario, Asunto, Tipo, Estado, Acciones
- [ ] Paginación funciona

#### 4.2 Crear Carta Formal
- [ ] Click en "Nueva Carta" abre modal
- [ ] Validación: Destinatario requerido (máx 255 caracteres)
- [ ] Validación: Asunto requerido (máx 255 caracteres)
- [ ] Validación: Contenido requerido
- [ ] Validación: No más de 2 caracteres repetidos en ningún campo
- [ ] Validación: Tipo requerido (Invitacion/Agradecimiento/Solicitud/Notificacion/Otro)
- [ ] Número de carta se genera automáticamente
- [ ] Estado por defecto: "Borrador"
- [ ] Guardar exitosamente
- [ ] Redirección a `admin.presidente.cartas.formales`

**Casos de Prueba:**
```
✓ Carta válida:
  - Destinatario: "Alcaldía Municipal"
  - Asunto: "Invitación Evento Anual"
  - Contenido: "Por medio de la presente..."
  - Tipo: "Invitacion"

✗ Asunto inválido: "Invitacióóóón" (más de 2 'ó')
✗ Tipo inválido: "TipoInventado"
```

#### 4.3 Editar Carta Formal
- [ ] Modal de edición carga datos
- [ ] Validaciones igual que crear
- [ ] Actualizar exitosamente

#### 4.4 Eliminar Carta Formal
- [ ] Confirmación antes de eliminar
- [ ] Eliminación exitosa

#### 4.5 Descargar Documento
- [ ] Descargar como PDF
- [ ] Descargar como Word (.docx)

---

### 5. Estado de Proyectos

#### 5.1 Vista Principal
- [ ] Estadísticas: Total, Activos, Completados, Pendientes
- [ ] Tabla con proyectos ordenados por fecha
- [ ] Columnas: Nombre, Descripción, Fecha Inicio, Fecha Fin, Presupuesto, Estado, Acciones

#### 5.2 Crear Proyecto
- [ ] Validación: Nombre requerido (máx 255 caracteres)
- [ ] Validación: Fecha fin >= Fecha inicio
- [ ] Validación: Presupuesto numérico >= 0
- [ ] Validación: ResponsableID existe en miembros
- [ ] Estado automático: "Activo"
- [ ] EstadoProyecto automático: "En Ejecución" si tiene FechaInicio, sino "Planificación"
- [ ] Guardar exitosamente

#### 5.3 Editar Proyecto
- [ ] Datos precargados
- [ ] Validaciones igual que crear
- [ ] Estado del proyecto se actualiza según fechas:
  - Si tiene FechaFin → "Finalizado"
  - Si tiene FechaInicio sin FechaFin → "En Ejecución"
- [ ] Actualizar exitosamente

#### 5.4 Eliminar Proyecto
- [ ] NO permite eliminar si tiene participaciones
- [ ] NO permite eliminar si tiene cartas de patrocinio
- [ ] Mensaje de error informativo
- [ ] SI permite eliminar si no tiene relaciones
- [ ] Confirmación antes de eliminar

---

## 🔐 Pruebas de Seguridad y Validación

### Validaciones de Entrada

#### Caracteres Repetidos
```php
// Estas pruebas deben FALLAR
$tests = [
    'Títulos' => 'Reeeunión Mensual', // 3 'e' consecutivas
    'Descripciones' => 'Proyectooooo especial', // 5 'o' consecutivas
    'Nombres' => 'Juuuuuan Pérez', // 5 'u' consecutivas
];
```

#### Fechas Inválidas
- [ ] Fecha fin antes de fecha inicio → Error
- [ ] Fechas con formato incorrecto → Error

#### Montos Negativos
- [ ] Monto: -1000 → Error
- [ ] Presupuesto: -500 → Error

#### Campos Únicos
- [ ] Número de carta duplicado → Error
- [ ] Mensaje claro indicando duplicado

---

## 🎨 Pruebas de Diseño Responsivo

### Dashboard

#### Escritorio (1920x1080)
- [ ] Estadísticas en 4 columnas
- [ ] Gráfico y calendario lado a lado
- [ ] Sin scroll horizontal
- [ ] Todos los elementos visibles

#### Laptop (1366x768)
- [ ] Estadísticas legibles
- [ ] Gráfico proporcional
- [ ] Calendario completo
- [ ] Sidebar no obstruye contenido

#### Tablet (768x1024)
- [ ] Estadísticas en 2 columnas
- [ ] Gráfico apilado sobre calendario
- [ ] Navegación funcional

---

## 📊 Pruebas de Integración

### Base de Datos

#### Stored Procedures (Calendario)
- [ ] `sp_crear_evento_calendario` funciona correctamente
- [ ] `sp_actualizar_evento` funciona correctamente
- [ ] `sp_eliminar_evento` funciona correctamente
- [ ] `sp_obtener_detalle_evento` retorna datos completos

#### Relaciones Eloquent
- [ ] CartaPatrocinio → Proyecto (belongsTo)
- [ ] CartaPatrocinio → Usuario (belongsTo)
- [ ] Proyecto → CartasPatrocinio (hasMany)
- [ ] Proyecto → Participaciones (hasMany)

---

## 🔄 Pruebas de Notificaciones

### Eventos de Calendario
- [ ] Crear evento → Notifica a todos los usuarios
- [ ] Actualizar evento → Notifica a participantes
- [ ] Cambiar fecha (drag & drop) → Notifica reprogramación
- [ ] Contenido de notificación correcto
- [ ] Enlace en notificación funciona

---

## ✅ Checklist Final

### Funcionalidad Completa
- [ ] Todas las vistas cargan correctamente
- [ ] Todos los formularios validan correctamente
- [ ] Todos los CRUD funcionan (Create, Read, Update, Delete)
- [ ] Todas las rutas redirigen correctamente a `admin.presidente.*`
- [ ] No hay errores en consola del navegador
- [ ] No hay errores en `storage/logs/laravel.log`

### Validaciones
- [ ] CartaPatrocinioRequest funciona
- [ ] CartaFormalRequest funciona
- [ ] Validaciones inline de proyectos funcionan
- [ ] Mensajes de error son claros y en español

### Diseño
- [ ] Dashboard cabe en pantalla sin scroll horizontal
- [ ] Elementos proporcionales y legibles
- [ ] Colores consistentes con diseño admin
- [ ] Iconos FontAwesome cargan correctamente

### Seguridad
- [ ] Middleware `auth` protege todas las rutas
- [ ] RoleMiddleware restringe a 'Super Admin'
- [ ] No hay SQL injection posible (uso de Eloquent/PDO)
- [ ] CSRF tokens en todos los formularios

---

## 🐛 Reporte de Bugs

### Formato de Reporte
```
❌ [ÁREA] Descripción del problema
Pasos para reproducir:
1. ...
2. ...
Resultado esperado: ...
Resultado actual: ...
```

### Bugs Encontrados
_(Espacio para documentar bugs durante testing)_

---

## 📝 Notas Adicionales

- Todos los tests deben ejecutarse con usuario de rol "Super Admin"
- Limpiar caché entre pruebas: `php artisan optimize:clear`
- Verificar logs: `tail -f storage/logs/laravel.log`
- Probar en navegador Chrome/Edge actualizado

---

**Fecha de Creación:** 2025-01-XX  
**Responsable:** Equipo de Desarrollo  
**Estado:** 🔄 En Pruebas
