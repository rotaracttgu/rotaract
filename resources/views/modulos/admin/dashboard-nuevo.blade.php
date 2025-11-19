@extends('layouts.app-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950 -mt-5">
    
    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="space-y-6">
            
            <!-- ⭐ Contenedor para carga AJAX (Roles, Permisos, etc.) -->
            <div id="config-content" class="min-h-screen">
                <!-- Por defecto muestra el overview, AJAX cargará aquí Roles/Permisos -->
                @include('modulos.admin.partials.overview', [
                    'totalUsuarios' => $totalUsuarios ?? 0,
                    'verificados' => $verificados ?? 0,
                    'pendientes' => $pendientes ?? 0,
                    'nuevosEsteMes' => $nuevosEsteMes ?? 0,
                    'porcentajeVerificados' => $porcentajeVerificados ?? 0,
                    'rolesActivos' => $rolesActivos ?? 0,
                    'eventosHoy' => $eventosHoy ?? 0,
                    'loginsHoy' => $loginsHoy ?? 0,
                    'erroresHoy' => $erroresHoy ?? 0,
                    'totalEventos' => $totalEventos ?? 0
                ])
            </div>

        </div>
    </div>
</div>
@endsection