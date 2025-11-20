@extends('modulos.tesorero.layout')

@section('title', 'Exportar Datos Financieros')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-file-export text-success me-2"></i> Exportar Datos Financieros</h1>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('tesorero.reportes.generar') }}" method="POST" class="row g-3">
                @csrf

                <!-- Tipo de Exportación -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipo de Exportación</label>
                    <select name="tipo_exportacion" class="form-select" required>
                        <option value="">Seleccionar tipo...</option>
                        <option value="ingresos">Todos los Ingresos</option>
                        <option value="gastos">Todos los Gastos</option>
                        <option value="transferencias">Transferencias</option>
                        <option value="membresias">Membresías</option>
                        <option value="completo">Reporte Completo</option>
                    </select>
                </div>

                <!-- Formato -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Formato</label>
                    <select name="formato" class="form-select" required>
                        <option value="">Seleccionar formato...</option>
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="csv">CSV (.csv)</option>
                        <option value="pdf">PDF (.pdf)</option>
                    </select>
                </div>

                <!-- Período -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control" required>
                </div>

                <!-- Incluir -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Incluir Información</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="incluir_resumen" id="incluir_resumen" checked>
                        <label class="form-check-label" for="incluir_resumen">
                            Resumen Ejecutivo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="incluir_detalles" id="incluir_detalles" checked>
                        <label class="form-check-label" for="incluir_detalles">
                            Detalle Completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="incluir_graficos" id="incluir_graficos">
                        <label class="form-check-label" for="incluir_graficos">
                            Gráficos (solo PDF)
                        </label>
                    </div>
                </div>

                <!-- Botones -->
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-download me-2"></i> Descargar Reporte
                    </button>
                    <a href="{{ route('tesorero.reportes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Instrucciones -->
    <div class="alert alert-info mt-4">
        <h5><i class="fas fa-info-circle me-2"></i> Información Importante</h5>
        <ul class="mb-0">
            <li>Los reportes se generarán con los filtros especificados arriba</li>
            <li>Excel es recomendado para análisis detallado y cálculos adicionales</li>
            <li>PDF es ideal para imprimir o compartir en formato oficial</li>
            <li>CSV es útil para importar en otros sistemas</li>
        </ul>
    </div>
</div>
@endsection
