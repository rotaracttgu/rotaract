# Tablas del Módulo de Secretaría

## 📊 Resumen de Base de Datos

La base de datos `gestiones_clubrotario` contiene **46 tablas** en total.

---

## 🔧 Tablas Creadas para el Módulo de Secretaría

### 1. **consultas**
**Propósito:** Gestionar consultas individuales de usuarios  
**Campos principales:**
- `id` - Identificador único
- `usuario_id` - Usuario que hace la consulta (FK a users)
- `asunto` - Asunto de la consulta
- `mensaje` - Mensaje de la consulta
- `estado` - Estado: pendiente, respondida, cerrada
- `respuesta` - Respuesta a la consulta
- `respondido_por` - Usuario que respondió (FK a users)
- `respondido_at` - Fecha de respuesta
- `prioridad` - Prioridad: baja, media, alta

**Relaciones:**
- Pertenece a `users` (quien consulta)
- Pertenece a `users` (quien responde)

---

### 2. **actas**
**Propósito:** Gestionar actas de reuniones  
**Campos principales:**
- `id` - Identificador único
- `titulo` - Título del acta
- `fecha_reunion` - Fecha de la reunión
- `tipo_reunion` - Tipo: ordinaria, extraordinaria, junta, asamblea
- `contenido` - Contenido del acta
- `asistentes` - Lista de asistentes
- `archivo_path` - Ruta del archivo adjunto (PDF/DOC)
- `creado_por` - Usuario que creó el acta (FK a users)

**Relaciones:**
- Pertenece a `users` (creador)

---

### 3. **diplomas**
**Propósito:** Gestionar diplomas y reconocimientos  
**Campos principales:**
- `id` - Identificador único
- `miembro_id` - Miembro que recibe el diploma (FK a users)
- `tipo` - Tipo: participacion, reconocimiento, merito, asistencia
- `motivo` - Motivo del diploma
- `fecha_emision` - Fecha de emisión
- `archivo_path` - Ruta del archivo del diploma (PDF)
- `emitido_por` - Usuario que emitió el diploma (FK a users)
- `enviado_email` - Si se envió por email (boolean)
- `fecha_envio_email` - Fecha de envío por email

**Relaciones:**
- Pertenece a `users` (receptor)
- Pertenece a `users` (emisor)
- Tiene uno a través de `miembros` (detalles del miembro)

---

### 4. **documentos**
**Propósito:** Gestionar documentos oficiales  
**Campos principales:**
- `id` - Identificador único
- `titulo` - Título del documento
- `tipo` - Tipo: oficial, interno, comunicado, carta, informe, otro
- `descripcion` - Descripción del documento
- `archivo_path` - Ruta del archivo
- `archivo_nombre` - Nombre original del archivo
- `categoria` - Categoría del documento
- `creado_por` - Usuario que creó el documento (FK a users)

**Relaciones:**
- Pertenece a `users` (creador)

---

## 🔗 Tablas Existentes Utilizadas

### 5. **mensajes_consultas** *(Tabla existente)*
**Propósito:** Sistema de mensajería entre miembros y secretaría/vocería  
**Campos principales:**
- `MensajeID` - Identificador único
- `MiembroID` - Miembro que envía (FK a miembros)
- `DestinatarioTipo` - Tipo: secretaria, voceria, directiva, otro
- `DestinatarioID` - ID del destinatario
- `TipoConsulta` - Tipo de consulta
- `Asunto` - Asunto del mensaje
- `Mensaje` - Contenido del mensaje
- `Prioridad` - Prioridad: baja, media, alta, urgente
- `Estado` - Estado: pendiente, en_proceso, respondida, cerrada
- `FechaEnvio` - Fecha de envío
- `FechaRespuesta` - Fecha de respuesta
- `RespuestaMensaje` - Respuesta al mensaje
- `RespondidoPor` - Quién respondió (FK a miembros)

**Uso en Dashboard:** Conteo de mensajes pendientes dirigidos a secretaría

---

### 6. **miembros** *(Tabla existente)*
**Propósito:** Información detallada de los miembros del club  
**Campos principales:**
- `MiembroID` - Identificador único
- `user_id` - Relación con users (FK a users)
- `DNI_Pasaporte` - Documento de identidad
- `Nombre` - Nombre completo
- `Rol` - Rol del miembro
- `Correo` - Correo electrónico
- `FechaIngreso` - Fecha de ingreso al club
- `Apuntes` - Notas sobre el miembro

