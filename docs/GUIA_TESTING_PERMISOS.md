# 🧪 Guía de Testing - Sistema Dinámico de Permisos

## 📋 Fecha de Implementación
**Fecha:** 19 de Noviembre, 2025  
**Módulos:** Presidente y Vicepresidente  
**Rama:** Dev

---

## 🎯 Objetivo del Testing

Verificar que el sistema de permisos granulares funciona correctamente:
- Los botones aparecen/desaparecen según permisos asignados
- Las rutas están protegidas en el controlador
- Los roles existentes mantienen su funcionalidad

---

## 🚀 PASO 1: Preparación del Entorno

### 1.1 Iniciar Servicios
```powershell
# Iniciar XAMPP (Apache + MySQL)
# Abrir XAMPP Control Panel y hacer clic en "Start" para MySQL y Apache
```

### 1.2 Ejecutar Migraciones y Seeders
```powershell
cd "c:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract"

# Ejecutar seeder de permisos
php artisan db:seed --class=PermissionsSeeder

# Limpiar caché de permisos
php artisan permission:cache-reset
php artisan optimize:clear
php artisan config:clear
```

### 1.3 Verificar Permisos Creados
```sql
-- Conectar a MySQL y ejecutar:
USE gestiones_clubrotario;

-- Ver todos los permisos
SELECT * FROM permissions ORDER BY name;

-- Ver permisos de comunicaciones
SELECT * FROM permissions WHERE name LIKE 'comunicaciones.%';

-- Ver permisos de proyectos
SELECT * FROM permissions WHERE name LIKE 'proyectos.%';
```

---

## 🧪 PASO 2: Testing con Roles Existentes

### 2.1 Testing como Super Admin
**Expectativa:** Debe ver TODO (todos los botones y funcionalidades)

1. Iniciar sesión como Super Admin
2. Ir a: **Presidente → Cartas de Patrocinio**
   - ✅ Debe aparecer botón "Nueva Carta de Patrocinio"
   - ✅ En tabla: botones Ver, Editar, Eliminar, Descargar PDF
3. Ir a: **Presidente → Cartas Formales**
   - ✅ Debe aparecer botón "Nueva Carta Formal"
   - ✅ En tabla: botones Ver, Editar, Eliminar, Descargar PDF
4. Ir a: **Presidente → Estado de Proyectos**
   - ✅ Debe aparecer botón "Nuevo Proyecto"
   - ✅ En tarjetas: botones Ver detalles, Editar, Eliminar

### 2.2 Testing como Presidente
**Expectativa:** Debe ver TODO en sus módulos

1. Iniciar sesión como Presidente
2. Repetir las mismas pruebas del Super Admin
3. Todo debe funcionar igual

### 2.3 Testing como Vicepresidente
**Expectativa:** Debe ver TODO en sus módulos

1. Iniciar sesión como Vicepresidente
2. Ir a sus módulos (Vicepresidente → Cartas, Proyectos)
3. Debe tener todos los botones igual que Presidente

---

## 🎭 PASO 3: Testing con Rol Personalizado

### 3.1 Crear Rol de Prueba "Editor de Proyectos"

```sql
-- Opción A: SQL directo
INSERT INTO roles (name, guard_name, created_at, updated_at) 
VALUES ('Editor Proyectos', 'web', NOW(), NOW());

-- Obtener el ID del rol creado
SELECT id FROM roles WHERE name = 'Editor Proyectos';
```

**Opción B: Usar la interfaz Admin**
1. Admin → Configuración → Roles
2. Crear nuevo rol: "Editor Proyectos"

### 3.2 Asignar Permisos Selectivos

**Caso de Prueba 1: Solo Ver**
```sql
-- Asignar solo permiso de VER proyectos
-- Reemplazar {role_id} con el ID del rol creado
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, {role_id} FROM permissions WHERE name = 'proyectos.ver';
```

**O desde la interfaz:**
1. Admin → Roles → "Editor Proyectos" → Asignar Permisos
2. Seleccionar solo: `proyectos.ver`

### 3.3 Crear Usuario de Prueba

