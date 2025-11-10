# 📊 MÓDULO TESORERO - DOCUMENTACIÓN COMPLETA

## 🎯 Descripción General

El **Módulo Tesorero** es un sistema completo de gestión financiera para el Club Rotaract. Permite registrar, gestionar, aprobar y reportar ingresos, gastos, membresías, presupuestos y transferencias bancarias con alertas en tiempo real.

---

## ✨ Características Principales

### 1. **Dashboard Financiero**
- Vista general de ingresos y gastos
- Resumen de membresías activas
- Presupuestos mensuales
- Notificaciones en tiempo real

### 2. **Gestión de Ingresos**
- Registro de nuevos ingresos
- Clasificación por origen
- Métodos de recepción (transferencia, efectivo, cheque, etc)
- Historial completo con auditoría

### 3. **Gestión de Gastos**
- Creación y edición de gastos
- Sistema de aprobación de dos niveles
- Estados: Pendiente, Aprobado, Rechazado
- Seguimiento por categoría

### 4. **Gestión de Membresías**
- Registro de pagos de membresías
- Seguimiento de vencimientos
- Alertas de próximas a vencer
- Historial de pagos por miembro

### 5. **Presupuestos**
- Presupuestos por categoría y mes
- Seguimiento de ejecución
- Alertas cuando se excede presupuesto
- Comparativa presupuestado vs ejecutado

### 6. **Transferencias Bancarias**
- Registro de transferencias entre cuentas
- Cálculo de comisiones
- Historial de movimientos
- Conciliación de cuentas

### 7. **Notificaciones en Tiempo Real**
- Polling cada 30 segundos
- Alertas automáticas para eventos críticos
- Badges dinámicos de notificaciones no leídas
- Filtros por estado y tipo

### 8. **Calendario Financiero**
- Visualización de eventos financieros
- Colores por tipo (Ingresos 🟢, Gastos 🔴, Transferencias 🔵)
- Vistas: Mes, Semana, Día
- Detalles al hacer clic

### 9. **Reportes y Estadísticas**
- Gráficos con Chart.js (Pie, Line, Bar)
- Tendencias mensuales
- Distribución por categoría
- Tabla de movimientos detallados

### 10. **Exportación de Datos**
- Exportar a Excel (.xlsx)
- Exportar a PDF (.pdf)
- Exportar a CSV (.csv)
- Filtros por período y tipo

### 11. **Integraciones API**
- Webhooks configurables
- Claves API (Producción y Desarrollo)
- Eventos disponibles (ingreso.creado, gasto.aprobado, etc)
- Documentación de endpoints

---

## 📋 Base de Datos

### Tablas Creadas (5)
1. **ingresos** - Registro de ingresos financieros
2. **gastos** - Registro de gastos con aprobación
3. **membresias** - Pagos de membresías por usuario
4. **presupuestos_categorias** - Presupuestos mensuales por categoría
5. **auditoria_movimientos** - Auditoría de cambios en movimientos

### Almacenados (60 Stored Procedures)
- Reportes consolidados
- Cálculos de saldos
- Búsquedas avanzadas
- Validaciones de integridad

### Vistas SQL (6)
- Vista de ingresos con cálculos
- Vista de gastos aprobados
- Vista de membresías vencidas
- Vista de presupuestos
- Vista de movimientos consolidados
- Vista de estadísticas

### Triggers (1)
- **trg_actualizar_nombre_usuario** - Actualiza referencias de usuarios

---

## 🛣️ Rutas y Endpoints (57 Total)

### Páginas Principales (4)
```
GET    /tesorero                          # Dashboard (inicio)
GET    /tesorero/dashboard                # Dashboard general
GET    /tesorero/calendario               # Calendario financiero
GET    /tesorero/finanzas                 # Alias del dashboard
```

### API Endpoints
```
GET    /tesorero/api/calendario/eventos   # Eventos para FullCalendar (JSON)
GET    /tesorero/notificaciones/verificar # Verificar actualizaciones (polling)
```