**Uso en Dashboard:** Conteo de miembros activos

---

### 7. **reunions** *(Tabla existente)*
**Propósito:** Registro de reuniones programadas  
**Uso en Dashboard:** Mostrar reuniones recientes

---

### 8. **asistencias_reunions** *(Tabla existente)*
**Propósito:** Registro de asistencia a reuniones  
**Uso potencial:** Control de asistencia para diplomas

---

## 📁 Estructura de Almacenamiento de Archivos

Los archivos se almacenan en:
- **Actas:** `storage/app/public/actas/`
- **Diplomas:** `storage/app/public/diplomas/`
- **Documentos:** `storage/app/public/documentos/`

**Enlace simbólico creado:** `public/storage` → `storage/app/public`

---

## 🎯 Rutas del Módulo de Secretaría

### Dashboard
- `GET /secretaria/dashboard` - Panel principal

### Consultas
- `GET /secretaria/consultas` - Lista de consultas
- `GET /secretaria/consultas/{id}` - Ver una consulta
- `POST /secretaria/consultas/{id}/responder` - Responder consulta
- `DELETE /secretaria/consultas/{id}` - Eliminar consulta

### Actas
- `GET /secretaria/actas` - Lista de actas
- `GET /secretaria/actas/{id}` - Ver un acta
- `POST /secretaria/actas` - Crear acta
- `POST /secretaria/actas/{id}` - Actualizar acta
- `DELETE /secretaria/actas/{id}` - Eliminar acta

### Diplomas
- `GET /secretaria/diplomas` - Lista de diplomas
- `GET /secretaria/diplomas/{id}` - Ver un diploma
- `POST /secretaria/diplomas` - Crear diploma
- `POST /secretaria/diplomas/{id}` - Actualizar diploma
- `DELETE /secretaria/diplomas/{id}` - Eliminar diploma
- `POST /secretaria/diplomas/{id}/enviar-email` - Enviar por email

### Documentos
- `GET /secretaria/documentos` - Lista de documentos
- `GET /secretaria/documentos/{id}` - Ver un documento
- `POST /secretaria/documentos` - Crear documento
- `POST /secretaria/documentos/{id}` - Actualizar documento
- `DELETE /secretaria/documentos/{id}` - Eliminar documento

---

## 🔐 Permisos y Roles

**Roles con acceso al módulo:**
- Secretario
- Presidente
- Super Admin

**Middleware aplicado:**
- `auth` - Usuario autenticado
- `check.first.login` - Verificación de primer login
- `RoleMiddleware` - Control de roles

---

## 📈 Métricas del Dashboard

El dashboard muestra:

1. **Consultas Pendientes** - De la tabla `consultas`
2. **Mensajes Pendientes** - De la tabla `mensajes_consultas` (solo para secretaría)
3. **Actas Recientes** - Últimas 5 actas creadas
4. **Diplomas Emitidos** - Total de diplomas
5. **Documentos Total** - Total de documentos
6. **Miembros Activos** - Total de miembros
7. **Reuniones Recientes** - Últimas 5 reuniones

---

## 🚀 Próximas Mejoras Sugeridas

1. **Integración de Calendario** - Usar la tabla `calendarios` existente
2. **Sistema de Notificaciones** - Notificar nuevas consultas
3. **Reportes** - Usar tablas `reportes` y `historialreportes`
4. **Chat en Tiempo Real** - Usar `conversaciones_chat`
5. **Gestión de Proyectos** - Integrar con tabla `proyectos`
6. **Control de Asistencias** - Integrar con `asistencias` y `asistencias_reunions`

---

## 📝 Notas Importantes

- ✅ Las 4 tablas nuevas (consultas, actas, diplomas, documentos) están creadas y funcionando
- ✅ Se respetan todas las tablas existentes sin modificarlas
- ✅ El sistema usa tanto tablas nuevas como existentes de manera complementaria
- ✅ Los modelos Laravel están configurados con sus relaciones
- ✅ El controlador está optimizado para usar ambos conjuntos de tablas

---

**Fecha de creación:** 27 de Octubre de 2025  
**Versión:** 1.0
