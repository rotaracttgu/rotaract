# 📚 Documentación del Proyecto - Club Rotaract

Bienvenido a la documentación del Sistema de Gestión del Club Rotaract.

---

## 📋 Índice de Documentación

### 🚀 Instalación y Configuración

- **[INSTALACION_MODULO_VICEPRESIDENTE.md](./INSTALACION_MODULO_VICEPRESIDENTE.md)**
  - Guía completa de instalación del módulo Vicepresidente
  - Requisitos previos
  - Pasos de instalación
  - Solución de problemas
  - Verificación de instalación

### 📖 Documentación de Módulos

- **[MODULO_VICEPRESIDENTE_README.md](./MODULO_VICEPRESIDENTE_README.md)**
  - Documentación completa del módulo Vicepresidente
  - Estructura de archivos y código
  - Rutas y controladores
  - Modelos y base de datos
  - Funcionalidades principales
  - Testing y verificación

### 🎨 Diseño y Animaciones

- **[MEJORAS_ANIMACIONES.md](./MEJORAS_ANIMACIONES.md)** ⭐ _NUEVO_
  - Documentación completa de mejoras de diseño y animaciones
  - Biblioteca de animaciones CSS
  - Modales rediseñados (Cartas de Patrocinio y Formales)
  - Sistema de colores y gradientes
  - Loading states y UX mejorada
  - Modal de confirmación personalizado

- **[TESTING_GUIDE.md](./TESTING_GUIDE.md)** ⭐ _NUEVO_
  - Guía completa de testing para animaciones
  - Checklists de verificación paso a paso
  - Pruebas de funcionalidad, diseño y UX
  - Testing responsive
  - Solución de problemas comunes

- **[VERIFICACION_FINAL.md](./VERIFICACION_FINAL.md)** ⭐ _NUEVO_
  - Checklist de verificación completo
  - Problemas encontrados y solucionados
  - Acciones necesarias antes de testing
  - Resumen del estado de implementación

### 🔄 Importación/Exportación de Datos

- **[EXPORTAR_IMPORTAR_DATOS.md](./EXPORTAR_IMPORTAR_DATOS.md)**
  - Comandos para exportar datos entre entornos
  - Guía de importación de bases de datos
  - Uso del seeder para datos de prueba
  - Mejores prácticas de seguridad

---

## 🏗️ Estructura del Proyecto

```
rotaract/
├── app/                    # Lógica de la aplicación
│   ├── Http/Controllers/   # Controladores
│   ├── Models/             # Modelos Eloquent
│   └── ...
├── database/
│   ├── migrations/         # Migraciones de BD
│   └── seeders/            # Seeders
├── resources/
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php             # Rutas web
└── docs/                   # 📚 Esta carpeta
    ├── README.md           # Este archivo
    ├── MODULO_VICEPRESIDENTE_README.md
    ├── INSTALACION_MODULO_VICEPRESIDENTE.md
    └── EXPORTAR_IMPORTAR_DATOS.md
```

---

## 🚀 Inicio Rápido

### 1. Instalación Inicial
```bash
# Clonar repositorio
git clone https://github.com/rotaracttgu/rotaract.git
cd rotaract

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Poblar con datos de prueba (opcional)
php artisan db:seed
```

### 2. Levantar el servidor
```bash
php artisan serve
```

Visita: `http://127.0.0.1:8000`

---

## 👥 Módulos Disponibles

### 🎯 Módulo Vicepresidente
- Gestión de cartas de patrocinio
- Gestión de cartas formales
- Consulta de estado de proyectos
- Control de asistencia a reuniones
- Gestión de participación en proyectos

**Acceso:** Roles Vicepresidente, Presidente o Super Admin

📖 [Ver documentación completa](./MODULO_VICEPRESIDENTE_README.md)

---

## 🔐 Roles del Sistema

| Rol | Descripción | Acceso |
|-----|-------------|--------|
| **Super Admin** | Acceso total al sistema | Todas las funcionalidades |
| **Presidente** | Gestión general del club | Todos los módulos |
| **Vicepresidente** | Gestión de proyectos y comunicaciones | Módulo Vicepresidente |
| **Secretario** | Gestión de documentación | Módulo Secretaría |
| **Tesorero** | Gestión financiera | Módulo Tesorería |
| **Vocero** | Comunicaciones externas | Módulo Vocería |
| **Aspirante** | Acceso limitado | Dashboard básico |

---

## 🗄️ Base de Datos

### Tablas Principales

- `users` - Usuarios del sistema
- `roles` - Roles y permisos
- `proyectos` - Proyectos del club
- `miembros` - Información de miembros
- `carta_patrocinios` - Cartas de patrocinio
- `carta_formals` - Cartas formales
- `reunions` - Reuniones programadas
- `asistencias_reunions` - Control de asistencias
- `participacion_proyectos` - Participación en proyectos

📖 [Ver estructura completa de BD](./MODULO_VICEPRESIDENTE_README.md#-tablas-de-base-de-datos)

---

## 🛠️ Desarrollo

### Comandos Útiles

```bash
# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Ver rutas
php artisan route:list

# Ver estado de migraciones
php artisan migrate:status

# Crear nueva migración
php artisan make:migration create_nombre_table

# Crear nuevo modelo
php artisan make:model NombreModelo -m

# Crear nuevo controlador
php artisan make:controller NombreController
```

---

## 📝 Convenciones de Código

- **Modelos:** PascalCase singular (ej: `User`, `Proyecto`)
- **Controladores:** PascalCase + `Controller` (ej: `UserController`)
- **Rutas:** kebab-case (ej: `vicepresidente/cartas-patrocinio`)
- **Vistas:** kebab-case (ej: `cartas-patrocinio.blade.php`)
- **Migraciones:** snake_case (ej: `create_users_table`)

---

## 🐛 Solución de Problemas

### Error: "Class not found"
```bash
composer dump-autoload
php artisan cache:clear
```

### Error de Base de Datos
```bash
php artisan migrate:fresh  # ⚠️ Cuidado: borra todos los datos
php artisan db:seed
```

### Vistas no se actualizan
```bash
php artisan view:clear
# Recargar navegador con Ctrl+F5
```

---

## 📞 Soporte

Para dudas o problemas:
1. Revisar esta documentación
2. Consultar logs: `storage/logs/laravel.log`
3. Verificar configuración: `.env`
4. Contactar al equipo de desarrollo

---

## 📅 Historial de Versiones

- **v1.0.0** (Octubre 2025) - Versión inicial
  - Sistema de autenticación
  - Módulo Vicepresidente
  - Sistema de roles y permisos
  - Base de datos completa (41 tablas)

---

**Desarrollado para:** Club Rotaract Tegucigalpa Sur  
**Repositorio:** https://github.com/rotaracttgu/rotaract  
**Rama:** Dev  
**Última actualización:** Octubre 18, 2025
