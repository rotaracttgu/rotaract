<!-- resources/views/modulos/secretaria/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Secretaría - Dashboard')

@section('content')
<div class="secretaria-dashboard">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-tachometer-alt"></i> Panel de Secretaría</h1>
            <p class="subtitle">Gestión integral de documentos y consultas del club</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
                Actualizar
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Inicio
            </a>
            <div class="dropdown">
                <button class="btn btn-primary" id="quickAddBtn">
                    <i class="fas fa-plus"></i>
                    Crear Nuevo
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="quickAddMenu">
                    <a href="{{ route('secretaria.consultas') }}?action=new">
                        <i class="fas fa-comment-medical"></i> Nueva Consulta
                    </a>
                    <a href="{{ route('secretaria.actas') }}?action=new">
                        <i class="fas fa-file-signature"></i> Nueva Acta
                    </a>
                    <a href="{{ route('secretaria.diplomas') }}?action=new">
                        <i class="fas fa-award"></i> Nuevo Diploma
                    </a>
                    <a href="{{ route('secretaria.documentos') }}?action=new">
                        <i class="fas fa-file-alt"></i> Nuevo Documento
                    </a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="stats-grid">
        <div class="stat-card purple" onclick="window.location.href='{{ route('secretaria.consultas') }}'">
            <div class="stat-icon">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['consultas_pendientes'] ?? 0 }}</span>
                <span class="stat-label">Consultas Pendientes</span>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> +{{ $estadisticas['consultas_nuevas'] ?? 0 }} nuevas
                </span>
            </div>
            <div class="stat-action">
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="stat-card blue" onclick="window.location.href='{{ route('secretaria.actas') }}'">
            <div class="stat-icon">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['total_actas'] ?? 0 }}</span>
                <span class="stat-label">Actas Registradas</span>
                <span class="stat-trend">
                    <i class="fas fa-calendar"></i> {{ $estadisticas['actas_este_mes'] ?? 0 }} este mes
                </span>
            </div>
            <div class="stat-action">
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="stat-card orange" onclick="window.location.href='{{ route('secretaria.diplomas') }}'">
            <div class="stat-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['total_diplomas'] ?? 0 }}</span>
                <span class="stat-label">Diplomas Emitidos</span>
                <span class="stat-trend">
                    <i class="fas fa-calendar"></i> {{ $estadisticas['diplomas_este_mes'] ?? 0 }} este mes
                </span>
            </div>
            <div class="stat-action">
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="stat-card indigo" onclick="window.location.href='{{ route('secretaria.documentos') }}'">
            <div class="stat-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['total_documentos'] ?? 0 }}</span>
                <span class="stat-label">Documentos Archivados</span>
                <span class="stat-trend">
                    <i class="fas fa-database"></i> {{ $estadisticas['categorias_documentos'] ?? 0 }} categorías
                </span>
            </div>
            <div class="stat-action">
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="quick-access-section">
        <h2><i class="fas fa-bolt"></i> Accesos Rápidos</h2>
        <div class="quick-access-grid">
            <a href="{{ route('secretaria.consultas') }}" class="quick-card purple">
                <div class="quick-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="quick-content">
                    <h3>Consultas</h3>
                    <p>Gestionar todas las consultas recibidas</p>
                </div>
                <div class="quick-badge">{{ $estadisticas['consultas_pendientes'] ?? 0 }} pendientes</div>
            </a>

            <a href="{{ route('secretaria.actas') }}" class="quick-card blue">
                <div class="quick-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div class="quick-content">
                    <h3>Actas</h3>
                    <p>Ver y administrar actas del club</p>
                </div>
                <div class="quick-badge">{{ $estadisticas['total_actas'] ?? 0 }} registradas</div>
            </a>

            <a href="{{ route('secretaria.diplomas') }}" class="quick-card orange">
                <div class="quick-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="quick-content">
                    <h3>Diplomas</h3>
                    <p>Emitir y gestionar diplomas</p>
                </div>
                <div class="quick-badge">{{ $estadisticas['total_diplomas'] ?? 0 }} emitidos</div>
            </a>

            <a href="{{ route('secretaria.documentos') }}" class="quick-card indigo">
                <div class="quick-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="quick-content">
                    <h3>Documentos</h3>
                    <p>Archivo general de documentos</p>
                </div>
                <div class="quick-badge">{{ $estadisticas['total_documentos'] ?? 0 }} archivados</div>
            </a>
        </div>
    </div>

    <!-- Contenido en Dos Columnas -->
    <div class="dashboard-content">
        <!-- Columna Izquierda -->
        <div class="left-column">
            <!-- Consultas Recientes -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-comments"></i> Consultas Recientes</h3>
                    <a href="{{ route('secretaria.consultas') }}" class="btn-link">Ver todas</a>
                </div>
                <div class="card-body">
                    @forelse($consultasRecientes ?? [] as $consulta)
                    <div class="list-item" onclick="window.location.href='{{ route('secretaria.consultas') }}?view={{ $consulta->id }}'">
                        <div class="item-icon purple">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="item-content">
                            <h4>{{ $consulta->usuario->name ?? 'Usuario' }}</h4>
                            <p>{{ Str::limit($consulta->mensaje, 50) }}</p>
                            <small><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($consulta->created_at)->diffForHumans() }}</small>
                        </div>
                        <div class="item-badge {{ $consulta->estado == 'pendiente' ? 'warning' : 'success' }}">
                            {{ ucfirst($consulta->estado) }}
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>No hay consultas recientes</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Documentos Recientes -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-folder-open"></i> Documentos Recientes</h3>
                    <a href="{{ route('secretaria.documentos') }}" class="btn-link">Ver todos</a>
                </div>
                <div class="card-body">
                    @forelse($documentosRecientes ?? [] as $documento)
                    <div class="list-item" onclick="window.location.href='{{ route('secretaria.documentos') }}?view={{ $documento->id }}'">
                        <div class="item-icon indigo">
                            @php
                                $extension = pathinfo($documento->archivo_path ?? '', PATHINFO_EXTENSION);
                            @endphp
                            @if(strtolower($extension) == 'pdf')
                                <i class="fas fa-file-pdf"></i>
                            @else
                                <i class="fas fa-file-alt"></i>
                            @endif
                        </div>
                        <div class="item-content">
                            <h4>{{ Str::limit($documento->titulo, 40) }}</h4>
                            <p>{{ ucfirst($documento->tipo) }} - {{ ucfirst($documento->categoria ?? 'General') }}</p>
                            <small><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</small>
                        </div>
                        <button class="item-action" onclick="event.stopPropagation(); window.open('{{ Storage::url($documento->archivo_path) }}', '_blank')">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p>No hay documentos recientes</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Columna Derecha -->
        <div class="right-column">
            <!-- Últimas Actas -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-file-signature"></i> Últimas Actas</h3>
                    <a href="{{ route('secretaria.actas') }}" class="btn-link">Ver todas</a>
                </div>
                <div class="card-body">
                    @forelse($actasRecientes ?? [] as $acta)
                    <div class="timeline-item" onclick="window.location.href='{{ route('secretaria.actas') }}?view={{ $acta->id }}'">
                        <div class="timeline-dot blue"></div>
                        <div class="timeline-content">
                            <h4>{{ Str::limit($acta->titulo, 40) }}</h4>
                            <p>{{ ucfirst($acta->tipo_reunion) }}</p>
                            <small><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-file-signature"></i>
                        <p>No hay actas registradas</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Últimos Diplomas -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-award"></i> Últimos Diplomas</h3>
                    <a href="{{ route('secretaria.diplomas') }}" class="btn-link">Ver todos</a>
                </div>
                <div class="card-body">
                    @forelse($diplomasRecientes ?? [] as $diploma)
                    <div class="timeline-item" onclick="window.location.href='{{ route('secretaria.diplomas') }}?view={{ $diploma->id }}'">
                        <div class="timeline-dot orange"></div>
                        <div class="timeline-content">
                            <h4>{{ Str::limit($diploma->motivo, 40) }}</h4>
                            <p>{{ ucfirst($diploma->tipo) }}</p>
                            <small><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($diploma->fecha_emision)->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-award"></i>
                        <p>No hay diplomas emitidos</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Actividad Reciente</h3>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-icon blue">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong>Acta registrada</strong></p>
                                <small>Hace 2 horas</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon orange">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong>Diploma emitido</strong></p>
                                <small>Hace 5 horas</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon purple">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong>Consulta respondida</strong></p>
                                <small>Hace 1 día</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon indigo">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong>Documento archivado</strong></p>
                                <small>Hace 2 días</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Dropdown menu
