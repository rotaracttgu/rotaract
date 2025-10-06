<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesoreroController extends Controller
{
    /**
     * Muestra la página de bienvenida del módulo Tesorero
     */
    public function welcome()
    {
        return view('modulos.tesorero.welcome');
    }

    /**
     * Muestra el dashboard principal del Tesorero
     */
    public function index()
    {
        return view('modulos.tesorero.dashboard');
    }

    /**
     * Muestra el calendario financiero
     */
    public function calendario()
    {
        return view('modulos.tesorero.calendario');
    }

    /**
     * Muestra la gestión de finanzas
     */
    public function finanzas()
    {
        return view('modulos.tesorero.finanza');
    }
}