```sql
-- Crear usuario de prueba
INSERT INTO users (name, email, email_verified_at, password, created_at, updated_at)
VALUES ('Test Editor', 'test.editor@rotaract.com', NOW(), '$2y$12$HASH...', NOW(), NOW());

-- Obtener ID del usuario
SELECT id FROM users WHERE email = 'test.editor@rotaract.com';

-- Asignar rol al usuario (reemplazar {user_id} y {role_id})
INSERT INTO model_has_roles (role_id, model_type, model_id)
VALUES ({role_id}, 'App\\Models\\User', {user_id});
```

**O crear desde la interfaz Admin:**
1. Admin → Usuarios → Crear Usuario
2. Email: test.editor@rotaract.com
3. Asignar rol: "Editor Proyectos"

---

## ✅ PASO 4: Casos de Prueba Específicos

### Caso 1: Solo Ver Proyectos
**Permisos:** `proyectos.ver`

**Resultado Esperado:**
- ❌ Botón "Nuevo Proyecto" NO aparece
- ✅ Botón "Ver detalles" SÍ aparece
- ❌ Botón "Editar" NO aparece
- ❌ Botón "Eliminar" NO aparece

**Cómo Probar:**
1. Iniciar sesión como "Test Editor"
2. Ir a: Presidente → Estado de Proyectos
3. Verificar que solo aparece "Ver detalles"
4. Intentar acceder a URL directa (debe dar error 403):
   ```
   http://localhost:8000/presidente/proyectos/1/editar
   ```

### Caso 2: Ver y Crear Proyectos
**Permisos:** `proyectos.ver`, `proyectos.crear`

**Resultado Esperado:**
- ✅ Botón "Nuevo Proyecto" SÍ aparece
- ✅ Botón "Ver detalles" SÍ aparece
- ❌ Botón "Editar" NO aparece
- ❌ Botón "Eliminar" NO aparece

**Asignar Permisos:**
```sql
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, {role_id} FROM permissions WHERE name IN ('proyectos.ver', 'proyectos.crear');
```

### Caso 3: Ver, Editar, Eliminar (Sin Crear)
**Permisos:** `proyectos.ver`, `proyectos.editar`, `proyectos.eliminar`

**Resultado Esperado:**
- ❌ Botón "Nuevo Proyecto" NO aparece
- ✅ Botón "Ver detalles" SÍ aparece
- ✅ Botón "Editar" SÍ aparece
- ✅ Botón "Eliminar" SÍ aparece

**Asignar Permisos:**
```sql
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, {role_id} FROM permissions 
WHERE name IN ('proyectos.ver', 'proyectos.editar', 'proyectos.eliminar');
```

### Caso 4: Cartas Formales - Solo Ver y Crear
**Permisos:** `comunicaciones.ver`, `comunicaciones.crear`

**Resultado Esperado:**
- ✅ Botón "Nueva Carta Formal" SÍ aparece
- ✅ Botón "Ver carta" SÍ aparece
- ❌ Botón "Editar" NO aparece
- ❌ Botón "Eliminar" NO aparece

**Asignar Permisos:**
```sql
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, {role_id} FROM permissions 
WHERE name IN ('comunicaciones.ver', 'comunicaciones.crear');
```

---

## 🔒 PASO 5: Testing de Seguridad

### 5.1 Intentar Acceso Sin Permiso

**Probar con usuario que NO tiene `proyectos.editar`:**
1. Iniciar sesión con usuario de prueba
2. Copiar URL de un proyecto: `/presidente/proyectos/1`
3. Cambiar a URL de edición: `/presidente/proyectos/1/editar`
4. Presionar Enter

**Resultado Esperado:**
- ❌ Error 403 Forbidden
- ✅ Mensaje: "This action is unauthorized."

### 5.2 Intentar Eliminar Sin Permiso

**Usando Postman o cURL:**
```powershell
# Intentar eliminar proyecto sin permiso
curl -X DELETE http://localhost:8000/presidente/proyectos/1 `
  -H "X-CSRF-TOKEN: {token}" `
  -H "Cookie: laravel_session={session}"
```

**Resultado Esperado:**
- ❌ HTTP 403 Forbidden

---

## 📊 PASO 6: Verificación de Datos

### 6.1 Verificar Permisos de un Usuario
```sql
-- Ver permisos de un usuario específico
SELECT p.name, p.guard_name
FROM permissions p
INNER JOIN role_has_permissions rhp ON p.id = rhp.permission_id
INNER JOIN model_has_roles mhr ON rhp.role_id = mhr.role_id
WHERE mhr.model_id = {user_id} AND mhr.model_type = 'App\\Models\\User';
```

