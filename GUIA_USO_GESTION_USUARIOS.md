# 📖 GUÍA DE USO - GESTIÓN DE USUARIOS
## Módulos Presidente y Vicepresidente

**Fecha:** 5 de Noviembre, 2025  
**Versión:** 1.0.0

---

## 🎯 ACCESO AL MÓDULO

### Presidente
1. Inicia sesión con tu usuario de **Presidente**
2. Serás redirigido al Dashboard del Presidente
3. En el menú lateral izquierdo, haz clic en **"Gestión de Usuarios"** 
4. Accederás a: `/presidente/usuarios`

### Vicepresidente
1. Inicia sesión con tu usuario de **Vicepresidente**
2. Serás redirigido al Dashboard del Vicepresidente
3. En el menú lateral izquierdo, haz clic en **"Gestión de Usuarios"**
4. Accederás a: `/vicepresidente/usuarios`

---

## 📋 LISTA DE USUARIOS

### Vista Principal
Al acceder al módulo verás:
- **Contador total de usuarios** en la esquina superior derecha
- **Botón "Nuevo Usuario"** para crear usuarios
- **Tabla con todos los usuarios** mostrando:
  - Nombre completo
  - Email
  - Rol (con badge de color)
  - Estado (Activo/Bloqueado)
  - Fecha de creación
  - Acciones disponibles

### Acciones Disponibles:
1. 👁️ **Ver** - Ver detalles completos del usuario
2. ✏️ **Editar** - Modificar información del usuario
3. 🗑️ **Eliminar** - Eliminar usuario (con confirmación)

### Paginación:
- Se muestran **10 usuarios por página**
- Navegación con botones Anterior/Siguiente
- Indicador de página actual

---

## ➕ CREAR NUEVO USUARIO

### Paso a Paso:

1. **Haz clic en "Nuevo Usuario"**
   - Botón rosa/morado en la parte superior derecha

2. **Completa el formulario:**
   
   **Información Básica:**
   - ✅ **Nombre completo** (requerido)
   - ✅ **Email** (requerido, debe ser único)
   - ✅ **Contraseña** (requerido, mínimo 8 caracteres)
   - ✅ **Confirmar contraseña** (debe coincidir)
   
   **Rol del Usuario:**
   - Selecciona el rol apropiado:
     - Super Admin
     - Presidente
     - Vicepresidente
     - Vocero
     - Secretario
     - Tesorero
     - Aspirante

   **Opciones de Verificación:**
   - ☑️ **Email verificado** (opcional)
     - Marca si quieres que el email esté verificado desde el inicio
     - Si no se marca, el usuario deberá verificar su email
   
   - ☑️ **2FA verificado** (opcional)
     - Marca si quieres omitir la verificación de dos factores
     - Por defecto, todos los usuarios tienen 2FA habilitado

3. **Haz clic en "Crear Usuario"**

### Resultado:
- ✅ Usuario creado exitosamente
- ✅ Registro en bitácora del sistema
- ✅ Mensaje de confirmación
- ✅ Redirección a la lista de usuarios

### Notas Importantes:
- 📧 El usuario recibirá las credenciales por email (si está configurado)
- 🔐 El usuario deberá cambiar su contraseña en el primer inicio de sesión
- 📱 Si 2FA no está verificado, deberá configurarlo al iniciar sesión

---

## 👁️ VER DETALLES DE USUARIO

### Información Mostrada:

1. **Datos Personales:**
   - Nombre completo
   - Email
   - Nombre de usuario (username)
   - DNI/Cédula
   - Teléfono
   - Rotary ID (si tiene)

2. **Información de Cuenta:**
   - Rol asignado
   - Estado de la cuenta (Activo/Bloqueado)
   - Fecha de creación
   - Última actualización

3. **Seguridad:**
   - Email verificado: ✅ / ❌
   - 2FA habilitado: ✅ / ❌
   - 2FA verificado: ✅ / ❌
   - Primer inicio de sesión: ✅ / ❌

4. **Preguntas de Seguridad:**
   - Pregunta 1 configurada
   - Pregunta 2 configurada
   - Pregunta 3 configurada

### Acciones Disponibles:
- ✏️ **Editar Usuario** - Modificar información
- 🗑️ **Eliminar Usuario** - Eliminar cuenta
- ⬅️ **Volver** - Regresar a la lista

---

## ✏️ EDITAR USUARIO

### Campos Editables:

1. **Información Personal:**
   - Nombre completo
   - Email
   - Nombre de usuario
   - DNI/Cédula
   - Teléfono
   - Apellidos
   - Rotary ID

2. **Rol:**
   - Cambiar rol del usuario
   - Dropdown con todos los roles disponibles

3. **Contraseña (opcional):**
   - Nueva contraseña
   - Confirmar nueva contraseña
   - ⚠️ Solo completa si quieres cambiar la contraseña

4. **Verificaciones:**
   - ☑️ Email verificado
   - ☑️ 2FA verificado

### Proceso:

1. **Haz clic en "Editar"** en la lista de usuarios
2. **Modifica los campos** que desees actualizar
3. **Haz clic en "Actualizar Usuario"**

### Resultado:
- ✅ Usuario actualizado exitosamente
- ✅ Registro en bitácora con cambios realizados
- ✅ Mensaje de confirmación
- ✅ Redirección a la lista de usuarios

### Importante:
- 📝 Los cambios se registran en la bitácora del sistema
- 🔐 Si cambias la contraseña, el usuario deberá usar la nueva
- 👤 Si cambias el rol, los permisos se actualizan inmediatamente

---

## 🗑️ ELIMINAR USUARIO

### Proceso:

