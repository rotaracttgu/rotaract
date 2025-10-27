<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SecretariaModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un usuario para asignar como creador
        $usuario = DB::table('users')->first();
        
        if (!$usuario) {
            $this->command->error('No hay usuarios en la base de datos. Por favor, crea un usuario primero.');
            return;
        }

        // Limpiar tablas relacionadas con secretaría
        DB::table('diplomas')->truncate();
        DB::table('actas')->truncate();
        DB::table('consultas')->truncate();
        DB::table('documentos')->delete();

        // Consultas de ejemplo
        $consultas = [
            [
                'usuario_id' => $usuario->id,
                'asunto' => 'Información sobre membresía',
                'mensaje' => '¿Cuáles son los requisitos para ser miembro del club Rotaract? Me interesa mucho participar en las actividades del club.',
                'estado' => 'pendiente',
                'prioridad' => 'media',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'usuario_id' => $usuario->id,
                'asunto' => 'Consulta sobre proyectos',
                'mensaje' => 'Me gustaría participar en proyectos de servicio comunitario. ¿Cómo puedo involucrarme y qué proyectos están activos actualmente?',
                'estado' => 'respondida',
                'prioridad' => 'alta',
                'respuesta' => 'Gracias por tu interés. Te invitamos a nuestra próxima reunión donde presentaremos los proyectos activos. Puedes inscribirte en los siguientes proyectos: Alfabetización, Medio Ambiente y Salud.',
                'respondido_por' => $usuario->id,
                'respondido_at' => Carbon::now()->subDay(),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'usuario_id' => $usuario->id,
                'asunto' => 'Próxima reunión',
                'mensaje' => '¿Cuándo es la próxima reunión del club? ¿Hay algún requisito especial para asistir?',
                'estado' => 'pendiente',
                'prioridad' => 'baja',
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5),
            ],
        ];

        foreach ($consultas as $consulta) {
            DB::table('consultas')->insert($consulta);
        }

        // Actas de ejemplo
        $actas = [
            [
                'titulo' => 'Acta de Reunión Ordinaria - Enero 2025',
                'fecha_reunion' => Carbon::create(2025, 1, 15),
                'tipo_reunion' => 'ordinaria',
                'contenido' => 'Se llevó a cabo la reunión ordinaria con la asistencia de los miembros. Se aprobó el acta anterior y se discutieron los proyectos en curso. Se aprobó el presupuesto para el proyecto de alfabetización y se decidió organizar un evento de recaudación de fondos.',
                'asistentes' => json_encode(['Juan Pérez', 'María López', 'Carlos García', 'Ana Rodríguez']),
                'archivo_path' => 'actas/2025/acta-enero-2025.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::create(2025, 1, 16),
                'updated_at' => Carbon::create(2025, 1, 16),
            ],
            [
                'titulo' => 'Acta de Reunión Extraordinaria - Febrero 2025',
                'fecha_reunion' => Carbon::create(2025, 2, 5),
                'tipo_reunion' => 'extraordinaria',
                'contenido' => 'Se convocó reunión extraordinaria para aprobar el proyecto de construcción de biblioteca comunitaria. Se designó a María López como coordinadora del proyecto y se inició la planificación de recaudación de fondos.',
                'asistentes' => json_encode(['Juan Pérez', 'María López', 'Luis Hernández']),
                'archivo_path' => 'actas/2025/acta-extraordinaria-febrero-2025.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::create(2025, 2, 6),
                'updated_at' => Carbon::create(2025, 2, 6),
            ],
            [
                'titulo' => 'Acta de Junta Directiva - Marzo 2025',
                'fecha_reunion' => Carbon::create(2025, 3, 1),
                'tipo_reunion' => 'junta',
                'contenido' => 'Reunión de la junta directiva para revisar el plan estratégico del club. Se discutieron las metas del trimestre y se asignaron responsabilidades a cada miembro de la directiva.',
                'asistentes' => json_encode(['Juan Pérez', 'María López', 'Carlos García']),
                'archivo_path' => 'actas/2025/acta-junta-marzo-2025.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::create(2025, 3, 2),
                'updated_at' => Carbon::create(2025, 3, 2),
            ],
        ];

        foreach ($actas as $acta) {
            DB::table('actas')->insert($acta);
        }

        // Diplomas de ejemplo
        $diplomas = [
            [
                'miembro_id' => $usuario->id,
                'tipo' => 'reconocimiento',
                'motivo' => 'Por su destacada participación en el proyecto de alfabetización comunitaria y liderazgo ejemplar',
                'fecha_emision' => Carbon::create(2025, 1, 20),
                'archivo_path' => 'diplomas/2025/diploma-reconocimiento-enero.pdf',
                'emitido_por' => $usuario->id,
                'enviado_email' => true,
                'fecha_envio_email' => Carbon::create(2025, 1, 21),
                'created_at' => Carbon::create(2025, 1, 20),
                'updated_at' => Carbon::create(2025, 1, 21),
            ],
            [
                'miembro_id' => $usuario->id,
                'tipo' => 'participacion',
                'motivo' => 'Por su activa participación en el seminario de liderazgo juvenil 2025',
                'fecha_emision' => Carbon::create(2025, 2, 10),
                'archivo_path' => 'diplomas/2025/diploma-participacion-febrero.pdf',
                'emitido_por' => $usuario->id,
                'enviado_email' => false,
                'created_at' => Carbon::create(2025, 2, 10),
                'updated_at' => Carbon::create(2025, 2, 10),
            ],
            [
                'miembro_id' => $usuario->id,
                'tipo' => 'merito',
                'motivo' => 'Por su excepcional desempeño como tesorero del club durante el período 2024-2025',
                'fecha_emision' => Carbon::create(2025, 3, 1),
                'archivo_path' => 'diplomas/2025/diploma-merito-marzo.pdf',
                'emitido_por' => $usuario->id,
                'enviado_email' => false,
                'created_at' => Carbon::create(2025, 3, 1),
                'updated_at' => Carbon::create(2025, 3, 1),
            ],
        ];

        foreach ($diplomas as $diploma) {
            DB::table('diplomas')->insert($diploma);
        }

        // Documentos generales de ejemplo
        $documentos = [
            [
                'titulo' => 'Reglamento Interno del Club Rotaract',
                'tipo' => 'oficial',
                'categoria' => 'normativa',
                'descripcion' => 'Documento oficial que establece las normas y procedimientos del club',
                'archivo_path' => 'documentos/2025/reglamento-interno.pdf',
                'archivo_nombre' => 'reglamento-interno.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::create(2025, 1, 5),
                'updated_at' => Carbon::create(2025, 1, 5),
            ],
            [
                'titulo' => 'Plan Anual de Actividades 2025',
                'tipo' => 'interno',
                'categoria' => 'planificacion',
                'descripcion' => 'Planificación de todas las actividades y proyectos para el año 2025',
                'archivo_path' => 'documentos/2025/plan-anual-2025.pdf',
                'archivo_nombre' => 'plan-anual-2025.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::create(2025, 1, 10),
                'updated_at' => Carbon::create(2025, 1, 10),
            ],
            [
                'titulo' => 'Directorio de Miembros Activos',
                'tipo' => 'interno',
                'categoria' => 'informativo',
                'descripcion' => 'Lista actualizada de todos los miembros activos del club con sus datos de contacto',
                'archivo_path' => 'documentos/2025/directorio-miembros.pdf',
                'archivo_nombre' => 'directorio-miembros.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'titulo' => 'Protocolo de Eventos',
                'tipo' => 'oficial',
                'categoria' => 'procedimientos',
                'descripcion' => 'Guía de protocolo para la organización de eventos oficiales del club',
                'archivo_path' => 'documentos/2025/protocolo-eventos.pdf',
                'archivo_nombre' => 'protocolo-eventos.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::now()->subWeek(),
                'updated_at' => Carbon::now()->subWeek(),
            ],
            [
                'titulo' => 'Informe de Actividades Trimestral',
                'tipo' => 'informe',
                'categoria' => 'reportes',
                'descripcion' => 'Resumen de todas las actividades realizadas durante el primer trimestre de 2025',
                'archivo_path' => 'documentos/2025/informe-q1-2025.pdf',
                'archivo_nombre' => 'informe-q1-2025.pdf',
                'creado_por' => $usuario->id,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($documentos as $documento) {
            DB::table('documentos')->insert($documento);
        }

        $this->command->info('✅ Seeder del módulo de Secretaría ejecutado correctamente');
        $this->command->info('   - ' . count($consultas) . ' consultas creadas');
        $this->command->info('   - ' . count($actas) . ' actas creadas');
        $this->command->info('   - ' . count($diplomas) . ' diplomas creados');
        $this->command->info('   - ' . count($documentos) . ' documentos creados');
    }
}
