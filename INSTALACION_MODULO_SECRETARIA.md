# 🚀 Instrucciones de Instalación - Módulo de Secretaría

## Paso 1: Ejecutar el Seeder

Para poblar la base de datos con datos de ejemplo del módulo de secretaría, ejecuta:

```bash
php artisan db:seed --class=SecretariaModuloSeeder
```

## Paso 2: Verificar las Tablas

El seeder creará datos en las siguientes tablas:
- `consultas` - 3 registros
- `actas` - 2 registros
- `diplomas` - 3 registros
- `documentos` - 4 registros

## Paso 3: Acceder al Dashboard

1. Inicia sesión con un usuario que tenga el rol de **Secretario**, **Presidente** o **Super Admin**

2. Navega a: `http://tu-dominio/secretaria/dashboard`

## Verificación

Deberías ver:

✅ **Header mejorado** con gradientes de colores  
✅ **4 tarjetas de estadísticas** con los contadores actualizados  
✅ **Accesos rápidos** a cada módulo  
✅ **Consultas recientes** en la columna izquierda  
✅ **Documentos recientes** en la columna izquierda  
✅ **Actas recientes** en la columna derecha  
✅ **Diplomas recientes** en la columna derecha  
✅ **Botón de cerrar sesión** en el header  

## Características Visuales Implementadas

### 🎨 Paleta de Colores
- **Violeta** (#9B01F3 → #631B47): Consultas
- **Turquesa** (#74B6C0 → #00ADDB): Actas
- **Naranja** (#FF7D00 → #C0A656): Diplomas
- **Verde** (#009759 → #C1C100): Documentos
- **Azul Polvo** (#B8D4DA): Elementos secundarios

### ✨ Efectos Visuales
- Gradientes suaves en todas las tarjetas
- Animaciones hover con escala y elevación
- Sombras dinámicas
- Transiciones fluidas con cubic-bezier
- Bordes superiores con gradientes de colores

### 📊 Componentes Mejorados
- Header con gradiente multicolor
- Títulos con degradado de color
- Tarjetas con efectos 3D al pasar el mouse
- Badges con gradientes y sombras
- Timeline con puntos de color animados
- Dropdown mejorado con animaciones

## Troubleshooting

### Si no ves los datos:

1. **Verifica que las tablas existan:**
   ```bash
   php artisan migrate
   ```

2. **Limpia la caché:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

3. **Verifica los permisos del usuario:**
   - El usuario debe tener rol: Secretario, Presidente o Super Admin

### Si los estilos no se aplican:

1. **Recompila los assets:**
   ```bash
   npm run dev
   ```

2. **Refresca el navegador con Ctrl+F5** (hard refresh)

3. **Verifica que el archivo blade esté en la ruta correcta:**
   `resources/views/modulos/secretaria/dashboard.blade.php`

## Personalización Adicional

### Cambiar Colores

Edita las variables CSS al inicio del archivo `dashboard.blade.php`:

```css
:root {
    /* Turquoise */
    --color-turquoise-from: #74B6C0;
    --color-turquoise-to: #00ADDB;
    
    /* Cambia estos valores según tu preferencia */
}
```

### Modificar Estadísticas

Edita el método `dashboard()` en `SecretariaController.php`:

```php
$estadisticas = [
    'consultas_pendientes' => Consulta::where('estado', 'pendiente')->count(),
    // Agrega más estadísticas aquí
];
```

## Próximos Pasos

1. ✅ Dashboard mejorado con paleta de colores moderna
2. ✅ Seeder con datos de ejemplo
3. ✅ Documentación completa
4. 📝 Implementar vistas de Consultas, Actas, Diplomas y Documentos
5. 📝 Agregar funcionalidad de búsqueda y filtros
6. 📝 Implementar exportación a PDF
7. 📝 Agregar notificaciones en tiempo real

## Soporte

Si encuentras algún problema, verifica:
1. Logs de Laravel: `storage/logs/laravel.log`
2. Consola del navegador (F12)
3. Variables de entorno (.env)

---

**¡Disfruta del nuevo dashboard de Secretaría!** 🎉