document.getElementById('quickAddBtn').addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('quickAddMenu').classList.toggle('show');
});

document.addEventListener('click', function() {
    document.getElementById('quickAddMenu').classList.remove('show');
});
</script>
@endpush

@push('styles')
<style>
:root {
    /* Turquoise */
    --color-turquoise-from: #74B6C0;
    --color-turquoise-to: #00ADDB;
    --color-turquoise-light: rgba(116, 182, 192, 0.1);
    
    /* Orange */
    --color-orange-from: #FF7D00;
    --color-orange-to: #C0A656;
    --color-orange-light: rgba(255, 125, 0, 0.1);
    
    /* Violet */
    --color-violet-from: #9B01F3;
    --color-violet-to: #631B47;
    --color-violet-light: rgba(155, 1, 243, 0.1);
    
    /* Grass */
    --color-grass-from: #009759;
    --color-grass-to: #C1C100;
    --color-grass-light: rgba(0, 151, 89, 0.1);
    
    /* Powder Blue */
    --color-powder-from: #B8D4DA;
    --color-powder-to: #6217B235;
    --color-powder-light: rgba(184, 212, 218, 0.2);
}

.secretaria-dashboard {
    padding: 2rem;
    max-width: 1600px;
    margin: 0 auto;
    background: linear-gradient(135deg, #F8FAFB 0%, #FFFFFF 100%);
    min-height: calc(100vh - 4rem);
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, 
        var(--color-turquoise-from) 0%, 
        var(--color-violet-from) 25%, 
        var(--color-orange-from) 50%, 
        var(--color-grass-from) 75%, 
        var(--color-turquoise-to) 100%);
}

