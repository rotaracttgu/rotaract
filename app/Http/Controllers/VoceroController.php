<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoceroController extends Controller
{
    // Vista principal/bienvenida del módulo vocero
    public function index()
    {
        return view('modulos.vocero.vocero');
    }

    // Vista de bienvenida específica
    public function welcome()
    {
        return view('modulos.vocero.welcome');
    }

    // Vista del calendario
    public function calendario()
    {
        return view('modulos.vocero.calendario');
    }

    // Vista del dashboard
    public function dashboard()
    {
        return view('modulos.vocero.dashboard');
    }

    // Vista de gestión de asistencias
    public function gestionAsistencias()
    {
        return view('modulos.vocero.gestion-asistencias');
    }

    // Vista de gestión de eventos
    public function gestionEventos()
    {
        return view('modulos.vocero.gestion-eventos');
    }

    // Vista de reportes y análisis
    public function reportesAnalisis()
    {
        return view('modulos.vocero.reportes-analisis');
    }
}