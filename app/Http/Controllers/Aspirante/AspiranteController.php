<?php

namespace App\Http\Controllers\Aspirante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AspiranteController extends Controller
{
    public function dashboard()
    {
        return view('modulos.aspirante.dashboard');
    }

    public function calendario()
    {
        return view('modulos.aspirante.calendario-consulta');
    }

    public function proyectos()
    {
        return view('modulos.aspirante.mis-proyectos');
    }

    public function reuniones()
    {
        return view('modulos.aspirante.mis-reuniones');
    }

    public function secretaria()
    {
        return view('modulos.aspirante.comunicacion-secretaria');
    }

    public function voceria()
    {
        return view('modulos.aspirante.comunicacion-voceria');
    }

    public function notas()
    {
        return view('modulos.aspirante.blog-notas');
    }

    public function crearNota()
    {
        return view('modulos.aspirante.crear-nota');
    }

    public function perfil()
    {
        return view('modulos.aspirante.mi-perfil');
    }
}