.header-left h1 {
    font-size: 2.25rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-turquoise-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 0.75rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-left h1 i {
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.subtitle {
    color: #64748b;
    font-size: 1.05rem;
    margin: 0;
    font-weight: 500;
}

.header-actions {
    display: flex;
    gap: 1rem;
    position: relative;
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: none;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    color: white;
    box-shadow: 0 4px 15px rgba(155, 1, 243, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(155, 1, 243, 0.4);
}

.btn-secondary {
    background: linear-gradient(135deg, var(--color-powder-from), var(--color-turquoise-from));
    color: #1e293b;
    box-shadow: 0 4px 15px rgba(116, 182, 192, 0.2);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(116, 182, 192, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
}

/* Dropdown */
.dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 0.75rem);
    right: 0;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    min-width: 250px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-15px);
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 100;
    overflow: hidden;
    border: 2px solid #f1f5f9;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: #475569;
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
}

.dropdown-menu a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.dropdown-menu a:hover::before {
    transform: scaleY(1);
}

.dropdown-menu a:last-child {
    border-bottom: none;
}

.dropdown-menu a:hover {
    background: linear-gradient(90deg, var(--color-violet-light), transparent);
    color: var(--color-violet-from);
    padding-left: 2rem;
}

.dropdown-menu a i {
    font-size: 1.2rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.75rem;
    margin-bottom: 2.5rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--color-from), var(--color-to));
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: linear-gradient(135deg, var(--bg-color), transparent);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.stat-card.purple {
    --color-from: var(--color-violet-from);
    --color-to: var(--color-violet-to);
    --bg-color: var(--color-violet-light);
}

.stat-card.blue {
    --color-from: var(--color-turquoise-from);
    --color-to: var(--color-turquoise-to);
    --bg-color: var(--color-turquoise-light);
}

.stat-card.orange {
    --color-from: var(--color-orange-from);
    --color-to: var(--color-orange-to);
    --bg-color: var(--color-orange-light);
}

.stat-card.indigo {
    --color-from: var(--color-grass-from);
    --color-to: var(--color-grass-to);
    --bg-color: var(--color-grass-light);
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.stat-card:hover::after {
    opacity: 1;
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 1;
}

.stat-content {
    flex: 1;
    position: relative;
    z-index: 1;
}

.stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    display: block;
    color: #475569;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-trend.up {
    color: var(--color-grass-from);
}

.stat-trend i {
    font-size: 0.75rem;
}

.stat-action {
    color: #94a3b8;
    font-size: 1.5rem;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-action {
    color: var(--color-from);
    transform: translateX(5px);
}

/* Quick Access Section */
.quick-access-section {
    margin-bottom: 2.5rem;
}

.quick-access-section h2 {
    font-size: 1.75rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--color-orange-from), var(--color-orange-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 1.75rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.quick-access-section h2 i {
    background: linear-gradient(135deg, var(--color-orange-from), var(--color-orange-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.quick-access-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.75rem;
}

.quick-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.quick-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--color-from), var(--color-to));
}

.quick-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: linear-gradient(135deg, var(--bg-color), transparent);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.quick-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.quick-card:hover::after {
    opacity: 1;
}

.quick-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 1;
}