### 6.2 Verificar Roles de un Usuario
```sql
-- Ver roles de un usuario
SELECT r.name
FROM roles r
INNER JOIN model_has_roles mhr ON r.id = mhr.role_id
WHERE mhr.model_id = {user_id} AND mhr.model_type = 'App\\Models\\User';
```

---

## 🐛 PASO 7: Testing de Errores Comunes

### Error 1: Botones no aparecen/desaparecen
**Solución:**
```powershell
php artisan permission:cache-reset
php artisan optimize:clear
# Cerrar sesión y volver a iniciar
```

### Error 2: Cambios en permisos no se reflejan
**Solución:**
```powershell
# Limpiar toda la caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan permission:cache-reset
```

### Error 3: Error 403 en todas las rutas
**Verificar:**
```sql
-- Verificar que el usuario tiene el rol asignado
SELECT * FROM model_has_roles WHERE model_id = {user_id};

-- Verificar que el rol tiene permisos
SELECT * FROM role_has_permissions WHERE role_id = {role_id};
```

---

## ✅ CHECKLIST DE TESTING

### Módulo Presidente - Cartas de Patrocinio
- [ ] Botón "Nueva Carta" aparece con permiso `proyectos.crear`
- [ ] Botón "Ver" aparece con permiso `proyectos.ver`
- [ ] Botón "Editar" aparece con permiso `proyectos.editar`
- [ ] Botón "Eliminar" aparece con permiso `proyectos.eliminar`
- [ ] Sin permisos, error 403 al intentar acceder

### Módulo Presidente - Cartas Formales
- [ ] Botón "Nueva Carta" aparece con permiso `comunicaciones.crear`
- [ ] Botón "Ver" aparece con permiso `comunicaciones.ver`
- [ ] Botón "Editar" aparece con permiso `comunicaciones.editar`
- [ ] Botón "Eliminar" aparece con permiso `comunicaciones.eliminar`
- [ ] Sin permisos, error 403 al intentar acceder

### Módulo Presidente - Estado de Proyectos
- [ ] Botón "Nuevo Proyecto" aparece con permiso `proyectos.crear`
- [ ] Botón "Ver detalles" aparece con permiso `proyectos.ver`
- [ ] Botón "Editar" aparece con permiso `proyectos.editar`
- [ ] Botón "Eliminar" aparece con permiso `proyectos.eliminar`
- [ ] Vista de tabla también respeta permisos

### Módulo Vicepresidente
- [ ] Todas las funcionalidades iguales a Presidente
- [ ] Mismos permisos aplican
- [ ] Rutas protegidas correctamente

### Roles Predefinidos
- [ ] Super Admin: Acceso total a todo
- [ ] Presidente: Todos los permisos de su módulo
- [ ] Vicepresidente: Todos los permisos de su módulo
- [ ] Roles no pierden funcionalidad existente

---

## 📝 REPORTE DE BUGS

Si encuentras algún problema, documenta:

```
**Bug ID:** [Número]
**Módulo:** [Presidente/Vicepresidente]
**Vista:** [Nombre de la vista]
**Permiso Probado:** [Nombre del permiso]
**Comportamiento Esperado:** [Descripción]
**Comportamiento Actual:** [Descripción]
**Pasos para Reproducir:**
1. ...
2. ...
3. ...
**Navegador:** [Chrome/Firefox/Edge]
**Captura de Pantalla:** [Adjuntar]
```

---

## 🎉 CONCLUSIÓN

Una vez completado el testing, deberías tener:
- ✅ Sistema de permisos funcionando al 100%
- ✅ Botones aparecen/desaparecen dinámicamente
- ✅ Rutas protegidas contra acceso no autorizado
- ✅ Roles personalizables desde el panel Admin
- ✅ Compatibilidad mantenida con roles existentes

---

**Próximos Módulos a Implementar:**
1. Tesorero
2. Secretaria
3. Vocero
4. Socio/Aspirante

---

**Documentación creada el:** 19 de Noviembre, 2025  
**Desarrollador:** GitHub Copilot + Claude Sonnet 4.5  
**Proyecto:** Sistema Rotaract - Gestión de Club
