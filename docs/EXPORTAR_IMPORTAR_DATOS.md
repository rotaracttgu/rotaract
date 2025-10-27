# 📦 Exportar/Importar Datos del Módulo Vicepresidente

Este archivo contiene los comandos para compartir datos entre miembros del equipo.

---

## 📤 EXPORTAR DATOS (Quien tiene los datos)

### Opción 1: Exportar SOLO las tablas del módulo Vicepresidente
```bash
C:\xampp\mysql\bin\mysqldump.exe -u root -p gestiones_clubrotario carta_patrocinios carta_formals reunions asistencias_reunions participacion_proyectos > datos_vicepresidente.sql
```
*Nota: Te pedirá la contraseña de forma segura*

### Opción 2: Exportar TODO (base de datos completa)
```bash
C:\xampp\mysql\bin\mysqldump.exe -u root -p gestiones_clubrotario > backup_completo.sql
```
*Nota: Te pedirá la contraseña de forma segura*

### Opción 3: Exportar con estructura Y datos
```bash
C:\xampp\mysql\bin\mysqldump.exe -u root -p --complete-insert gestiones_clubrotario carta_patrocinios carta_formals reunions asistencias_reunions participacion_proyectos proyectos > vicepresidente_con_proyectos.sql
```
*Nota: Te pedirá la contraseña de forma segura*

---

## 📥 IMPORTAR DATOS (Quien recibe los datos)

### Paso 1: Asegúrate de tener las tablas creadas
```bash
php artisan migrate
```

### Paso 2: Importar el archivo SQL
```bash
# Si usaste Opción 1 o 3
C:\xampp\mysql\bin\mysql.exe -u root -p gestiones_clubrotario < datos_vicepresidente.sql

# Si usaste Opción 2 (backup completo)
C:\xampp\mysql\bin\mysql.exe -u root -p gestiones_clubrotario < backup_completo.sql
```
*Nota: Te pedirá la contraseña de forma segura*

### Paso 3: Verificar que se importaron correctamente
```bash
php artisan tinker
>>> \App\Models\CartaPatrocinio::count()
>>> \App\Models\Reunion::count()
>>> \App\Models\Proyecto::count()
```

---

## 🎯 ALTERNATIVA: Usar el Seeder (Recomendado para desarrollo)

Si solo necesitas datos de prueba para trabajar:

```bash
php artisan db:seed --class=VicepresidenteModuloSeeder
```

**Ventajas:**
- ✅ Rápido y automático
- ✅ Crea datos consistentes para todos
- ✅ No requiere archivos SQL
- ✅ Fácil de resetear: `php artisan migrate:fresh --seed`

**Datos que crea:**
- 3 Cartas de Patrocinio
- 4 Cartas Formales
- 4 Reuniones
- Asistencias de ejemplo
- Participaciones en proyectos

---

## 🔄 Compartir Datos con el Equipo

### Para Git (NO RECOMENDADO para archivos .sql grandes):
```bash
git add datos_vicepresidente.sql
git commit -m "Datos de prueba del módulo Vicepresidente"
git push origin Dev
```

### Para compartir por otro medio:
1. **Google Drive** - Subir el .sql
2. **Email** - Si es pequeño
3. **Discord/Slack** - Adjuntar archivo
4. **GitHub Gist** - Para archivos SQL pequeños

---

## ⚠️ IMPORTANTE

- **NO subir a Git** archivos SQL con datos sensibles (usuarios reales, contraseñas)
- **NO ejecutar `migrate:fresh`** sin backup - borra TODO
- **Asegurarse** que todos usen la misma versión del código antes de importar

---

## 🛠️ Comandos Útiles

### Ver las tablas y sus datos:
```bash
php artisan tinker
>>> DB::table('carta_patrocinios')->count()
>>> DB::table('carta_formals')->count()
>>> DB::table('reunions')->count()
>>> DB::table('asistencias_reunions')->count()
>>> DB::table('participacion_proyectos')->count()
```

### Limpiar todas las tablas del módulo:
```bash
php artisan tinker
>>> DB::table('participacion_proyectos')->truncate()
>>> DB::table('asistencias_reunions')->truncate()
>>> DB::table('carta_patrocinios')->truncate()
>>> DB::table('carta_formals')->truncate()
>>> DB::table('reunions')->truncate()
```

### Volver a poblar después de limpiar:
```bash
php artisan db:seed --class=VicepresidenteModuloSeeder
```

---

**Nota de Seguridad:** 
- Nunca incluyas contraseñas en los comandos (usa `-p` sin contraseña)
- MySQL te pedirá la contraseña de forma segura
- No compartas archivos SQL con contraseñas o datos sensibles en Git
