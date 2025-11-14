<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Puedes agregar otros Models que necesites para obtener datos, ej:
// use App\Models\Proyecto;
// use App\Models\Reunion;

class VicepresidenteController extends Controller
{
    // *** 1. PANEL PRINCIPAL (DASHBOARD) ***

    /**
     * Muestra el panel principal (Dashboard) del vicepresidente.
     * Corresponde a la vista: vicepresidente/dashboard.blade.php
     */
    public function dashboard()
    {
        // 🚨 Lógica: Aquí podrías obtener métricas clave, contadores, o resúmenes.
        // Ejemplo:
        // $totalProyectos = Proyecto::count();
        // $proximasReuniones = Reunion::where('fecha', '>=', now())->limit(5)->get();

        $datos = [
            'usuario' => auth()->user()->nombre,
            // 'totalProyectos' => $totalProyectos
        ];

        return view('modulos.vicepresidente.dashboard', $datos);
    }

    // ---

    // *** 2. ASISTENCIA A PROYECTOS ***

    /**
     * Muestra la vista de asistencia y seguimiento de proyectos.
     * Corresponde a la vista: vicepresidente/asistencia-proyectos.blade.php
     */
    public function asistenciaProyectos()
    {
        // 🚨 Lógica: Obtener la lista de proyectos, el estado de asistencia, etc.

        return view('modulos.vicepresidente.asistencia-proyectos');
    }

    // ---

    // *** 3. ASISTENCIA A REUNIONES ***

    /**
     * Muestra la vista de registro y seguimiento de asistencia a reuniones.
     * Corresponde a la vista: vicepresidente/asistencia-reuniones.blade.php
     */
    public function asistenciaReuniones()
    {
        // 🚨 Lógica: Obtener el calendario de reuniones, el registro de asistencia.

        return view('modulos.vicepresidente.asistencia-reuniones');
    }

    // ---

    // *** 4. CARTAS FORMALES ***

    /**
     * Muestra la vista para gestionar y generar cartas formales.
     * Corresponde a la vista: vicepresidente/cartas-formales.blade.php
     */
    public function cartasFormales()
    {
        // 🚨 Lógica: Obtener plantillas de cartas, borradores, o listado de cartas enviadas.

        return view('modulos.vicepresidente.cartas-formales');
    }

    // ---

    // *** 5. CARTAS DE PATROCINIO ***

    /**
     * Muestra la vista para gestionar y generar cartas de patrocinio.
     * Corresponde a la vista: vicepresidente/cartas-patrocinio.blade.php
     */
    public function cartasPatrocinio()
    {
        // 🚨 Lógica: Obtener un listado de solicitudes de patrocinio o plantillas.

        return view('modulos.vicepresidente.cartas-patrocinio');
    }
}