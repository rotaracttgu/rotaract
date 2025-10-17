<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;
use App\Models\Reunion;
use App\Models\AsistenciaReunion;
use App\Models\ParticipacionProyecto;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatosCompletosSeeder extends Seeder
{
    /**
     * Seed de datos completos del sistema
     * Incluye: usuarios, roles, proyectos, cartas, reuniones, etc.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ============================================
        // 1. ROLES Y PERMISOS
        // ============================================
        $roles = [
            'Super Admin',
            'Presidente', 
            'Vicepresidente',
            'Secretario',
            'Tesorero',
            'Vocero',
            'Aspirante'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );
        }

        // ============================================
        // 2. USUARIOS
        // ============================================
        
        // Usuario Super Admin - Rodrigo
        $rodrigo = User::firstOrCreate(
            ['email' => 'rodrigopaleom7@gmail.com'],
            [
                'name' => 'Rodrigo',
                'apellidos' => 'Paleo',
                'username' => 'rodrigo',
                'dni' => '12345678',
                'telefono' => '999999999',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'profile_completed_at' => now(),
                'two_factor_enabled' => true,
                'two_factor_verified_at' => now(),
                'first_login' => false,
            ]
        );
        $rodrigo->assignRole('Super Admin');

        // Usuario Vocero - Axel
        $axel = User::firstOrCreate(
            ['email' => 'yovani16cabrera20@gmail.com'],
            [
                'name' => 'Axel',
                'apellidos' => 'Cabrera',
                'username' => 'axel',
                'dni' => '87654321',
                'telefono' => '988888888',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'profile_completed_at' => now(),
                'two_factor_enabled' => true,
                'two_factor_verified_at' => now(),
                'first_login' => false,
            ]
        );
        $axel->assignRole('Vocero');

        // Usuario Vicepresidente - Carlos
        $carlos = User::firstOrCreate(
            ['email' => 'carlos@rotaract.com'],
            [
                'name' => 'Carlos',
                'apellidos' => 'Vicepresidente',
                'username' => 'carlos',
                'dni' => '11223344',
                'telefono' => '977777777',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'profile_completed_at' => now(),
                'two_factor_enabled' => false,
                'first_login' => false,
            ]
        );
        $carlos->assignRole('Vicepresidente');

        // Usuarios adicionales para pruebas
        $maria = User::firstOrCreate(
            ['email' => 'maria@rotaract.com'],
            [
                'name' => 'María',
                'apellidos' => 'González',
                'username' => 'maria',
                'dni' => '22334455',
                'telefono' => '966666666',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'profile_completed_at' => now(),
                'first_login' => false,
            ]
        );
        $maria->assignRole('Secretario');

        $juan = User::firstOrCreate(
            ['email' => 'juan@rotaract.com'],
            [
                'name' => 'Juan',
                'apellidos' => 'Pérez',
                'username' => 'juan',
                'dni' => '33445566',
                'telefono' => '955555555',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'profile_completed_at' => now(),
                'first_login' => false,
            ]
        );
        $juan->assignRole('Tesorero');

        // ============================================
        // 3. PROYECTOS
        // ============================================
        
        $proyectos = [
            [
                'Nombre' => 'Reforestación Comunitaria',
                'Descripcion' => 'Proyecto de reforestación en zonas urbanas de la ciudad',
                'FechaInicio' => '2025-01-15',
                'FechaFin' => null,
                'Estatus' => 'Activo',
                'EstadoProyecto' => 'En Progreso',
                'Presupuesto' => 15000.00,
                'TipoProyecto' => 'Ambiental',
                'ResponsableID' => $carlos->id,
            ],
            [
                'Nombre' => 'Campaña de Salud',
                'Descripcion' => 'Jornada de salud preventiva en comunidades rurales',
                'FechaInicio' => '2025-02-01',
                'FechaFin' => null,
                'Estatus' => 'Activo',
                'EstadoProyecto' => 'En Progreso',
                'Presupuesto' => 20000.00,
                'TipoProyecto' => 'Salud',
                'ResponsableID' => $maria->id,
            ],
            [
                'Nombre' => 'Educación Digital',
                'Descripcion' => 'Talleres de alfabetización digital para adultos mayores',
                'FechaInicio' => '2024-11-01',
                'FechaFin' => '2025-01-31',
                'Estatus' => 'Completado',
                'EstadoProyecto' => 'Finalizado',
                'Presupuesto' => 8000.00,
                'TipoProyecto' => 'Educación',
                'ResponsableID' => $juan->id,
            ],
            [
                'Nombre' => 'Limpieza de Playas',
                'Descripcion' => 'Jornada de limpieza en playas locales',
                'FechaInicio' => '2025-03-15',
                'FechaFin' => null,
                'Estatus' => 'Planificado',
                'EstadoProyecto' => 'Por Iniciar',
                'Presupuesto' => 5000.00,
                'TipoProyecto' => 'Ambiental',
                'ResponsableID' => $axel->id,
            ],
            [
                'Nombre' => 'Donación de Libros',
                'Descripcion' => 'Recolección y donación de libros a escuelas rurales',
                'FechaInicio' => '2025-01-01',
                'FechaFin' => null,
                'Estatus' => 'Activo',
                'EstadoProyecto' => 'En Progreso',
                'Presupuesto' => 3000.00,
                'TipoProyecto' => 'Educación',
                'ResponsableID' => $carlos->id,
            ],
            [
                'Nombre' => 'Maratón Solidaria',
                'Descripcion' => 'Evento deportivo para recaudar fondos',
                'FechaInicio' => '2024-12-01',
                'FechaFin' => '2024-12-15',
                'Estatus' => 'Completado',
                'EstadoProyecto' => 'Finalizado',
                'Presupuesto' => 12000.00,
                'TipoProyecto' => 'Recaudación',
                'ResponsableID' => $rodrigo->id,
            ],
        ];

        foreach ($proyectos as $proyectoData) {
            Proyecto::firstOrCreate(
                ['Nombre' => $proyectoData['Nombre']],
                $proyectoData
            );
        }

        // ============================================
        // 4. CARTAS DE PATROCINIO
        // ============================================
        
        $proyecto1 = Proyecto::where('Nombre', 'Reforestación Comunitaria')->first();
        $proyecto2 = Proyecto::where('Nombre', 'Campaña de Salud')->first();

        if ($proyecto1) {
            CartaPatrocinio::firstOrCreate(
                ['numero_carta' => 'CP-2025-001'],
                [
                    'destinatario' => 'Empresa Verde S.A.',
                    'descripcion' => 'Solicitud de patrocinio para proyecto de reforestación',
                    'monto_solicitado' => 5000.00,
                    'estado' => 'Pendiente',
                    'fecha_solicitud' => '2025-01-10',
                    'proyecto_id' => $proyecto1->ProyectoID,
                    'usuario_id' => $carlos->id,
                    'observaciones' => 'Primera solicitud del año',
                ]
            );
        }

        if ($proyecto2) {
            CartaPatrocinio::firstOrCreate(
                ['numero_carta' => 'CP-2025-002'],
                [
                    'destinatario' => 'Farmacia Central',
                    'descripcion' => 'Solicitud de medicamentos para campaña de salud',
                    'monto_solicitado' => 3000.00,
                    'estado' => 'Aprobada',
                    'fecha_solicitud' => '2025-01-20',
                    'fecha_respuesta' => '2025-01-25',
                    'proyecto_id' => $proyecto2->ProyectoID,
                    'usuario_id' => $maria->id,
                    'observaciones' => 'Aprobado 100% del monto',
                ]
            );
        }

        CartaPatrocinio::firstOrCreate(
            ['numero_carta' => 'CP-2025-003'],
            [
                'destinatario' => 'Supermercados Unidos',
                'descripcion' => 'Solicitud de alimentos para evento benéfico',
                'monto_solicitado' => 2000.00,
                'estado' => 'En Revision',
                'fecha_solicitud' => '2025-02-01',
                'usuario_id' => $axel->id,
            ]
        );

        // ============================================
        // 5. CARTAS FORMALES
        // ============================================
        
        CartaFormal::firstOrCreate(
            ['numero_carta' => 'CF-2025-001'],
            [
                'destinatario' => 'Municipalidad Provincial',
                'asunto' => 'Solicitud de permiso para evento público',
                'contenido' => 'Por medio de la presente, solicitamos el permiso correspondiente...',
                'tipo' => 'Solicitud',
                'estado' => 'Enviada',
                'fecha_envio' => '2025-01-15',
                'usuario_id' => $rodrigo->id,
            ]
        );

        CartaFormal::firstOrCreate(
            ['numero_carta' => 'CF-2025-002'],
            [
                'destinatario' => 'Director de Escuela San José',
                'asunto' => 'Agradecimiento por colaboración',
                'contenido' => 'Agradecemos su valiosa colaboración en nuestro proyecto...',
                'tipo' => 'Agradecimiento',
                'estado' => 'Enviada',
                'fecha_envio' => '2025-01-20',
                'usuario_id' => $maria->id,
            ]
        );

        CartaFormal::firstOrCreate(
            ['numero_carta' => 'CF-2025-003'],
            [
                'destinatario' => 'Rotary Club Distrito 4455',
                'asunto' => 'Invitación a evento anual',
                'contenido' => 'Tenemos el honor de invitarles a nuestro evento anual...',
                'tipo' => 'Invitacion',
                'estado' => 'Borrador',
                'usuario_id' => $carlos->id,
            ]
        );

        CartaFormal::firstOrCreate(
            ['numero_carta' => 'CF-2025-004'],
            [
                'destinatario' => 'Gerente General - Banco Nacional',
                'asunto' => 'Solicitud de apertura de cuenta institucional',
                'contenido' => 'Solicitamos la apertura de una cuenta institucional...',
                'tipo' => 'Solicitud',
                'estado' => 'Enviada',
                'fecha_envio' => '2025-02-01',
                'usuario_id' => $juan->id,
            ]
        );

        // ============================================
        // 6. REUNIONES
        // ============================================
        
        $reuniones = [
            [
                'titulo' => 'Reunión Ordinaria Enero',
                'descripcion' => 'Reunión mensual ordinaria de directiva',
                'fecha_hora' => '2025-01-15 19:00:00',
                'lugar' => 'Sede del Club',
                'tipo' => 'Ordinaria',
                'estado' => 'Finalizada',
                'asistentes_esperados' => 15,
                'observaciones' => 'Asistencia completa',
            ],
            [
                'titulo' => 'Reunión Extraordinaria - Proyecto Salud',
                'descripcion' => 'Planificación de campaña de salud',
                'fecha_hora' => '2025-02-05 19:00:00',
                'lugar' => 'Sede del Club',
                'tipo' => 'Extraordinaria',
                'estado' => 'Finalizada',
                'asistentes_esperados' => 12,
            ],
            [
                'titulo' => 'Reunión de Comité de Finanzas',
                'descripcion' => 'Revisión de presupuesto trimestral',
                'fecha_hora' => '2025-02-20 17:30:00',
                'lugar' => 'Oficina Administrativa',
                'tipo' => 'Comite',
                'estado' => 'Finalizada',
                'asistentes_esperados' => 8,
            ],
            [
                'titulo' => 'Reunión Ordinaria Febrero',
                'descripcion' => 'Reunión mensual ordinaria',
                'fecha_hora' => '2025-02-28 19:00:00',
                'lugar' => 'Sede del Club',
                'tipo' => 'Ordinaria',
                'estado' => 'Programada',
                'asistentes_esperados' => 15,
            ],
        ];

        foreach ($reuniones as $reunionData) {
            Reunion::firstOrCreate(
                ['titulo' => $reunionData['titulo']],
                $reunionData
            );
        }

        // ============================================
        // 7. ASISTENCIAS A REUNIONES
        // ============================================
        
        $reunion1 = Reunion::where('titulo', 'Reunión Ordinaria Enero')->first();
        $reunion2 = Reunion::where('titulo', 'Reunión Extraordinaria - Proyecto Salud')->first();

        if ($reunion1) {
            $asistencias1 = [
                ['usuario_id' => $carlos->id, 'asistio' => true, 'hora_llegada' => '19:00:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $rodrigo->id, 'asistio' => true, 'hora_llegada' => '18:56:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $maria->id, 'asistio' => true, 'hora_llegada' => '19:00:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $juan->id, 'asistio' => true, 'hora_llegada' => '19:06:00', 'tipo_asistencia' => 'Tardanza'],
                ['usuario_id' => $axel->id, 'asistio' => false, 'tipo_asistencia' => 'Ausente', 'observaciones' => 'Justificado por trabajo'],
            ];

            foreach ($asistencias1 as $asistencia) {
                AsistenciaReunion::firstOrCreate(
                    [
                        'reunion_id' => $reunion1->id,
                        'usuario_id' => $asistencia['usuario_id']
                    ],
                    $asistencia
                );
            }
        }

        if ($reunion2) {
            $asistencias2 = [
                ['usuario_id' => $carlos->id, 'asistio' => true, 'hora_llegada' => '17:32:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $rodrigo->id, 'asistio' => true, 'hora_llegada' => '17:31:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $maria->id, 'asistio' => true, 'hora_llegada' => '17:29:00', 'tipo_asistencia' => 'Presente'],
                ['usuario_id' => $juan->id, 'asistio' => true, 'hora_llegada' => '17:36:00', 'tipo_asistencia' => 'Tardanza'],
                ['usuario_id' => $axel->id, 'asistio' => false, 'tipo_asistencia' => 'Ausente', 'observaciones' => 'Justificado por viaje'],
            ];

            foreach ($asistencias2 as $asistencia) {
                AsistenciaReunion::firstOrCreate(
                    [
                        'reunion_id' => $reunion2->id,
                        'usuario_id' => $asistencia['usuario_id']
                    ],
                    $asistencia
                );
            }
        }

        // ============================================
        // 8. PARTICIPACIÓN EN PROYECTOS
        // ============================================
        
        if ($proyecto1) {
            ParticipacionProyecto::firstOrCreate(
                [
                    'proyecto_id' => $proyecto1->ProyectoID,
                    'usuario_id' => $carlos->id
                ],
                [
                    'rol' => 'Coordinador',
                    'fecha_inicio' => '2025-01-15',
                    'horas_dedicadas' => 40.00,
                    'tareas_asignadas' => 'Coordinación general del proyecto',
                    'estado_participacion' => 'Activo',
                ]
            );

            ParticipacionProyecto::firstOrCreate(
                [
                    'proyecto_id' => $proyecto1->ProyectoID,
                    'usuario_id' => $axel->id
                ],
                [
                    'rol' => 'Voluntario',
                    'fecha_inicio' => '2025-01-20',
                    'horas_dedicadas' => 15.00,
                    'tareas_asignadas' => 'Apoyo en jornadas de plantación',
                    'estado_participacion' => 'Activo',
                ]
            );
        }

        if ($proyecto2) {
            ParticipacionProyecto::firstOrCreate(
                [
                    'proyecto_id' => $proyecto2->ProyectoID,
                    'usuario_id' => $maria->id
                ],
                [
                    'rol' => 'Coordinador',
                    'fecha_inicio' => '2025-02-01',
                    'horas_dedicadas' => 35.00,
                    'tareas_asignadas' => 'Coordinación médica',
                    'estado_participacion' => 'Activo',
                ]
            );
        }

        // ============================================
        // 9. PARÁMETROS DEL SISTEMA
        // ============================================
        
        DB::table('parametros')->insertOrIgnore([
            [
                'clave' => 'sistema_activo',
                'valor' => '1',
                'descripcion' => 'Estado del sistema (1=activo, 0=mantenimiento)',
                'tipo' => 'boolean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => 'version_sistema',
                'valor' => '1.0.0',
                'descripcion' => 'Versión actual del sistema',
                'tipo' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => 'nombre_club',
                'valor' => 'Rotaract Club Tegucigalpa Sur',
                'descripcion' => 'Nombre oficial del club',
                'tipo' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('✅ Datos completos cargados exitosamente!');
        $this->command->info('');
        $this->command->info('📊 Resumen:');
        $this->command->info('- Roles: 7');
        $this->command->info('- Usuarios: 5');
        $this->command->info('- Proyectos: 6');
        $this->command->info('- Cartas Patrocinio: 3');
        $this->command->info('- Cartas Formales: 4');
        $this->command->info('- Reuniones: 4');
        $this->command->info('- Asistencias: 10');
        $this->command->info('- Participaciones: 3');
        $this->command->info('- Parámetros: 3');
        $this->command->info('');
        $this->command->info('🔑 Credenciales de acceso:');
        $this->command->info('Email: rodrigopaleom7@gmail.com | Password: password | Rol: Super Admin');
        $this->command->info('Email: carlos@rotaract.com | Password: password | Rol: Vicepresidente');
        $this->command->info('Email: yovani16cabrera20@gmail.com | Password: password | Rol: Vocero');
    }
}
