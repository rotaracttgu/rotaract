<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function dashboard()
    {
        return view('vicepresidente.reportes.dashboard');
    }
    
    public function mensuales()
    {
        return view('vicepresidente.reportes.mensuales');
    }
}