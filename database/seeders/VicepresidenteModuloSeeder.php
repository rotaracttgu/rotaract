<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\AsistenciaReunion;
use App\Models\ParticipacionProyecto;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VicepresidenteModuloSeeder extends Seeder
{
    public function run(): void
    {
        echo "🌱 Iniciando seeder del módulo Vicepresidente...\n\n";

        // Obtener usuarios existentes (los primeros 5 para las pruebas)
        $usuarios = User::limit(5)->get();
        
        if ($usuarios->isEmpty()) {
            echo "❌ Error: No hay usuarios en la base de datos. Importa tu backup primero.\n";
            return;
        }

        $vicepresidente = $usuarios->first();
        echo "👤 Usuario Vicepresidente: {$vicepresidente->name} ({$vicepresidente->email})\n";

        // Obtener proyectos existentes
        $proyectos = Proyecto::limit(4)->get();
        
        if ($proyectos->isEmpty()) {
            echo "❌ Error: No hay proyectos en la base de datos.\n";
            return;
        }
        
        echo "📊 Proyectos encontrados: {$proyectos->count()}\n\n";

        // ========================================
        // 1. CREAR CARTAS DE PATROCINIO
        // ========================================
        echo "📝 Creando Cartas de Patrocinio...\n";
        
        $cartasPatrocinio = [
            [
                'numero_carta' => 'CP-2025-001',
                'destinatario' => 'Empresa ABC S.A.',
                'descripcion' => 'Solicitud de patrocinio para proyecto educativo dirigido a escuelas rurales.',
                'monto_solicitado' => 5000.00,
                'estado' => 'Pendiente',
                'fecha_solicitud' => Carbon::now()->subDays(15),
                'proyecto_id' => $proyectos[0]->ProyectoID ?? null,
                'usuario_id' => $vicepresidente->id,
                'observaciones' => 'Esperando respuesta en 30 días hábiles.',
            ],
            [
                'numero_carta' => 'CP-2025-002',
                'destinatario' => 'Fundación XYZ',
                'descripcion' => 'Patrocinio para campaña ambiental de reforestación en zonas afectadas.',
                'monto_solicitado' => 8000.00,
                'estado' => 'Aprobada',
                'fecha_solicitud' => Carbon::now()->subDays(30),
                'fecha_respuesta' => Carbon::now()->subDays(10),
                'proyecto_id' => $proyectos[1]->ProyectoID ?? null,
                'usuario_id' => $vicepresidente->id,
                'observaciones' => 'Aprobado el 100% del monto solicitado.',
            ],
            [
                'numero_carta' => 'CP-2025-003',
                'destinatario' => 'Corporación DEF',
                'descripcion' => 'Apoyo financiero para jornada de salud comunitaria.',
                'monto_solicitado' => 3500.00,
                'estado' => 'En Revision',
                'fecha_solicitud' => Carbon::now()->subDays(5),
                'proyecto_id' => $proyectos[2]->ProyectoID ?? null,
                'usuario_id' => $usuarios[1]->id ?? $vicepresidente->id,
                'observaciones' => 'Comité de revisión evaluando la propuesta.',
            ],
        ];

        foreach ($cartasPatrocinio as $carta) {
            CartaPatrocinio::create($carta);
        }
        echo "   ✅ 3 cartas de patrocinio creadas\n\n";

        // ========================================
        // 2. CREAR CARTAS FORMALES
        // ========================================
        echo "✉️  Creando Cartas Formales...\n";
        
        $cartasFormales = [
            [
                'numero_carta' => 'CF-2025-001',
                'destinatario' => 'Alcaldía Municipal',
                'asunto' => 'Invitación a evento benéfico anual',
                'contenido' => 'Por medio de la presente, cordialmente invitamos a las autoridades municipales...',
                'tipo' => 'Invitacion',
                'estado' => 'Enviada',
                'fecha_envio' => Carbon::now()->subDays(20),
                'usuario_id' => $vicepresidente->id,
                'observaciones' => 'Carta entregada en persona.',
            ],
            [
                'numero_carta' => 'CF-2025-002',
                'destinatario' => 'Rector Universidad Nacional',
                'asunto' => 'Agradecimiento por apoyo en proyecto educativo',
                'contenido' => 'Queremos expresar nuestro más sincero agradecimiento por el invaluable apoyo...',
                'tipo' => 'Agradecimiento',
                'estado' => 'Enviada',
                'fecha_envio' => Carbon::now()->subDays(12),
                'usuario_id' => $vicepresidente->id,
                'observaciones' => 'Envío por correo certificado.',
            ],
            [
                'numero_carta' => 'CF-2025-003',
                'destinatario' => 'Director Hospital Regional',
                'asunto' => 'Solicitud de colaboración para jornada médica',
                'contenido' => 'Respetuosamente solicitamos su colaboración para la realización de...',
                'tipo' => 'Solicitud',
                'estado' => 'Borrador',
                'usuario_id' => $usuarios[2]->id ?? $vicepresidente->id,
                'observaciones' => 'Pendiente de revisión final.',
            ],
            [
                'numero_carta' => 'CF-2025-004',
                'destinatario' => 'Empresarios Asociados',
                'asunto' => 'Notificación de próxima asamblea general',
                'contenido' => 'Se les notifica que la próxima asamblea general se llevará a cabo...',
                'tipo' => 'Notificacion',
                'estado' => 'Enviada',
                'fecha_envio' => Carbon::now()->subDays(3),
                'usuario_id' => $vicepresidente->id,
                'observaciones' => 'Enviado por correo electrónico masivo.',
            ],
        ];

        foreach ($cartasFormales as $carta) {
            CartaFormal::create($carta);
        }
        echo "   ✅ 4 cartas formales creadas\n\n";

        // ========================================
        // 3. CREAR REUNIONES
        // ========================================
        echo "📅 Creando Reuniones...\n";
        
        $reuniones = [
            [
                'titulo' => 'Reunión Ordinaria Enero 2025',
                'descripcion' => 'Reunión mensual ordinaria de la junta directiva para revisar avances.',
                'fecha_hora' => Carbon::now()->addDays(5)->setTime(18, 0),
                'lugar' => 'Sede Club Rotaract',
                'tipo' => 'Ordinaria',
                'estado' => 'Programada',
                'asistentes_esperados' => 15,
                'observaciones' => 'Confirmar asistencia antes del viernes.',
            ],
            [
                'titulo' => 'Junta Directiva - Planificación Anual',
                'descripcion' => 'Reunión extraordinaria para definir proyectos del año.',
                'fecha_hora' => Carbon::now()->subDays(10)->setTime(19, 0),
                'lugar' => 'Auditorio Universidad',
                'tipo' => 'Junta Directiva',
                'estado' => 'Finalizada',
                'asistentes_esperados' => 10,
                'observaciones' => 'Se aprobaron 5 proyectos para el año.',
            ],
            [
                'titulo' => 'Comité de Proyectos Sociales',
                'descripcion' => 'Evaluación de propuestas de nuevos proyectos comunitarios.',
                'fecha_hora' => Carbon::now()->subDays(3)->setTime(17, 30),
                'lugar' => 'Sala de Reuniones #2',
                'tipo' => 'Comite',
                'estado' => 'Finalizada',
                'asistentes_esperados' => 8,
                'observaciones' => 'Se seleccionaron 2 proyectos prioritarios.',
            ],
            [
                'titulo' => 'Reunión Extraordinaria - Evento Benéfico',
                'descripcion' => 'Coordinación del evento benéfico anual.',
                'fecha_hora' => Carbon::now()->addDays(12)->setTime(18, 30),
                'lugar' => 'Centro de Convenciones',
                'tipo' => 'Extraordinaria',
                'estado' => 'Programada',
                'asistentes_esperados' => 20,
                'observaciones' => 'Se requiere confirmación de todos los miembros.',
            ],
        ];

        $reunionesCreadas = [];
        foreach ($reuniones as $reunion) {
            $reunionesCreadas[] = Reunion::create($reunion);
        }
        echo "   ✅ 4 reuniones creadas\n\n";

        // ========================================
        // 4. CREAR ASISTENCIAS A REUNIONES
        // ========================================
        echo "✅ Creando Asistencias a Reuniones...\n";
        
        $contadorAsistencias = 0;
        // Solo crear asistencias para reuniones finalizadas
        foreach ($reunionesCreadas as $reunion) {
            if ($reunion->estado === 'Finalizada') {
                foreach ($usuarios as $index => $usuario) {
                    // 80% de asistencia
                    $asistio = $index < 4; 
                    
                    AsistenciaReunion::create([
                        'reunion_id' => $reunion->id,
                        'usuario_id' => $usuario->id,
                        'asistio' => $asistio,
                        'hora_llegada' => $asistio ? Carbon::parse($reunion->fecha_hora)->addMinutes(rand(-5, 15)) : null,
                        'tipo_asistencia' => $asistio ? ($index === 3 ? 'Tardanza' : 'Presente') : 'Ausente',
                        'observaciones' => $asistio ? null : 'Ausencia justificada por trabajo.',
                    ]);
                    $contadorAsistencias++;
                }
            }
        }
        echo "   ✅ {$contadorAsistencias} registros de asistencia creados\n\n";

        // ========================================
        // 5. CREAR PARTICIPACIONES EN PROYECTOS
        // ========================================
        echo "👥 Creando Participaciones en Proyectos...\n";
        
        $participaciones = [];
        foreach ($proyectos as $index => $proyecto) {
            // Asignar entre 2-4 participantes por proyecto
            $numParticipantes = rand(2, min(4, $usuarios->count()));
            
            for ($i = 0; $i < $numParticipantes; $i++) {
                $usuario = $usuarios[$i];
                $roles = ['Coordinador', 'Colaborador', 'Voluntario', 'Apoyo'];
                
                $participacion = [
                    'proyecto_id' => $proyecto->ProyectoID,
                    'usuario_id' => $usuario->id,
                    'rol' => $i === 0 ? 'Coordinador' : $roles[array_rand($roles)],
                    'fecha_inicio' => Carbon::parse($proyecto->FechaInicio ?? now()->subMonths(2)),
                    'fecha_fin' => $proyecto->FechaFin ? Carbon::parse($proyecto->FechaFin) : null,
                    'horas_dedicadas' => rand(10, 50),
                    'tareas_asignadas' => $i === 0 ? 'Coordinación general, seguimiento y reportes.' : 'Apoyo logístico y operativo.',
                    'estado_participacion' => $proyecto->FechaFin ? 'Finalizado' : 'Activo',
                    'observaciones' => 'Desempeño destacado en las actividades asignadas.',
                ];
                
                try {
                    ParticipacionProyecto::create($participacion);
                    $participaciones[] = $participacion;
                } catch (\Exception $e) {
                    // Skip si ya existe
                }
            }
        }
        echo "   ✅ " . count($participaciones) . " participaciones en proyectos creadas\n\n";

        // ========================================
        // RESUMEN FINAL
        // ========================================
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "✅ SEEDER COMPLETADO EXITOSAMENTE\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        echo "📊 Resumen de datos creados:\n";
        echo "   📝 Cartas de Patrocinio: " . CartaPatrocinio::count() . "\n";
        echo "   ✉️  Cartas Formales: " . CartaFormal::count() . "\n";
        echo "   📅 Reuniones: " . Reunion::count() . "\n";
        echo "   ✅ Asistencias a Reuniones: " . AsistenciaReunion::count() . "\n";
        echo "   👥 Participaciones en Proyectos: " . ParticipacionProyecto::count() . "\n";
        echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
