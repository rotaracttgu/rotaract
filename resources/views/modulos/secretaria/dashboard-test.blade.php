@extends('layouts.app')

@section('title', 'Secretaría - Dashboard TEST')

@section('content')
<div style="padding: 20px;">
    <h1>Dashboard de Secretaría - Modo Test</h1>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0;">
        <h2>Estadísticas:</h2>
        <ul>
            <li>Consultas Pendientes: {{ $estadisticas['consultas_pendientes'] ?? 'N/A' }}</li>
            <li>Consultas Nuevas: {{ $estadisticas['consultas_nuevas'] ?? 'N/A' }}</li>
            <li>Total Actas: {{ $estadisticas['total_actas'] ?? 'N/A' }}</li>
            <li>Actas Este Mes: {{ $estadisticas['actas_este_mes'] ?? 'N/A' }}</li>
            <li>Total Diplomas: {{ $estadisticas['total_diplomas'] ?? 'N/A' }}</li>
            <li>Diplomas Este Mes: {{ $estadisticas['diplomas_este_mes'] ?? 'N/A' }}</li>
            <li>Total Documentos: {{ $estadisticas['total_documentos'] ?? 'N/A' }}</li>
            <li>Categorías Documentos: {{ $estadisticas['categorias_documentos'] ?? 'N/A' }}</li>
        </ul>
    </div>

    <div style="background: #e0f7fa; padding: 20px; margin: 20px 0;">
        <h2>Datos Adicionales:</h2>
        <ul>
            <li>Mensajes Pendientes: {{ $mensajesPendientes ?? 'N/A' }}</li>
            <li>Miembros Activos: {{ $miembrosActivos ?? 'N/A' }}</li>
            <li>Reuniones Recientes: {{ $reunionesRecientes->count() ?? 0 }}</li>
        </ul>
    </div>

    <div style="background: #fff3e0; padding: 20px; margin: 20px 0;">
        <h2>Reuniones Recientes:</h2>
        @if(isset($reunionesRecientes) && $reunionesRecientes->count() > 0)
            <ul>
                @foreach($reunionesRecientes as $reunion)
                    <li>{{ $reunion->titulo }} - {{ $reunion->fecha_hora }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay reuniones recientes</p>
        @endif
    </div>

    <div style="background: #f1f8e9; padding: 20px; margin: 20px 0;">
        <h2>Actas Recientes:</h2>
        @if(isset($actasRecientes) && $actasRecientes->count() > 0)
            <ul>
                @foreach($actasRecientes as $acta)
                    <li>{{ $acta->titulo }} - {{ $acta->fecha_reunion }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay actas recientes</p>
        @endif
    </div>

    <p><strong>Si ves este mensaje, el controlador funciona correctamente.</strong></p>
</div>
@endsection