1. **Haz clic en el botón rojo "Eliminar"**
2. **Confirma la acción** en el diálogo que aparece
3. **El usuario será eliminado**

### ⚠️ ADVERTENCIA:
- Esta acción es **PERMANENTE**
- Se eliminarán todos los datos del usuario
- No se puede deshacer
- El registro queda en la bitácora del sistema

### Consideraciones:
- ❌ No se puede eliminar el propio usuario (el que está logueado)
- ❌ No se puede eliminar a Super Admins (protección)
- ✅ Se registra quién eliminó al usuario y cuándo

---

## 🔍 BÚSQUEDA Y FILTROS

### Funciones Disponibles:

1. **Búsqueda por Nombre o Email:**
   - Campo de búsqueda en la parte superior
   - Busca en tiempo real mientras escribes

2. **Filtrar por Rol:**
   - Botones de filtro rápido
   - Muestra solo usuarios de un rol específico

3. **Ordenar:**
   - Por fecha de creación (más recientes primero)
   - Por nombre alfabéticamente
   - Por rol

---

## 🔐 PERMISOS Y RESTRICCIONES

### ✅ Pueden Hacer:
- Ver lista de todos los usuarios
- Ver detalles de cualquier usuario
- Crear nuevos usuarios
- Editar cualquier usuario (excepto Super Admins)
- Eliminar usuarios (excepto Super Admins y ellos mismos)
- Asignar roles (excepto Super Admin)

### ❌ No Pueden Hacer:
- Eliminar Super Admins
- Eliminarse a sí mismos
- Crear Super Admins (solo Super Admin puede)
- Ver contraseñas de otros usuarios

---

## 📊 ROLES DISPONIBLES

### Jerarquía de Roles:

1. **Super Admin** 🔴
   - Acceso total al sistema
   - Gestión de todos los módulos
   - Configuración del sistema

2. **Presidente** 🟣
   - Gestión de usuarios
   - Calendario
   - Cartas formales y patrocinio
   - Estado de proyectos
   - Notificaciones

3. **Vicepresidente** 🔵
   - Gestión de usuarios
   - Calendario
   - Cartas formales y patrocinio
   - Estado de proyectos
   - Notificaciones

4. **Vocero** 🟢
   - Calendario completo
   - Eventos
   - Asistencias
   - Reportes

5. **Secretario** 🟡
   - Actas
   - Documentos
   - Proyectos
   - Consultas

6. **Tesorero** 🟠
   - Finanzas
   - Reportes económicos

7. **Aspirante** ⚪
   - Acceso limitado
   - Vista de información básica

---

## 💡 TIPS Y BUENAS PRÁCTICAS

### Al Crear Usuarios:
1. ✅ Usa emails corporativos o institucionales
2. ✅ Asigna el rol correcto desde el inicio
3. ✅ Verifica que el email sea correcto
4. ✅ Usa contraseñas seguras (mínimo 8 caracteres)
5. ✅ Activa la verificación de email si el usuario es de confianza

### Al Editar Usuarios:
1. ✅ Verifica los cambios antes de guardar
2. ✅ No cambies el rol sin consultar con el equipo
3. ✅ Si cambias la contraseña, notifica al usuario
4. ✅ Revisa el historial en la bitácora

### Al Eliminar Usuarios:
1. ⚠️ Asegúrate de que realmente quieres eliminar
2. ⚠️ Verifica que no haya información importante
3. ⚠️ Considera desactivar en lugar de eliminar
4. ⚠️ Consulta con el equipo si es un usuario activo

### Seguridad:
1. 🔒 No compartas credenciales de usuarios
2. 🔒 Cambia contraseñas regularmente
3. 🔒 Revisa usuarios inactivos periódicamente
4. 🔒 Mantén actualizada la información de contacto

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### "No puedo crear un usuario"
**Posibles causas:**
- El email ya está en uso → Verifica que sea único
- Contraseña muy débil → Usa mínimo 8 caracteres
- Las contraseñas no coinciden → Verifica ambos campos
- Faltan campos requeridos → Completa todos los campos marcados con *

### "No puedo editar un usuario"
**Posibles causas:**
- El usuario es Super Admin → Solo Super Admin puede editarlos
- No tienes permisos → Verifica tu rol
- El email ya existe → Usa otro email

### "No puedo eliminar un usuario"
**Posibles causas:**
- Es un Super Admin → No se pueden eliminar
- Estás intentando eliminarte a ti mismo → No permitido
- No tienes permisos → Verifica tu rol

### "El usuario no puede iniciar sesión"
**Verifica:**
- ✅ La contraseña es correcta
- ✅ El email está verificado (si es requerido)
- ✅ 2FA está configurado (si es requerido)
- ✅ La cuenta no está bloqueada
- ✅ El usuario existe en el sistema

---

## 📞 SOPORTE

Si encuentras problemas no listados aquí:

1. **Revisa la bitácora del sistema**
   - Menú lateral → Bitácora
   - Busca errores recientes

2. **Contacta al administrador del sistema**
   - Proporciona detalles del error
   - Indica qué estabas haciendo
   - Incluye capturas de pantalla si es posible

3. **Consulta la documentación técnica**
   - `IMPLEMENTACION_COMPLETA_FINAL.md`
   - `RESUMEN_COMPLETO_PASOS_1-5.md`

---

## 🎉 ¡TODO LISTO!

Ahora puedes gestionar usuarios desde tu módulo de Presidente o Vicepresidente con total confianza.

**Recuerda:**
- Cada acción queda registrada en la bitácora
- Los cambios son inmediatos
- Usa los permisos de forma responsable

---

**Documentación creada:** 5 de Noviembre, 2025  
**Versión:** 1.0.0  
**Sistema:** Rotaract - Gestión de Usuarios