### CRUD Ingresos (7)
```
GET    /tesorero/ingresos                 # Listar
GET    /tesorero/ingresos/crear           # Formulario crear
POST   /tesorero/ingresos                 # Guardar
GET    /tesorero/ingresos/{id}            # Ver detalle
GET    /tesorero/ingresos/{id}/editar     # Formulario editar
PUT    /tesorero/ingresos/{id}            # Actualizar
DELETE /tesorero/ingresos/{id}            # Eliminar
```

### CRUD Gastos (9)
```
GET    /tesorero/gastos                   # Listar
GET    /tesorero/gastos/crear             # Formulario crear
POST   /tesorero/gastos                   # Guardar
GET    /tesorero/gastos/{id}              # Ver detalle
GET    /tesorero/gastos/{id}/editar       # Formulario editar
PUT    /tesorero/gastos/{id}              # Actualizar
DELETE /tesorero/gastos/{id}              # Eliminar
POST   /tesorero/gastos/{id}/aprobar      # Aprobar gasto
POST   /tesorero/gastos/{id}/rechazar     # Rechazar gasto
```

### CRUD Transferencias (7)
```
GET    /tesorero/transferencias           # Listar
GET    /tesorero/transferencias/crear     # Formulario crear
POST   /tesorero/transferencias           # Guardar
GET    /tesorero/transferencias/{id}      # Ver detalle
GET    /tesorero/transferencias/{id}/editar # Formulario editar
PUT    /tesorero/transferencias/{id}      # Actualizar
DELETE /tesorero/transferencias/{id}      # Eliminar
```

### CRUD Membresías (7)
```
GET    /tesorero/membresias               # Listar
GET    /tesorero/membresias/crear         # Formulario crear
POST   /tesorero/membresias               # Guardar
GET    /tesorero/membresias/{id}          # Ver detalle
GET    /tesorero/membresias/{id}/editar   # Formulario editar
PUT    /tesorero/membresias/{id}          # Actualizar
DELETE /tesorero/membresias/{id}          # Eliminar
```

### CRUD Presupuestos (12)
```
GET    /tesorero/presupuestos             # Listar
GET    /tesorero/presupuestos/crear       # Formulario crear
POST   /tesorero/presupuestos             # Guardar
GET    /tesorero/presupuestos/{id}        # Ver detalle
GET    /tesorero/presupuestos/{id}/editar # Formulario editar
PUT    /tesorero/presupuestos/{id}        # Actualizar
DELETE /tesorero/presupuestos/{id}        # Eliminar
POST   /tesorero/presupuestos/{id}/duplicar # Duplicar presupuesto
GET    /tesorero/presupuestos/{id}/exportar-excel # Descargar Excel
GET    /tesorero/presupuestos/{id}/exportar-pdf   # Descargar PDF
GET    /tesorero/presupuestos/{id}/seguimiento    # Seguimiento
```

### Movimientos y Reportes (4)
```
GET    /tesorero/movimientos              # Registro de movimientos
GET    /tesorero/movimientos/{id}/detalle # Detalle de movimiento
GET    /tesorero/reportes                 # Reportes básicos
POST   /tesorero/reportes/generar         # Generar reporte
```

### Notificaciones (4)
```
GET    /tesorero/notificaciones           # Centro de notificaciones
GET    /tesorero/notificaciones/verificar # Verificar actualizaciones
POST   /tesorero/notificaciones/{id}/marcar-leida   # Marcar leído
POST   /tesorero/notificaciones/marcar-todas-leidas # Marcar todos leídos
```

### Extras (3)
```
GET    /tesorero/reportes/estadisticas    # Reportes con gráficos
GET    /tesorero/exportar                 # Exportar datos
GET    /tesorero/integraciones            # Configurar integraciones API
```

---

## 🎨 Vistas Blade (.blade.php)

### Vistas Principales
- `welcome.blade.php` - Página de inicio (DEPRECATED - ahora apunta a index)
- `calendario.blade.php` - Calendario FullCalendar
- `notificaciones.blade.php` - Centro de notificaciones
- `finanza.blade.php` - Dashboard general

