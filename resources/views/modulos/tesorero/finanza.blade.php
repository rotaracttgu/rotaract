<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Financiera - Tesorero</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-stat {
            border-left: 4px solid;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .card-income { border-left-color: #28a745; }
        .card-expense { border-left-color: #dc3545; }
        .card-membership { border-left-color: #007bff; }
        .card-balance { border-left-color: #6f42c1; }
        
        .btn-action {
            margin: 2px;
            border-radius: 6px;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: transparent;
        }
        
        .filter-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .status-badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .nav-module {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .nav-module .btn {
            margin-right: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Navegación del módulo -->
        <div class="nav-module">
            <a href="{{ route('tesorero.welcome') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Volver a Inicio
            </a>
            <a href="{{ route('tesorero.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
            </a>
            <a href="{{ route('tesorero.calendario') }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-calendar me-1"></i>Calendario
            </a>
            <a href="{{ route('tesorero.finanzas') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-coins me-1"></i>Finanzas
            </a>
        </div>

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-chart-line me-2"></i>Gestión Financiera
                    </h1>
                    <div class="btn-group">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                            <i class="fas fa-file-alt me-2"></i>Generar Reporte
                        </button>

                       <div class="btn-group">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fas fa-download me-2"></i> Exportar
    </button>

    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="#" onclick="exportData('excel')">
                <i class="fas fa-file-excel me-2 text-success"></i> Excel
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                <i class="fas fa-file-pdf me-2 text-danger"></i> PDF
            </a>
        </li>
    </ul>
</div>
                   
                   </div>
                </div>
            </div>  
    </div>

        <!-- Tarjetas de Resumen -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card card-stat card-income h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted mb-1">Ingresos del Mes</h6>
                                <h3 class="mb-0 text-success" id="monthlyIncomes">$12,450.00</h3>
                                <small class="text-muted">+8.2% vs mes anterior</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-arrow-up fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card card-stat card-expense h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted mb-1">Gastos del Mes</h6>
                                <h3 class="mb-0 text-danger" id="monthlyExpenses">$8,320.00</h3>
                                <small class="text-muted">-3.1% vs mes anterior</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-arrow-down fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card card-stat card-membership h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted mb-1">Membresías</h6>
                                <h3 class="mb-0 text-primary" id="monthlyMemberships">$6,750.00</h3>
                                <small class="text-muted">45 pagos activos</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card card-stat card-balance h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted mb-1">Balance Neto</h6>
                                <h3 class="mb-0 text-purple" id="netBalance">$10,880.00</h3>
                                <small class="text-muted">Mes actual</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-balance-scale fa-2x text-purple"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filter-card">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Período</label>
                    <select class="form-select" id="periodFilter">
                        <option value="current_month">Mes Actual</option>
                        <option value="last_month">Mes Anterior</option>
                        <option value="current_year">Año Actual</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="dateFrom">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="dateTo">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary me-2" onclick="applyFilters()">
                        <i class="fas fa-filter me-1"></i>Aplicar
                    </button>
                    <button class="btn btn-outline-secondary" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs de Navegación -->
        <ul class="nav nav-tabs mb-4" id="financialTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="memberships-tab" data-bs-toggle="tab" data-bs-target="#memberships" type="button" role="tab">
                    <i class="fas fa-credit-card me-2"></i>Pagos/Membresías
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="incomes-tab" data-bs-toggle="tab" data-bs-target="#incomes" type="button" role="tab">
                    <i class="fas fa-plus-circle me-2"></i>Ingresos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="expenses-tab" data-bs-toggle="tab" data-bs-target="#expenses" type="button" role="tab">
                    <i class="fas fa-minus-circle me-2"></i>Egresos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="records-tab" data-bs-toggle="tab" data-bs-target="#records" type="button" role="tab">
                    <i class="fas fa-chart-bar me-2"></i>Registros Financieros
                </button>
            </li>
        </ul>

        <!-- Contenido de las Tabs -->
        <div class="tab-content" id="financialTabsContent">
            
            <!-- Tab Pagos/Membresías -->
            <div class="tab-pane fade show active" id="memberships" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Pagos de Membresías
                        </h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#membershipModal">
                            <i class="fas fa-plus me-1"></i>Nuevo Pago
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="membershipTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Miembro</th>
                                        <th>Tipo</th>
                                        <th>Monto</th>
                                        <th>Fecha Pago</th>
                                        <th>Período</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#001</td>
                                        <td>Juan Pérez</td>
                                        <td>Mensual</td>
                                        <td class="text-success fw-bold">$150.00</td>
                                        <td>15/09/2025</td>
                                        <td>Sep 2025</td>
                                        <td><span class="status-badge bg-success text-white">Completado</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewMembership(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editMembership(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteMembership(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#002</td>
                                        <td>María García</td>
                                        <td>Anual</td>
                                        <td class="text-success fw-bold">$1,500.00</td>
                                        <td>10/09/2025</td>
                                        <td>Sep 2025 - Sep 2026</td>
                                        <td><span class="status-badge bg-warning text-dark">Pendiente</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewMembership(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editMembership(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteMembership(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Tab Ingresos -->
            <div class="tab-pane fade" id="incomes" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Ingresos
                        </h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#incomeModal">
                            <i class="fas fa-plus me-1"></i>Nuevo Ingreso
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="incomeTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Fuente</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#I001</td>
                                        <td>Donación Anónima</td>
                                        <td><span class="badge bg-info">Donación</span></td>
                                        <td class="text-success fw-bold">$500.00</td>
                                        <td>14/09/2025</td>
                                        <td>Persona Física</td>
                                        <td><span class="status-badge bg-success text-white">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewIncome(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editIncome(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteIncome(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#I002</td>
                                        <td>Servicio de Consultoría</td>
                                        <td><span class="badge bg-primary">Servicio</span></td>
                                        <td class="text-success fw-bold">$2,000.00</td>
                                        <td>12/09/2025</td>
                                        <td>Empresa XYZ</td>
                                        <td><span class="status-badge bg-success text-white">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewIncome(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editIncome(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteIncome(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Egresos -->
            <div class="tab-pane fade" id="expenses" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-minus-circle me-2"></i>Egresos
                        </h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#expenseModal">
                            <i class="fas fa-plus me-1"></i>Nuevo Gasto
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="expenseTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#E001</td>
                                        <td>Equipo de Sonido</td>
                                        <td><span class="badge bg-secondary">Equipamiento</span></td>
                                        <td class="text-danger fw-bold">$1,200.00</td>
                                        <td>13/09/2025</td>
                                        <td>Audio Pro SA</td>
                                        <td><span class="status-badge bg-success text-white">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewExpense(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editExpense(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteExpense(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#E002</td>
                                        <td>Pago Electricidad</td>
                                        <td><span class="badge bg-warning">Servicios</span></td>
                                        <td class="text-danger fw-bold">$350.00</td>
                                        <td>08/09/2025</td>
                                        <td>Empresa Eléctrica</td>
                                        <td><span class="status-badge bg-success text-white">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewExpense(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editExpense(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteExpense(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Registros Financieros -->
            <div class="tab-pane fade" id="records" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Registros Financieros
                        </h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordModal">
                            <i class="fas fa-plus me-1"></i>Generar Registro
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="recordTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Período</th>
                                        <th>Total Ingresos</th>
                                        <th>Total Gastos</th>
                                        <th>Balance Neto</th>
                                        <th>Fecha Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#R001</td>
                                        <td>Septiembre 2025</td>
                                        <td class="text-success fw-bold">$19,200.00</td>
                                        <td class="text-danger fw-bold">$8,320.00</td>
                                        <td class="text-primary fw-bold">$10,880.00</td>
                                        <td>15/09/2025</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewRecord(1)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editRecord(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteRecord(1)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info btn-action" onclick="downloadReport(1)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#R002</td>
                                        <td>Agosto 2025</td>
                                        <td class="text-success fw-bold">$17,850.00</td>
                                        <td class="text-danger fw-bold">$9,120.00</td>
                                        <td class="text-primary fw-bold">$8,730.00</td>
                                        <td>31/08/2025</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewRecord(2)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action" onclick="editRecord(2)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteRecord(2)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info btn-action" onclick="downloadReport(2)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales CRUD -->
        
        <!-- Modal Pago Membresía -->
        <div class="modal fade" id="membershipModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-credit-card me-2"></i>Registrar Pago de Membresía
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="membershipForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Miembro *</label>
                                    <select class="form-select" required>
                                        <option value="">Seleccionar miembro...</option>
                                        <option value="1">Juan Pérez</option>
                                        <option value="2">María García</option>
                                        <option value="3">Carlos López</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Pago *</label>
                                    <select class="form-select" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="mensual">Mensual</option>
                                        <option value="trimestral">Trimestral</option>
                                        <option value="semestral">Semestral</option>
                                        <option value="anual">Anual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Monto *</label>
                                    <input type="number" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Pago *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Período Inicio *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Período Fin *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select">
                                        <option value="">Seleccionar método...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select">
                                        <option value="completed">Completado</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="cancelled">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Notas</label>
                                <textarea class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveMembership()">
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ingreso -->
        <div class="modal fade" id="incomeModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-plus-circle me-2"></i>Registrar Ingreso
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="incomeForm">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Descripción *</label>
                                    <input type="text" class="form-control" required placeholder="Descripción del ingreso">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo *</label>
                                    <select class="form-select" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="donation">Donación</option>
                                        <option value="membership">Membresía</option>
                                        <option value="service">Servicio</option>
                                        <option value="other">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Monto *</label>
                                    <input type="number" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Ingreso *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fuente</label>
                                    <input type="text" class="form-control" placeholder="Fuente del ingreso">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select">
                                        <option value="">Seleccionar método...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Notas</label>
                                <textarea class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveIncome()">
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Gasto -->
        <div class="modal fade" id="expenseModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-minus-circle me-2"></i>Registrar Gasto
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="expenseForm">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Descripción *</label>
                                    <input type="text" class="form-control" required placeholder="Descripción del gasto">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Categoría *</label>
                                    <select class="form-select" required>
                                        <option value="">Seleccionar categoría...</option>
                                        <option value="equipment">Equipamiento</option>
                                        <option value="maintenance">Mantenimiento</option>
                                        <option value="utilities">Servicios Públicos</option>
                                        <option value="supplies">Suministros</option>
                                        <option value="services">Servicios</option>
                                        <option value="other">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Monto *</label>
                                    <input type="number" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha del Gasto *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Proveedor</label>
                                    <input type="text" class="form-control" placeholder="Nombre del proveedor">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select">
                                        <option value="">Seleccionar método...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Número de Recibo</label>
                                    <input type="text" class="form-control" placeholder="Número de factura/recibo">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select">
                                        <option value="active">Activo</option>
                                        <option value="cancelled">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Notas</label>
                                <textarea class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveExpense()">
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro Financiero -->
        <div class="modal fade" id="recordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-chart-bar me-2"></i>Generar Registro Financiero
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="recordForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Inicio *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Fin *</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Notas</label>
                                <textarea class="form-control" rows="3" placeholder="Observaciones del período..."></textarea>
                            </div>
                            <div class="mt-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Los totales se calcularán automáticamente basándose en los ingresos y gastos del período seleccionado.
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="generateRecord()">
                            <i class="fas fa-calculator me-1"></i>Generar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Generar Reporte -->
        <div class="modal fade" id="generateReportModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-file-alt me-2"></i>Generar Reporte Financiero
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reportForm">
                            <div class="mb-3">
                                <label class="form-label">Tipo de Reporte</label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="monthly">Reporte Mensual</option>
                                    <option value="quarterly">Reporte Trimestral</option>
                                    <option value="yearly">Reporte Anual</option>
                                    <option value="custom">Período Personalizado</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Incluir en el Reporte</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Pagos de Membresías</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Ingresos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Gastos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Gráficos y Estadísticas</label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Formato de Exportación</label>
                                <select class="form-select">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="generateReport()">
                            <i class="fas fa-file-export me-1"></i>Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación para Eliminaciones -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">¿Está seguro que desea eliminar este registro? Esta acción no se puede deshacer.</p>
                        <div class="mt-3">
                            <strong>Registro:</strong> <span id="deleteItemName"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-1"></i>Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Visualización Detallada -->
        <div class="modal fade" id="viewModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalTitle">
                            <i class="fas fa-eye me-2"></i>Detalle del Registro
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="viewModalBody">
                        <!-- El contenido se carga dinámicamente -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="printDetails()">
                            <i class="fas fa-print me-1"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // El JavaScript completo permanece igual - es demasiado largo para incluirlo aquí
        // Copia todo el JavaScript del archivo original después de esta línea
        
        // Variables globales
        let currentEditId = null;
        let currentDeleteItem = null;

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            loadCurrentMonthData();
            setupEventListeners();
        });

        // [... resto del JavaScript original ...]
    </script>
</body>
</html>