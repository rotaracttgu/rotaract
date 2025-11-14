@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-primary">
                <i class="fas fa-file-pdf me-2"></i>Generar Reportes Financieros
            </h2>
            <p class="text-muted">Genera reportes personalizados en diferentes formatos</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="formReporte">
                        <!-- Tipo de Reporte -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clipboard-list me-2"></i>Tipo de Reporte
                            </label>
                            <select id="tipoReporte" class="form-select form-select-lg">
                                <option value="general">📊 Reporte General (Resumen Completo)</option>
                                <option value="ingresos">💰 Reporte de Ingresos</option>
                                <option value="gastos">💸 Reporte de Gastos</option>
                                <option value="transferencias">🔄 Reporte de Transferencias</option>
                                <option value="comparativo">📈 Comparativo de Períodos</option>
                                <option value="categoria">📑 Por Categoría</option>
                                <option value="anual">📅 Reporte Anual</option>
                            </select>
                        </div>

                        <!-- Período -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-alt me-2"></i>Período
                            </label>
                            <select id="periodo" class="form-select">
                                <option value="mes_actual">Mes Actual</option>
                                <option value="mes_anterior">Mes Anterior</option>
                                <option value="trimestre">Último Trimestre</option>
                                <option value="semestre">Último Semestre</option>
                                <option value="anio">Año en Curso</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>

                        <!-- Fechas Personalizadas -->
                        <div id="fechasPersonalizadas" style="display:none;">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" id="fechaInicio" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" id="fechaFin" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Formato -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-file-export me-2"></i>Formato de Salida
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="formato" id="formatoPDF" value="pdf" checked>
                                <label class="btn btn-outline-danger" for="formatoPDF">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </label>
                                
                                <input type="radio" class="btn-check" name="formato" id="formatoExcel" value="excel">
                                <label class="btn btn-outline-success" for="formatoExcel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </label>
                                
                                <!-- Word removed: only PDF and Excel supported -->
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary btn-lg" onclick="generarReporte()">
                                <i class="fas fa-download me-2"></i>Generar Reporte
                            </button>
                            <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Mostrar/ocultar fechas personalizadas
    document.getElementById('periodo').addEventListener('change', function() {
        document.getElementById('fechasPersonalizadas').style.display = 
            this.value === 'personalizado' ? 'block' : 'none';
    });

    function generarReporte() {
        const tipo = document.getElementById('tipoReporte').value;
        const periodo = document.getElementById('periodo').value;
        const formato = document.querySelector('input[name="formato"]:checked').value;
        
        let fechaInicio = '';
        let fechaFin = '';
        
        // Validar fechas personalizadas
        if (periodo === 'personalizado') {
            fechaInicio = document.getElementById('fechaInicio').value;
            fechaFin = document.getElementById('fechaFin').value;
            
            if (!fechaInicio || !fechaFin) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes seleccionar ambas fechas para el período personalizado',
                    confirmButtonColor: '#667eea'
                });
                return;
            }
        }
        
        // Mostrar loading
        Swal.fire({
            title: 'Generando Reporte...',
            html: 'Por favor espera mientras se genera el documento',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Construir URL con parámetros
        let url = "{{ route('tesorero.reportes.generar') }}?tipo=" + tipo + 
                  "&periodo=" + periodo + "&formato=" + formato;
        
        if (fechaInicio && fechaFin) {
            url += "&fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin;
        }
        
        // Descargar PDF directamente
        window.location.href = url;
        
        // Mostrar mensaje de éxito después de iniciar la descarga
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: '¡Reporte Generado!',
                html: 'El archivo se está descargando...<br>' +
                      '<small class="text-muted">Tipo: ' + tipo + ' | Período: ' + periodo + '</small>',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }, 1000);
    }
</script>
@endpush
@endsection