### Vistas CRUD
```
ingresos/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  └── show.blade.php

gastos/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  └── show.blade.php

membresias/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  └── show.blade.php

presupuestos/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  ├── show.blade.php
  └── seguimiento.blade.php

transferencias/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  └── show.blade.php
```

### Vistas Adicionales
- `reportes_estadisticas.blade.php` - Gráficos y estadísticas
- `exportar_datos.blade.php` - Formulario de exportación
- `integraciones_api.blade.php` - Configuración de webhooks y API

---

## 🔧 Configuración y Uso

### Instalación
```bash
# Las migraciones ya están ejecutadas
php artisan migrate

# Limpiar caché
php artisan optimize:clear
```

### Acceso al Módulo
- **URL**: `/tesorero`
- **Roles Permitidos**: Tesorero, Presidente, Super Admin
- **Middleware**: `auth`, `check.first.login`, RoleMiddleware

### Permisos Requeridos
El sistema utiliza **Spatie/Laravel-Permission** para gestionar roles:
```php
- Tesorero: Acceso completo al módulo
- Presidente: Acceso completo + aprobaciones
- Super Admin: Acceso completo + auditoría
```

---

## 📊 Funcionalidades Especiales

### Notificaciones en Tiempo Real
- **Polling cada 30 segundos** al `endpoint /tesorero/notificaciones/verificar`
- **Retorna JSON** con:
  - `nuevas_notificaciones` - Conteo de nuevas
  - `notificaciones_no_leidas` - Pendientes de leer
  - `gastos_pendientes` - Gastos sin aprobar
  - `membresias_proximas_vencer` - Próximas a vencer
  - `timestamp` - Marca de tiempo

### Gráficos (Chart.js 4.4.0)
- **Gráfico Pie/Doughnut**: Ingresos vs Gastos
- **Gráfico Line**: Tendencia mensual
- **Gráfico Bar**: Distribución por categoría

### Calendario (FullCalendar 6.1.10)
- **Colores**:
  - 🟢 Verde (#28a745) - Ingresos
  - 🔴 Rojo (#dc3545) - Gastos
  - 🔵 Azul (#007bff) - Transferencias
- **Vistas**: dayGridMonth, timeGridWeek, timeGridDay
- **Interactividad**: Clic para ver detalles

---

## 🔐 Seguridad

### Auditoría
- Tabla `auditoria_movimientos` registra:
  - Qué tabla fue modificada
  - Qué registro se modificó
  - Qué acción se realizó (CREATE, UPDATE, DELETE)
  - Quién realizó la acción (usuario_id)
  - Datos anteriores vs nuevos (JSON)
  - IP y User Agent

### Validaciones
- Validación de tipos de dato en modelos
- Casting automático de fechas y decimales
- Relaciones Eloquent validadas

### Roles y Permisos
- Middleware RoleMiddleware para control de acceso
- Rutas protegidas por autenticación
- Verificación de primer login

---

## 📈 Próximas Mejoras Sugeridas

1. **Integración con Banco API** - Sincronizar movimientos
2. **Reportes Automáticos** - Envío vía email
3. **Análisis Predictivo** - Proyecciones de presupuesto
4. **Auditoría Avanzada** - Dashboard de cambios
5. **Multimoneda** - Soporte para otras monedas
6. **Facturación** - Generación automática de facturas

---

## 🆘 Solución de Problemas

### Error: "View [modulos.tesorero.ingresos.index] not found"
**Solución**: Verificar que el archivo existe en `resources/views/modulos/tesorero/ingresos/index.blade.php`

### Polling no funciona
**Solución**: Verificar que `route('tesorero.notificaciones.verificar')` retorna JSON válido

### Gráficos no se muestran
**Solución**: Verificar que Chart.js está cargado y que los datos JSON son válidos

---

## 📞 Soporte

Para reportar bugs o sugerencias, contactar al administrador del sistema.

**Versión**: 1.0  
**Última actualización**: Noviembre 9, 2025  
**Autor**: Sistema Rotaract Web
