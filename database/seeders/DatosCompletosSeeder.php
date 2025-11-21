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
            'Socio'
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
        
        // NOTA: Los usuarios ya existen en la base de datos
        // Solo obtenemos referencias a los usuarios existentes
        // Si no existen, obtendremos el primero disponible como respaldo
        
        $rodrigo = User::where('email', 'rodrigopaleom7@gmail.com')->first() ?? User::first();
        $axel = User::where('email', 'yovani16cabrera20@gmail.com')->first() ?? User::skip(1)->first() ?? User::first();
        $carlos = User::where('email', 'carlos@rotaract.com')->first() ?? User::skip(2)->first() ?? User::first();
        $maria = User::skip(3)->first() ?? User::first();
        $juan = User::skip(4)->first() ?? User::first();

        // ============================================
        // 3. MIEMBROS (Ahora solo user_id, Rol, FechaIngreso, Apuntes)
        // ============================================
        
        DB::table('miembros')->insertOrIgnore([
            ['MiembroID' => 1, 'user_id' => $rodrigo->id ?? null, 'Rol' => 'Super Admin', 'FechaIngreso' => '2025-01-01', 'Apuntes' => 'Super Administrador del sistema'],
            ['MiembroID' => 2, 'user_id' => $axel->id ?? null, 'Rol' => 'Vocero', 'FechaIngreso' => '2025-02-15', 'Apuntes' => 'Vocero del club'],
            ['MiembroID' => 3, 'user_id' => $carlos->id ?? null, 'Rol' => 'SuperAdmin', 'FechaIngreso' => '2025-02-20', 'Apuntes' => 'SuperAdmin'],
            ['MiembroID' => 4, 'user_id' => $maria->id ?? null, 'Rol' => 'Socio', 'FechaIngreso' => '2025-03-01', 'Apuntes' => 'Socio en proceso'],
            ['MiembroID' => 5, 'user_id' => $juan->id ?? null, 'Rol' => 'Socio', 'FechaIngreso' => '2025-03-10', 'Apuntes' => 'Nuevo socio'],
        ]);

        // ============================================
        // 4. PROYECTOS
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
        // 9. CALENDARIOS (EVENTOS)
        // ============================================
        
        DB::table('calendarios')->insertOrIgnore([
            ['CalendarioID' => 1, 'TituloEvento' => 'Reunión Mensual - Marzo', 'Descripcion' => 'Revisión de avances de proyectos', 'TipoEvento' => 'Presencial', 'EstadoEvento' => 'Finalizado', 'FechaInicio' => '2025-03-15 18:00:00', 'FechaFin' => '2025-03-15 20:00:00', 'HoraInicio' => '18:00:00', 'HoraFin' => '20:00:00', 'Ubicacion' => 'Sede Club Rotaract', 'OrganizadorID' => 1, 'ProyectoID' => null],
            ['CalendarioID' => 2, 'TituloEvento' => 'Reunión Mensual - Abril', 'Descripcion' => 'Planificación de actividades', 'TipoEvento' => 'Presencial', 'EstadoEvento' => 'Finalizado', 'FechaInicio' => '2025-04-15 18:00:00', 'FechaFin' => '2025-04-15 20:00:00', 'HoraInicio' => '18:00:00', 'HoraFin' => '20:00:00', 'Ubicacion' => 'Sede Club Rotaract', 'OrganizadorID' => 1, 'ProyectoID' => null],
            ['CalendarioID' => 3, 'TituloEvento' => 'Reunión Mensual - Mayo', 'Descripcion' => 'Seguimiento de proyectos', 'TipoEvento' => 'Presencial', 'EstadoEvento' => 'Programado', 'FechaInicio' => '2025-05-15 18:00:00', 'FechaFin' => '2025-05-15 20:00:00', 'HoraInicio' => '18:00:00', 'HoraFin' => '20:00:00', 'Ubicacion' => 'Sede Club Rotaract', 'OrganizadorID' => 1, 'ProyectoID' => null],
            ['CalendarioID' => 4, 'TituloEvento' => 'Kick-off Campaña Reciclaje', 'Descripcion' => 'Inicio del proyecto de reciclaje', 'TipoEvento' => 'Presencial', 'EstadoEvento' => 'Finalizado', 'FechaInicio' => '2025-01-20 15:00:00', 'FechaFin' => '2025-01-20 17:00:00', 'HoraInicio' => '15:00:00', 'HoraFin' => '17:00:00', 'Ubicacion' => 'Escuela Central', 'OrganizadorID' => 1, 'ProyectoID' => 1],
        ]);

        // ============================================
        // 10. ASISTENCIAS (A EVENTOS)
        // ============================================
        
        DB::table('asistencias')->insertOrIgnore([
            ['AsistenciaID' => 1, 'MiembroID' => 1, 'CalendarioID' => 1, 'EstadoAsistencia' => 'Presente', 'HoraLlegada' => '18:00:00', 'MinutosTarde' => 0, 'Observacion' => 'Puntual', 'FechaRegistro' => '2025-03-15 18:00:00'],
            ['AsistenciaID' => 2, 'MiembroID' => 2, 'CalendarioID' => 1, 'EstadoAsistencia' => 'Presente', 'HoraLlegada' => '18:05:00', 'MinutosTarde' => 5, 'Observacion' => 'Llegó 5 minutos tarde', 'FechaRegistro' => '2025-03-15 18:05:00'],
            ['AsistenciaID' => 3, 'MiembroID' => 3, 'CalendarioID' => 1, 'EstadoAsistencia' => 'Presente', 'HoraLlegada' => '18:00:00', 'MinutosTarde' => 0, 'Observacion' => 'Puntual', 'FechaRegistro' => '2025-03-15 18:00:00'],
            ['AsistenciaID' => 4, 'MiembroID' => 1, 'CalendarioID' => 2, 'EstadoAsistencia' => 'Presente', 'HoraLlegada' => '18:00:00', 'MinutosTarde' => 0, 'Observacion' => null, 'FechaRegistro' => '2025-04-15 18:00:00'],
        ]);

        // ============================================
        // 11. PARTICIPACIONES (EN PROYECTOS)
        // ============================================
        
        DB::table('participaciones')->insertOrIgnore([
            ['ParticipacionID' => 1, 'MiembroID' => 1, 'ProyectoID' => 1, 'Rol' => 'Coordinador', 'FechaIngreso' => '2025-01-15', 'FechaSalida' => null, 'EstadoParticipacion' => 'Activo'],
            ['ParticipacionID' => 2, 'MiembroID' => 2, 'ProyectoID' => 1, 'Rol' => 'Voluntario', 'FechaIngreso' => '2025-01-20', 'FechaSalida' => null, 'EstadoParticipacion' => 'Activo'],
            ['ParticipacionID' => 3, 'MiembroID' => 3, 'ProyectoID' => 2, 'Rol' => 'Coordinador Logístico', 'FechaIngreso' => '2025-02-05', 'FechaSalida' => null, 'EstadoParticipacion' => 'Activo'],
        ]);

        // ============================================
        // 12. TELÉFONOS
        // ============================================
        
        DB::table('telefonos')->insertOrIgnore([
            ['TelefonoID' => 1, 'MiembroID' => 1, 'Numero' => '+504 9876-5432', 'TipoTelefono' => 'Movil'],
            ['TelefonoID' => 2, 'MiembroID' => 2, 'Numero' => '+504 9123-4567', 'TipoTelefono' => 'Movil'],
            ['TelefonoID' => 3, 'MiembroID' => 3, 'Numero' => '+504 8765-4321', 'TipoTelefono' => 'Movil'],
        ]);

        // ============================================
        // 13. PAGOS DE MEMBRESÍA
        // ============================================
        
        DB::table('pagosmembresia')->insertOrIgnore([
            ['PagoID' => 1, 'MiembroID' => 1, 'FechaPago' => '2025-01-05', 'Monto' => 500.00, 'MetodoPago' => 'Transferencia', 'EstadoPago' => 'Pagado', 'PeriodoPago' => 'Enero 2025'],
            ['PagoID' => 2, 'MiembroID' => 2, 'FechaPago' => '2025-01-10', 'Monto' => 500.00, 'MetodoPago' => 'Efectivo', 'EstadoPago' => 'Pagado', 'PeriodoPago' => 'Enero 2025'],
            ['PagoID' => 3, 'MiembroID' => 3, 'FechaPago' => '2025-02-05', 'Monto' => 500.00, 'MetodoPago' => 'Transferencia', 'EstadoPago' => 'Pagado', 'PeriodoPago' => 'Febrero 2025'],
        ]);

        // ============================================
        // 14. MOVIMIENTOS FINANCIEROS
        // ============================================
        
        DB::table('movimientos')->insertOrIgnore([
            ['MovimientoID' => 1, 'FechaMovimiento' => '2025-01-05 10:00:00', 'Descripcion' => 'Pago de membresía - Rodrigo Palma', 'TipoMovimiento' => 'Ingreso', 'Monto' => 500.00, 'TipoEntrada' => 'Membresia', 'CategoriaEgreso' => null, 'MiembroID' => 1, 'ProyectoID' => null, 'PagoID' => 1],
            ['MovimientoID' => 2, 'FechaMovimiento' => '2025-01-10 11:00:00', 'Descripcion' => 'Pago de membresía - Axel Cabrera', 'TipoMovimiento' => 'Ingreso', 'Monto' => 500.00, 'TipoEntrada' => 'Membresia', 'CategoriaEgreso' => null, 'MiembroID' => 2, 'ProyectoID' => null, 'PagoID' => 2],
            ['MovimientoID' => 3, 'FechaMovimiento' => '2025-01-15 14:00:00', 'Descripcion' => 'Compra de plantas para reforestación', 'TipoMovimiento' => 'Egreso', 'Monto' => 2500.00, 'TipoEntrada' => null, 'CategoriaEgreso' => 'Compra', 'MiembroID' => null, 'ProyectoID' => 1, 'PagoID' => null],
        ]);

        // ============================================
        // 15. NOTAS PERSONALES
        // ============================================
        
        DB::table('notas_personales')->insertOrIgnore([
            ['NotaID' => 1, 'MiembroID' => 1, 'Titulo' => 'Ideas para próximo proyecto', 'Contenido' => 'Considerar un proyecto de alfabetización digital para adultos mayores en comunidades rurales', 'Categoria' => 'idea', 'Visibilidad' => 'privada', 'Etiquetas' => 'proyecto,educacion,digital', 'FechaCreacion' => now(), 'FechaActualizacion' => null, 'FechaRecordatorio' => null, 'Estado' => 'activa'],
            ['NotaID' => 2, 'MiembroID' => 2, 'Titulo' => 'Contactos para jornada de salud', 'Contenido' => 'Lista de doctores voluntarios interesados en participar', 'Categoria' => 'proyecto', 'Visibilidad' => 'publica', 'Etiquetas' => 'salud,contactos,voluntarios', 'FechaCreacion' => now(), 'FechaActualizacion' => null, 'FechaRecordatorio' => null, 'Estado' => 'activa'],
        ]);

        // ============================================
        // 16. PARÁMETROS DEL SISTEMA
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
        $this->command->info('- Usuarios: ' . User::count() . ' (sin modificar - usa los existentes)');
        $this->command->info('- Miembros: ' . DB::table('miembros')->count());
        $this->command->info('- Proyectos: ' . Proyecto::count());
        $this->command->info('- Cartas Patrocinio: ' . CartaPatrocinio::count());
        $this->command->info('- Cartas Formales: ' . CartaFormal::count());
        $this->command->info('- Reuniones: ' . Reunion::count());
        $this->command->info('- Calendarios (Eventos): ' . DB::table('calendarios')->count());
        $this->command->info('- Asistencias (Reuniones): ' . AsistenciaReunion::count());
        $this->command->info('- Asistencias (Eventos): ' . DB::table('asistencias')->count());
        $this->command->info('- Participaciones Proyectos: ' . DB::table('participaciones')->count());
        $this->command->info('- Participaciones (Tabla intermedia): ' . ParticipacionProyecto::count());
        $this->command->info('- Teléfonos: ' . DB::table('telefonos')->count());
        $this->command->info('- Pagos Membresía: ' . DB::table('pagosmembresia')->count());
        $this->command->info('- Movimientos Financieros: ' . DB::table('movimientos')->count());
        $this->command->info('- Notas Personales: ' . DB::table('notas_personales')->count());
        $this->command->info('- Parámetros: 3');
        $this->command->info('');
        $this->command->info('� NOTA: Las tablas de documentos, mensajes, conversaciones y reportes están vacías');
        $this->command->info('          Puedes agregar datos a estas tablas manualmente según las necesites.');
        $this->command->info('');
        $this->command->info('�🔑 IMPORTANTE: Usa las credenciales de tus usuarios existentes');
        $this->command->info('   El seeder NO creó usuarios nuevos, solo agregó datos al sistema.');
    }
}
