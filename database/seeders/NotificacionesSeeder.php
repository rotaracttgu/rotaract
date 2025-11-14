<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notificacion;

class NotificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario
        $user = User::first();

        if ($user) {
            // Crear notificaciones de prueba
            Notificacion::create([
                'usuario_id' => $user->id,
                'tipo' => 'reunion_creada',
                'titulo' => 'Nueva Reunión Programada',
                'mensaje' => 'Se ha programado una nueva reunión general del club para el 15 de noviembre.',
                'url' => '/socio/reuniones',
                'leida' => false,
                'icono' => 'fa-calendar-check',
                'color' => 'purple'
            ]);

            Notificacion::create([
                'usuario_id' => $user->id,
                'tipo' => 'proyecto_creado',
                'titulo' => 'Nuevo Proyecto',
                'mensaje' => 'Se ha creado un nuevo proyecto: "Campaña de Reforestación".',
                'url' => '/socio/proyectos',
                'leida' => false,
                'icono' => 'fa-seedling',
                'color' => 'green'
            ]);

            Notificacion::create([
                'usuario_id' => $user->id,
                'tipo' => 'evento_actualizado',
                'titulo' => 'Evento Actualizado',
                'mensaje' => 'El evento "Jornada de Voluntariado" ha sido reprogramado para el 20 de noviembre.',
                'url' => '/socio/calendario',
                'leida' => false,
                'icono' => 'fa-sync',
                'color' => 'blue'
            ]);

            echo "✓ Notificaciones de prueba creadas exitosamente.\n";
        } else {
            echo "✗ No se encontró ningún usuario.\n";
        }
    }
}
