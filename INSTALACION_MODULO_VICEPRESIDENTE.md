# 🚀 Instalación del Módulo Vicepresidente

## 📋 Requisitos Previos
- PHP 8.2+
- MySQL/MariaDB
- Composer instalado
- Laravel 11.x

---

## 🔧 Pasos de Instalación

### 1️⃣ Clonar/Actualizar el repositorio
```bash
git pull origin Dev
```

### 2️⃣ Instalar dependencias de Composer
```bash
composer install
```

### 3️⃣ Configurar archivo .env
Asegúrate de que tu archivo `.env` tenga la configuración correcta de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestiones_clubrotario
DB_USERNAME=root
DB_PASSWORD=TU_CONTRASEÑA
```

### 4️⃣ Ejecutar las migraciones
Este comando creará las 5 nuevas tablas del módulo Vicepresidente:
```bash
php artisan migrate
```

**Tablas que se crean:**
- ✅ `carta_patrocinios` - Gestión de cartas de patrocinio
- ✅ `carta_formals` - Gestión de cartas formales
- ✅ `reunions` - Programación de reuniones
- ✅ `asistencias_reunions` - Control de asistencia a reuniones
- ✅ `participacion_proyectos` - Participación de miembros en proyectos

**Nota:** La tabla `proyectos` debe existir previamente en tu base de datos.

### 5️⃣ Poblar con datos de prueba (OPCIONAL)
Para tener datos de ejemplo y probar el módulo:
```bash
php artisan db:seed --class=VicepresidenteModuloSeeder
```

**Datos que se crean:**
- 3 Cartas de Patrocinio
- 4 Cartas Formales
- 4 Reuniones programadas
- Registros de asistencia
- Participación en proyectos

### 6️⃣ Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 7️⃣ Levantar el servidor
```bash
php artisan serve
```

Visita: `http://127.0.0.1:8000/vicepresidente/dashboard`

---

## 👤 Acceso al Módulo

### Requisitos de Usuario:
- ✅ Usuario autenticado
- ✅ Rol: **Vicepresidente** o **Super Admin**

### Rutas disponibles:
- `/vicepresidente/dashboard` - Dashboard principal
- `/vicepresidente/cartas/patrocinio` - Gestión de cartas de patrocinio
- `/vicepresidente/cartas/formales` - Gestión de cartas formales
- `/vicepresidente/estado/proyectos` - Estado de proyectos (solo lectura)
- `/vicepresidente/asistencia/reuniones` - Control de asistencia a reuniones
- `/vicepresidente/asistencia/proyectos` - Participación en proyectos

---

## 🐛 Solución de Problemas

### Error: "Class VicepresidenteModuloSeeder not found"
```bash
composer dump-autoload
php artisan db:seed --class=VicepresidenteModuloSeeder
```

### Error: "SQLSTATE[42S02]: Base table or view not found: 'proyectos'"
La tabla `proyectos` debe existir previamente. Si no existe, contacta al administrador del sistema.

### Error: "Target class [VicepresidenteController] does not exist"
```bash
composer dump-autoload
php artisan cache:clear
```

### Las vistas no se muestran correctamente
```bash
php artisan view:clear
# Recargar el navegador con Ctrl+F5
```

---

## 📊 Estructura del Módulo

```
app/
├── Http/Controllers/
│   └── VicepresidenteController.php
├── Models/
│   ├── AsistenciaReunion.php
│   ├── CartaFormal.php
│   ├── CartaPatrocinio.php
│   ├── ParticipacionProyecto.php
│   ├── Proyecto.php
│   └── Reunion.php

database/
├── migrations/
│   ├── 2025_10_17_020000_create_carta_patrocinios_table.php
│   ├── 2025_10_17_020001_create_carta_formals_table.php
│   ├── 2025_10_17_020002_create_reunions_table.php
│   ├── 2025_10_17_020003_create_asistencias_reunions_table.php
│   └── 2025_10_17_020004_create_participacion_proyectos_table.php
└── seeders/
    └── VicepresidenteModuloSeeder.php

resources/views/modulos/vicepresidente/
├── layout.blade.php (Layout con sidebar)
├── dashboard.blade.php
├── cartas-patrocinio.blade.php
├── cartas-formales.blade.php
├── estado-proyectos.blade.php
├── asistencia-reuniones.blade.php
└── asistencia-proyectos.blade.php

routes/
└── web.php (Rutas del módulo Vicepresidente)
```

---

## 📝 Notas Importantes

1. **NO ejecutar `php artisan migrate:fresh`** - Esto borrará TODOS los datos de la base de datos.
2. El módulo usa **Chart.js** para las gráficas (cargado vía CDN, no requiere instalación).
3. El sidebar está integrado en el layout personalizado `modulos/vicepresidente/layout.blade.php`.
4. Todas las vistas usan TailwindCSS para estilos.

---

## ✅ Verificación de Instalación

Para verificar que todo está correcto:

```bash
# Ver el estado de las migraciones
php artisan migrate:status

# Ver las rutas del módulo
php artisan route:list --path=vicepresidente

# Verificar los modelos
php artisan tinker
>>> App\Models\Proyecto::count()
>>> App\Models\CartaPatrocinio::count()
>>> App\Models\Reunion::count()
```

---

## 🆘 Soporte

Si tienes problemas con la instalación, verifica:
1. Los logs de Laravel: `storage/logs/laravel.log`
2. Los errores del servidor web
3. La configuración de `.env`
4. Que tu usuario tenga el rol de Vicepresidente

---

**Desarrollado por:** Carlos  
**Fecha:** Octubre 2025  
**Rama:** Dev
