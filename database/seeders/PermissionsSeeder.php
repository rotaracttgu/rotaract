<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir módulos y sus acciones
        $modules = [
            // Módulo de Usuarios
            'usuarios' => [
                'ver' => 'Ver lista de usuarios',
                'crear' => 'Crear nuevos usuarios',
                'editar' => 'Editar usuarios existentes',
                'eliminar' => 'Eliminar usuarios',
                'bloquear' => 'Bloquear/desbloquear usuarios',
            ],

            // Módulo de Roles
            'roles' => [
                'ver' => 'Ver lista de roles',
                'crear' => 'Crear nuevos roles',
                'editar' => 'Editar roles existentes',
                'eliminar' => 'Eliminar roles',
            ],

            // Módulo de Permisos
            'permisos' => [
                'ver' => 'Ver lista de permisos',
                'crear' => 'Crear nuevos permisos',
                'editar' => 'Editar permisos existentes',
                'eliminar' => 'Eliminar permisos',
            ],

            // Módulo de Miembros
            'miembros' => [
                'ver' => 'Ver lista de miembros',
                'crear' => 'Crear nuevos miembros',
                'editar' => 'Editar información de miembros',
                'eliminar' => 'Eliminar miembros',
                'exportar' => 'Exportar listado de miembros',
            ],

            // Módulo de Proyectos
            'proyectos' => [
                'ver' => 'Ver lista de proyectos',
                'crear' => 'Crear nuevos proyectos',
                'editar' => 'Editar proyectos existentes',
                'eliminar' => 'Eliminar proyectos',
                'aprobar' => 'Aprobar proyectos',
            ],

            // Módulo de Finanzas
            'finanzas' => [
                'ver' => 'Ver información financiera',
                'crear' => 'Registrar movimientos',
                'editar' => 'Editar movimientos',
                'eliminar' => 'Eliminar movimientos',
                'aprobar' => 'Aprobar transacciones',
                'exportar' => 'Exportar reportes financieros',
            ],

            // Módulo de Eventos
            'eventos' => [
                'ver' => 'Ver calendario de eventos',
                'crear' => 'Crear nuevos eventos',
                'editar' => 'Editar eventos existentes',
                'eliminar' => 'Eliminar eventos',
                'publicar' => 'Publicar eventos',
            ],

            // Módulo de Asistencias
            'asistencias' => [
                'ver' => 'Ver registro de asistencias',
                'registrar' => 'Registrar asistencias',
                'editar' => 'Editar asistencias',
                'eliminar' => 'Eliminar asistencias',
                'exportar' => 'Exportar reportes de asistencias',
            ],

            // Módulo de Actas
            'actas' => [
                'ver' => 'Ver actas',
                'crear' => 'Crear nuevas actas',
                'editar' => 'Editar actas existentes',
                'eliminar' => 'Eliminar actas',
                'aprobar' => 'Aprobar actas',
                'exportar' => 'Exportar actas en PDF',
            ],

            // Módulo de Diplomas
            'diplomas' => [
                'ver' => 'Ver diplomas',
                'crear' => 'Crear nuevos diplomas',
                'editar' => 'Editar diplomas existentes',
                'eliminar' => 'Eliminar diplomas',
                'enviar' => 'Enviar diplomas por email',
                'exportar' => 'Exportar diplomas en PDF',
            ],

            // Módulo de Documentos
            'documentos' => [
                'ver' => 'Ver documentos',
                'crear' => 'Crear nuevos documentos',
                'editar' => 'Editar documentos existentes',
                'eliminar' => 'Eliminar documentos',
            ],

            // Módulo de Comunicaciones
            'comunicaciones' => [
                'ver' => 'Ver comunicaciones',
                'crear' => 'Crear comunicaciones',
                'enviar' => 'Enviar comunicaciones',
                'editar' => 'Editar comunicaciones',
                'eliminar' => 'Eliminar comunicaciones',
            ],

            // Módulo de Reportes
            'reportes' => [
                'ver' => 'Ver reportes',
                'exportar' => 'Exportar reportes',
                'generar' => 'Generar reportes personalizados',
            ],

            // Módulo de Configuración
            'configuracion' => [
                'ver' => 'Ver configuración',
                'editar' => 'Modificar configuración del sistema',
            ],

            // Módulo de Backup
            'backup' => [
                'ver' => 'Ver lista de backups',
                'crear' => 'Crear respaldo',
                'restaurar' => 'Restaurar backup',
                'eliminar' => 'Eliminar backups',
                'descargar' => 'Descargar backups',
            ],

            // Módulo de Cartas (Formales y Patrocinio)
            'cartas' => [
                'ver' => 'Ver cartas formales y de patrocinio',
                'crear' => 'Crear nuevas cartas',
                'editar' => 'Editar cartas existentes',
                'eliminar' => 'Eliminar cartas',
                'aprobar' => 'Aprobar cartas',
                'exportar' => 'Exportar cartas en PDF/Word',
            ],

            // Módulo de Bitácora
            'bitacora' => [
                'ver' => 'Ver bitácora del sistema',
                'exportar' => 'Exportar registros de bitácora',
            ],

            // Dashboard
            'dashboard' => [
                'ver' => 'Ver dashboard',
                'estadisticas' => 'Ver estadísticas completas',
            ],
        ];

        // Crear permisos
        $createdPermissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action => $description) {
                $permissionName = "$module.$action";
                
                // Crear o actualizar el permiso
                $permission = Permission::firstOrCreate(
                    ['name' => $permissionName],
                    ['guard_name' => 'web']
                );

                $createdPermissions[] = $permissionName;
                $this->command->info("✓ Permiso creado: $permissionName");
            }
        }

        // Asignar TODOS los permisos al Super Admin
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
            $this->command->info("✓ Todos los permisos asignados a Super Admin");
        }

        // Asignar permisos específicos a cada rol
        $this->assignRolePermissions();

        $this->command->info("✓ Total de permisos creados: " . count($createdPermissions));
    }

    /**
     * Asignar permisos específicos a cada rol
     */
    private function assignRolePermissions()
    {
        // PRESIDENTE - Acceso amplio a casi todo
        $presidente = Role::where('name', 'Presidente')->first();
        if ($presidente) {
            $presidente->syncPermissions([
                // Usuarios - TODOS los permisos (Solo Presidente puede delegar)
                'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
                // Miembros
                'miembros.ver', 'miembros.crear', 'miembros.editar', 'miembros.exportar',
                // Proyectos - TODOS los permisos
                'proyectos.ver', 'proyectos.crear', 'proyectos.editar', 'proyectos.eliminar', 'proyectos.aprobar',
                // Finanzas
                'finanzas.ver', 'finanzas.aprobar', 'finanzas.exportar',
                // Eventos - TODOS los permisos
                'eventos.ver', 'eventos.crear', 'eventos.editar', 'eventos.eliminar', 'eventos.publicar',
                // Asistencias - TODOS los permisos
                'asistencias.ver', 'asistencias.registrar', 'asistencias.editar', 'asistencias.eliminar', 'asistencias.exportar',
                // Actas
                'actas.ver', 'actas.crear', 'actas.editar', 'actas.aprobar', 'actas.exportar',
                // Cartas - TODOS los permisos
                'cartas.ver', 'cartas.crear', 'cartas.editar', 'cartas.eliminar', 'cartas.aprobar', 'cartas.exportar',
                // Comunicaciones - TODOS los permisos
                'comunicaciones.ver', 'comunicaciones.crear', 'comunicaciones.enviar', 'comunicaciones.editar', 'comunicaciones.eliminar',
                // Reportes
                'reportes.ver', 'reportes.exportar', 'reportes.generar',
                // Dashboard
                'dashboard.ver', 'dashboard.estadisticas',
                // Bitácora
                'bitacora.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Presidente");
        }

        // VICEPRESIDENTE - Similar al presidente pero sin aprobaciones finales
        $vicepresidente = Role::where('name', 'Vicepresidente')->first();
        if ($vicepresidente) {
            $vicepresidente->syncPermissions([
                // Usuarios - Solo ver y editar
                'usuarios.ver', 'usuarios.editar',
                'miembros.ver', 'miembros.crear', 'miembros.editar',
                // Proyectos - Todos excepto aprobar
                'proyectos.ver', 'proyectos.crear', 'proyectos.editar', 'proyectos.eliminar',
                'finanzas.ver', 'finanzas.exportar',
                'eventos.ver', 'eventos.crear', 'eventos.editar',
                'asistencias.ver', 'asistencias.exportar',
                'actas.ver', 'actas.crear', 'actas.editar',
                // Cartas - TODOS los permisos excepto aprobar
                'cartas.ver', 'cartas.crear', 'cartas.editar', 'cartas.eliminar', 'cartas.exportar',
                // Comunicaciones - TODOS los permisos
                'comunicaciones.ver', 'comunicaciones.crear', 'comunicaciones.enviar', 'comunicaciones.editar', 'comunicaciones.eliminar',
                'reportes.ver', 'reportes.exportar',
                'dashboard.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Vicepresidente");
        }

        // TESORERO - Enfoque en finanzas
        $tesorero = Role::where('name', 'Tesorero')->first();
        if ($tesorero) {
            $tesorero->syncPermissions([
                'miembros.ver',
                'proyectos.ver',
                'finanzas.ver', 'finanzas.crear', 'finanzas.editar', 'finanzas.exportar',
                'eventos.ver',
                'reportes.ver', 'reportes.exportar',
                'dashboard.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Tesorero");
        }

        // SECRETARIO - Enfoque en actas y documentación
        $secretario = Role::where('name', 'Secretario')->first();
        if ($secretario) {
            $secretario->syncPermissions([
                'miembros.ver',
                'eventos.ver',
                'asistencias.ver', 'asistencias.registrar', 'asistencias.editar', 'asistencias.eliminar',
                'actas.ver', 'actas.crear', 'actas.editar', 'actas.eliminar', 'actas.exportar',
                'diplomas.ver', 'diplomas.crear', 'diplomas.editar', 'diplomas.eliminar', 'diplomas.enviar', 'diplomas.exportar',
                'documentos.ver', 'documentos.crear', 'documentos.editar', 'documentos.eliminar',
                'comunicaciones.ver', 'comunicaciones.enviar',
                'reportes.ver', 'reportes.exportar',
                'dashboard.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Secretario");
        }

        // VOCERO - Enfoque en eventos y comunicaciones
        $vocero = Role::where('name', 'Vocero')->first();
        if ($vocero) {
            $vocero->syncPermissions([
                'miembros.ver',
                'proyectos.ver',
                'eventos.ver', 'eventos.crear', 'eventos.editar', 'eventos.eliminar', 'eventos.publicar',
                'asistencias.ver', 'asistencias.registrar', 'asistencias.editar', 'asistencias.eliminar',
                'comunicaciones.ver', 'comunicaciones.enviar', 'comunicaciones.editar',
                'reportes.ver', 'reportes.exportar', 'reportes.generar',
                'dashboard.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Vocero");
        }

        // ASPIRANTE - Permisos limitados, solo visualización
        $aspirante = Role::where('name', 'Aspirante')->first();
        if ($aspirante) {
            $aspirante->syncPermissions([
                'miembros.ver',
                'proyectos.ver',
                'eventos.ver',
                'dashboard.ver',
            ]);
            $this->command->info("✓ Permisos asignados a Aspirante");
        }
    }
}