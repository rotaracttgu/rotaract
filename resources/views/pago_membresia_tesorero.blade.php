<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago de Membresía - Tesorero</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-card {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .breadcrumb-custom {
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .breadcrumb-custom a {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-custom a:hover {
            text-decoration: underline;
        }

        .member-info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border-left: 5px solid #667eea;
        }

        .member-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .info-group {
            margin-bottom: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            color: #212529;
            font-size: 1rem;
        }

        .payment-form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .membership-history-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .history-item {
            padding: 15px;
            border-left: 4px solid #667eea;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary-custom {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .calculation-summary {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #667eea;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-box-success {
            background: #d4edda;
            color: #28a745;
        }

        .icon-box-warning {
            background: #fff3cd;
            color: #ffc107;
        }

        .icon-box-info {
            background: #d1ecf1;
            color: #17a2b8;
        }

        @media (max-width: 768px) {
            .member-info-card, .payment-form-card, .membership-history-card {
                padding: 15px;
            }

            .header-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header-card">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom mb-0">
                    <li class="breadcrumb-item">
                        <a href="/"><i class="fas fa-home me-2"></i>Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/finanza">Gestión Financiera</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        Registrar Pago de Membresía
                    </li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-credit-card me-2"></i>Registrar Pago de Membresía
                    </h1>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-user-shield me-2"></i>Gestión Financiera
                    </p>
                </div>
                <div>
                    <button class="btn btn-light" onclick="window.history.back()">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Columna Izquierda: Información del Miembro -->
            <div class="col-lg-4">
                <!-- Información del Miembro -->
                <div class="member-info-card">
                    <div class="text-center mb-3">
                        <div class="member-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mb-1">Juan Carlos Pérez López</h4>
                        <p class="text-muted mb-2">Miembro #00245</p>
                        <span class="status-badge status-active">
                            <i class="fas fa-check-circle me-1"></i>Activo
                        </span>
                    </div>

                    <hr>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-id-card me-2"></i>Identificación
                        </span>
                        <span class="info-value">0801-1995-12345</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </span>
                        <span class="info-value">juan.perez@email.com</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-phone me-2"></i>Teléfono
                        </span>
                        <span class="info-value">+504 9876-5432</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-calendar-check me-2"></i>Fecha de Ingreso
                        </span>
                        <span class="info-value">15 de Enero, 2023</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-crown me-2"></i>Tipo de Membresía Actual
                        </span>
                        <span class="info-value">
                            <span class="badge bg-primary">Mensual</span>
                        </span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-calendar-times me-2"></i>Último Pago Registrado
                        </span>
                        <span class="info-value">15 de Septiembre, 2025</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">
                            <i class="fas fa-hourglass-half me-2"></i>Estado de Membresía
                        </span>
                        <span class="info-value">
                            <span class="badge bg-success">Al día</span>
                        </span>
                    </div>

                    <div class="alert alert-info alert-custom mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Nota:</strong> La membresía vence el 15 de Octubre, 2025
                    </div>
                </div>

                <!-- Historial de Pagos Recientes -->
                <div class="membership-history-card">
                    <h5 class="section-title">
                        <i class="fas fa-history me-2"></i>Historial de Pagos
                    </h5>

                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold text-primary">Septiembre 2025</div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>15/09/2025
                                </small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">L. 150.00</div>
                                <span class="badge bg-success">Pagado</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-receipt me-1"></i>Recibo: #REC-2025-0089
                            </small>
                        </div>
                    </div>

                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold text-primary">Agosto 2025</div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>15/08/2025
                                </small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">L. 150.00</div>
                                <span class="badge bg-success">Pagado</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-receipt me-1"></i>Recibo: #REC-2025-0067
                            </small>
                        </div>
                    </div>

                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold text-primary">Julio 2025</div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>15/07/2025
                                </small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">L. 150.00</div>
                                <span class="badge bg-success">Pagado</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-receipt me-1"></i>Recibo: #REC-2025-0045
                            </small>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="#" class="text-primary">
                            <i class="fas fa-clock-rotate-left me-1"></i>Ver historial completo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Formulario de Pago -->
            <div class="col-lg-8">
                <!-- Formulario de Pago -->
                <div class="payment-form-card">
                    <h5 class="section-title">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Datos del Pago
                    </h5>

                    <form id="paymentForm">
                        <!-- Información del Pago -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Tipo de Membresía</label>
                                <select class="form-select" id="membershipType" required onchange="calculateAmount()">
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="mensual" data-amount="150">Mensual - L. 150.00</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Fecha de Pago</label>
                                <input type="date" class="form-control" id="paymentDate" required value="2025-10-15">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Período Inicio</label>
                                <input type="date" class="form-control" id="periodStart" required onchange="calculatePeriodEnd()">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Período Fin</label>
                                <input type="date" class="form-control" id="periodEnd" required readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required-field">Monto Base</label>
                                <div class="input-group">
                                    <span class="input-group-text">L.</span>
                                    <input type="number" class="form-control" id="baseAmount" required step="0.01" readonly>
                                </div>
                            </div>
                        <!-- Método de Pago -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Método de Pago</label>
                                <select class="form-select" id="paymentMethod" required onchange="togglePaymentDetails()">
                                    <option value="">Seleccionar método...</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Referencia</label>
                                <input type="text" class="form-control" id="referenceNumber" placeholder="Ej: REF-123456">
                            </div>
                        </div>

                        <!-- Detalles de Transferencia (se muestra condicionalmente) -->
                        <div id="transferDetails" style="display: none;">
                            <div class="alert alert-info alert-custom">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Información Bancaria:</strong> Complete los detalles de la transferencia
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Banco</label>
                                    <select class="form-select" id="bankName">
                                        <option value="">Seleccionar banco...</option>
                                        <option value="bac">BAC Honduras</option>
                                        <option value="ficohsa">Banco Ficohsa</option>
                                        <option value="atlantida">Banco Atlántida</option>
                                        <option value="occidente">Banco de Occidente</option>
                                        <option value="banpais">Banpaís</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Número de Cuenta</label>
                                    <input type="text" class="form-control" id="accountNumber" placeholder="Últimos 4 dígitos">
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-3">
                            <label class="form-label">Observaciones / Notas</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="Agregar notas o comentarios adicionales sobre este pago..."></textarea>
                        </div>

                        <!-- Comprobante de Pago -->
                        <div class="mb-3">
                            <label class="form-label">Adjuntar Comprobante de Pago</label>
                            <input type="file" class="form-control" id="paymentProof" accept="image/*,.pdf">
                            <small class="text-muted">
                                <i class="fas fa-paperclip me-1"></i>Formatos aceptados: JPG, PNG, PDF (Máx. 5MB)
                            </small>
                        </div>

                        <!-- Resumen del Cálculo -->
                        <div class="calculation-summary">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-calculator me-2"></i>Resumen del Pago
                            </h6>
                            
                            <div class="summary-row">
                                <span>Monto Base:</span>
                                <span class="fw-bold">L. <span id="summaryBase">0.00</span></span>
                            </div>

                            <div class="summary-row">
                                <span>Descuento (%):</span>
                                <span class="text-success">- L. <span id="summaryDiscountPercent">0.00</span></span>
                            </div>

                            <div class="summary-row">
                                <span>Descuento Adicional:</span>
                                <span class="text-success">- L. <span id="summaryDiscountAdditional">0.00</span></span>
                            </div>

                            <div class="summary-row">
                                <span>Total a Pagar:</span>
                                <span class="text-primary">L. <span id="totalAmount">0.00</span></span>
                            </div>
                        </div>

                        <!-- Estado del Pago -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Estado del Pago</label>
                                <select class="form-select" id="paymentStatus" required>
                                    <option value="completado">Completado</option>
                                    <option value="pendiente">Pendiente de Verificación</option>
                                    <option value="procesando">En Proceso</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recibo Generado</label>
                                <input type="text" class="form-control" id="receiptNumber" placeholder="Se genera automáticamente" readonly>
                            </div>
                        </div>

                        <!-- Opciones Adicionales -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendEmail" checked>
                                <label class="form-check-label" for="sendEmail">
                                    <i class="fas fa-envelope me-2"></i>Enviar comprobante por correo electrónico al miembro
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="generateReceipt" checked>
                                <label class="form-check-label" for="generateReceipt">
                                    <i class="fas fa-file-invoice me-2"></i>Generar recibo oficial automáticamente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="updateMembership" checked>
                                <label class="form-check-label" for="updateMembership">
                                    <i class="fas fa-sync me-2"></i>Actualizar estado de membresía automáticamente
                                </label>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary-custom" onclick="resetForm()">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </button>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="saveAsDraft()">
                                    <i class="fas fa-save me-2"></i>Guardar Borrador
                                </button>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-check-circle me-2"></i>Registrar Pago
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Alertas Importantes -->
                <div class="alert alert-warning alert-custom">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Importante:</strong> Verifique que todos los datos sean correctos antes de registrar el pago. Una vez registrado, el pago quedará en el historial del miembro.
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--primary-gradient); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>Confirmar Registro de Pago
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="icon-box icon-box-success mx-auto">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                    <h6 class="text-center mb-3">¿Está seguro de registrar este pago?</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-2"><strong>Miembro:</strong> Juan Carlos Pérez López</p>
                        <p class="mb-2"><strong>Tipo:</strong> <span id="confirmType">-</span></p>
                        <p class="mb-2"><strong>Período:</strong> <span id="confirmPeriod">-</span></p>
                        <p class="mb-0"><strong>Monto Total:</strong> <span class="text-success fw-bold">L. <span id="confirmAmount">0.00</span></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-custom" onclick="confirmPayment()">
                        <i class="fas fa-check me-2"></i>Confirmar Pago
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Éxito -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>¡Pago Registrado Exitosamente!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="icon-box icon-box-success mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5 class="mb-3">El pago ha sido registrado correctamente</h5>
                    <div class="bg-light p-3 rounded mb-3">
                        <p class="mb-2"><strong>Número de Recibo:</strong> #REC-2025-0090</p>
                        <p class="mb-0"><strong>Monto Pagado:</strong> <span class="text-success fw-bold">L. <span id="successAmount">0.00</span></span></p>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Se ha enviado una copia del recibo al correo del miembro
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-primary" onclick="printReceipt()">
                        <i class="fas fa-print me-2"></i>Imprimir Recibo
                    </button>
                    <button type="button" class="btn btn-primary-custom" onclick="goToFinancialManagement()">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Gestión Financiera
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Variables globales
        let currentMemberData = {
            id: '00245',
            name: 'Juan Carlos Pérez López',
            email: 'juan.perez@email.com'
        };

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            initializePage();
            setupFormValidation();
        });

        function initializePage() {
            // Establecer fecha actual
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('paymentDate').value = today;
            
            // Establecer período inicio
            document.getElementById('periodStart').value = today;
            
            // Generar número de recibo
            generateReceiptNumber();
        }

        function generateReceiptNumber() {
            const year = new Date().getFullYear();
            const random = Math.floor(Math.random() * 9000) + 1000;
            document.getElementById('receiptNumber').value = `#REC-${year}-${random}`;
        }

        function calculateAmount() {
            const typeSelect = document.getElementById('membershipType');
            const selectedOption = typeSelect.options[typeSelect.selectedIndex];
            
            if (selectedOption.value) {
                const amount = parseFloat(selectedOption.dataset.amount);
                document.getElementById('baseAmount').value = amount.toFixed(2);
                
                // Calcular período fin basado en el tipo
                calculatePeriodEnd();
                
                // Calcular total
                calculateTotal();
            } else {
                document.getElementById('baseAmount').value = '';
                document.getElementById('periodEnd').value = '';
            }
        }

        function calculatePeriodEnd() {
            const periodStart = document.getElementById('periodStart').value;
            const membershipType = document.getElementById('membershipType').value;
            
            if (!periodStart || !membershipType) return;
            
            const startDate = new Date(periodStart);
            let endDate = new Date(startDate);
            
            switch(membershipType) {
                case 'mensual':
                    endDate.setMonth(endDate.getMonth() + 1);
                    break;
                case 'trimestral':
                    endDate.setMonth(endDate.getMonth() + 3);
                    break;
                case 'semestral':
                    endDate.setMonth(endDate.getMonth() + 6);
                    break;
                case 'anual':
                    endDate.setFullYear(endDate.getFullYear() + 1);
                    break;
            }
            
            endDate.setDate(endDate.getDate() - 1);
            document.getElementById('periodEnd').value = endDate.toISOString().split('T')[0];
        }

        function calculateTotal() {
            const baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;
            const discountPercent = parseFloat(document.getElementById('discount').value) || 0;
            const additionalDiscount = parseFloat(document.getElementById('additionalDiscount').value) || 0;
            
            // Calcular descuento porcentual
            const discountAmount = (baseAmount * discountPercent) / 100;
            
            // Calcular total
            const total = baseAmount - discountAmount - additionalDiscount;
            
            // Actualizar resumen
            document.getElementById('summaryBase').textContent = baseAmount.toFixed(2);
            document.getElementById('summaryDiscountPercent').textContent = discountAmount.toFixed(2);
            document.getElementById('summaryDiscountAdditional').textContent = additionalDiscount.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        function togglePaymentDetails() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const transferDetails = document.getElementById('transferDetails');
            
            if (paymentMethod === 'transferencia' || paymentMethod === 'deposito') {
                transferDetails.style.display = 'block';
            } else {
                transferDetails.style.display = 'none';
            }
        }

        function setupFormValidation() {
            const form = document.getElementById('paymentForm');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    showConfirmationModal();
                }
            });
        }

        function validateForm() {
            const requiredFields = [
                'membershipType',
                'paymentDate',
                'periodStart',
                'periodEnd',
                'baseAmount',
                'paymentMethod',
                'paymentStatus'
            ];
            
            let isValid = true;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                showToast('Por favor complete todos los campos requeridos', 'danger');
            }
            
            return isValid;
        }

        function showConfirmationModal() {
            const membershipType = document.getElementById('membershipType');
            const selectedType = membershipType.options[membershipType.selectedIndex].text;
            const periodStart = document.getElementById('periodStart').value;
            const periodEnd = document.getElementById('periodEnd').value;
            const totalAmount = document.getElementById('totalAmount').textContent;
            
            document.getElementById('confirmType').textContent = selectedType;
            document.getElementById('confirmPeriod').textContent = `${formatDate(periodStart)} - ${formatDate(periodEnd)}`;
            document.getElementById('confirmAmount').textContent = totalAmount;
            
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }

        function confirmPayment() {
            // Cerrar modal de confirmación
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
            confirmModal.hide();
            
            // Mostrar spinner de carga
            showLoadingSpinner();
            
            // Simular proceso de guardado
            setTimeout(() => {
                hideLoadingSpinner();
                
                // Actualizar monto en modal de éxito
                const totalAmount = document.getElementById('totalAmount').textContent;
                document.getElementById('successAmount').textContent = totalAmount;
                
                // Mostrar modal de éxito
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                
                // En producción, aquí se haría la llamada AJAX para guardar el pago
                console.log('Pago registrado exitosamente');
            }, 2000);
        }

        function saveAsDraft() {
            showLoadingSpinner();
            
            setTimeout(() => {
                hideLoadingSpinner();
                showToast('Borrador guardado exitosamente', 'success');
            }, 1000);
        }

        function resetForm() {
            if (confirm('¿Está seguro de cancelar? Se perderán todos los datos ingresados.')) {
                document.getElementById('paymentForm').reset();
                document.getElementById('periodEnd').value = '';
                calculateTotal();
                showToast('Formulario limpiado', 'info');
            }
        }

        function printReceipt() {
            showToast('Preparando recibo para impresión...', 'info');
            setTimeout(() => {
                window.print();
            }, 500);
        }

        function goToFinancialManagement() {
            window.location.href = '/gestion-financiera';
        }

        // Utilidades
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('es-HN', options);
        }

        function showLoadingSpinner() {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center';
            overlay.style.backgroundColor = 'rgba(0,0,0,0.7)';
            overlay.style.zIndex = '9999';
            overlay.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Procesando...</span>
                    </div>
                    <p class="text-white mt-3">Procesando pago...</p>
                </div>
            `;
            document.body.appendChild(overlay);
        }

        function hideLoadingSpinner() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) overlay.remove();
        }

        function showToast(message, type = 'info') {
            let toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toastContainer';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }

            const toastId = 'toast_' + Date.now();
            const iconClass = type === 'success' ? 'check-circle' : 
                            type === 'danger' ? 'exclamation-circle' : 
                            type === 'warning' ? 'exclamation-triangle' : 'info-circle';
            const bgClass = type === 'success' ? 'bg-success' : 
                          type === 'danger' ? 'bg-danger' : 
                          type === 'warning' ? 'bg-warning' : 'bg-info';
            
            const toastHTML = `
                <div id="${toastId}" class="toast" role="alert">
                    <div class="toast-header ${bgClass} text-white">
                        <i class="fas fa-${iconClass} me-2"></i>
                        <strong class="me-auto">
                            ${type === 'success' ? 'Éxito' : 
                              type === 'danger' ? 'Error' : 
                              type === 'warning' ? 'Advertencia' : 'Información'}
                        </strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 4000 });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }

        // Prevenir salida accidental
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('paymentForm');
            const hasData = form.querySelector('input:not([readonly])').value !== '';
            
            if (hasData) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
</body>
</html>