.quick-content {
    position: relative;
    z-index: 1;
}

.quick-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
}

.quick-content p {
    color: #64748b;
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.6;
}

.quick-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    color: white;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 1;
}

/* Dashboard Content */
.dashboard-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.75rem;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 2px solid #f1f5f9;
    background: linear-gradient(135deg, #fafbfc, #ffffff);
}

.card-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header h3 i {
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-turquoise-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.btn-link {
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 700;
    transition: all 0.3s ease;
    position: relative;
}

.btn-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.btn-link:hover::after {
    transform: scaleX(1);
}

.card-body {
    padding: 2rem;
}

/* List Item */
.list-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem;
    border-radius: 16px;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.list-item:hover {
    background: linear-gradient(90deg, var(--bg-color), transparent);
    border-color: var(--color-from);
    transform: translateX(5px);
}

.item-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.item-content {
    flex: 1;
}

.item-content h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.375rem 0;
}

.item-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0 0 0.375rem 0;
    line-height: 1.5;
}

.item-content small {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 500;
}

.item-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
}

.item-badge.warning {
    background: linear-gradient(135deg, var(--color-orange-from), var(--color-orange-to));
    color: white;
    box-shadow: 0 4px 15px rgba(255, 125, 0, 0.3);
}

.item-badge.success {
    background: linear-gradient(135deg, var(--color-grass-from), var(--color-grass-to));
    color: white;
    box-shadow: 0 4px 15px rgba(0, 151, 89, 0.3);
}

.item-action {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: #64748b;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.item-action:hover {
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-violet-to));
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(155, 1, 243, 0.3);
}

/* Timeline */
.timeline-item {
    display: flex;
    gap: 1.25rem;
    padding: 1.25rem;
    border-radius: 16px;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    border: 2px solid transparent;
}

.timeline-item:hover {
    background: linear-gradient(90deg, var(--bg-color), transparent);
    border-color: var(--color-from);
    transform: translateX(5px);
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 2.125rem;
    top: 3.5rem;
    bottom: -1rem;
    width: 3px;
    background: linear-gradient(180deg, var(--color-from), transparent);
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    margin-top: 0.5rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    box-shadow: 0 0 0 4px white, 0 0 0 6px var(--color-from);
}

.timeline-dot.blue {
    --color-from: var(--color-turquoise-from);
    --color-to: var(--color-turquoise-to);
    --bg-color: var(--color-turquoise-light);
}

.timeline-dot.orange {
    --color-from: var(--color-orange-from);
    --color-to: var(--color-orange-to);
    --bg-color: var(--color-orange-light);
}

.timeline-content h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.375rem 0;
}

.timeline-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0 0 0.375rem 0;
}

.timeline-content small {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Activity Timeline */
.activity-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1rem;
    border-radius: 14px;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: linear-gradient(90deg, var(--bg-color), transparent);
}

.activity-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--color-from), var(--color-to));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.125rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.activity-icon.blue {
    --color-from: var(--color-turquoise-from);
    --color-to: var(--color-turquoise-to);
    --bg-color: var(--color-turquoise-light);
}

.activity-icon.orange {
    --color-from: var(--color-orange-from);
    --color-to: var(--color-orange-to);
    --bg-color: var(--color-orange-light);
}

.activity-icon.purple {
    --color-from: var(--color-violet-from);
    --color-to: var(--color-violet-to);
    --bg-color: var(--color-violet-light);
}

.activity-icon.indigo {
    --color-from: var(--color-grass-from);
    --color-to: var(--color-grass-to);
    --bg-color: var(--color-grass-light);
}

.activity-content p {
    color: #475569;
    font-size: 0.95rem;
    margin: 0 0 0.375rem 0;
    font-weight: 600;
}

.activity-content small {
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.3;
    background: linear-gradient(135deg, var(--color-violet-from), var(--color-turquoise-to));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state p {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 1400px) {
    .stats-grid,
    .quick-access-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 1024px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .secretaria-dashboard {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        gap: 1.5rem;
        align-items: flex-start;
        padding: 1.5rem;
    }

    .header-left h1 {
        font-size: 1.75rem;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .header-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .stats-grid,
    .quick-access-grid {
        grid-template-columns: 1fr;
    }

    .stat-card,
    .quick-card,
    .content-card {
        border-radius: 16px;
    }

    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endpush