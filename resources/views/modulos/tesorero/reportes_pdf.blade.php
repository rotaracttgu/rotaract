<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte Financiero</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; }
        .header { text-align: center; margin-bottom: 20px; }
        .meta { margin-bottom: 10px; font-size: 0.9rem; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #f2f2f2; }
        h2 { margin: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REPORTE FINANCIERO - {{ strtoupper(str_replace('_',' ', $tipo)) }}</h2>
        <div class="meta">Período: {{ date('d/m/Y', strtotime($fechaInicio)) }} - {{ date('d/m/Y', strtotime($fechaFin)) }}</div>
        <div class="meta">Generado: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    @if(isset($datos['resumen']))
    <h3>Resumen</h3>
    <table>
        <tr><th>Total Ingresos</th><td>{{ number_format($datos['resumen']['total_ingresos'] ?? 0, 2) }}</td></tr>
        <tr><th>Total Gastos</th><td>{{ number_format($datos['resumen']['total_gastos'] ?? 0, 2) }}</td></tr>
        <tr><th>Balance</th><td>{{ number_format($datos['resumen']['balance'] ?? 0, 2) }}</td></tr>
    </table>
    @endif

    @if(!empty($datos['ingresos']))
        <h3 style="margin-top:12px;">Ingresos</h3>
        <table>
            <thead>
                <tr><th>Fecha</th><th>Descripción</th><th>Categoría</th><th>Monto</th></tr>
            </thead>
            <tbody>
            @foreach($datos['ingresos'] as $ing)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($ing->fecha_ingreso ?? $ing->fecha ?? now())) }}</td>
                    <td>{{ $ing->descripcion ?? '-' }}</td>
                    <td>{{ $ing->categoria ?? '-' }}</td>
                    <td style="text-align:right;">{{ number_format($ing->monto ?? 0,2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($datos['gastos']))
        <h3 style="margin-top:12px;">Gastos</h3>
        <table>
            <thead>
                <tr><th>Fecha</th><th>Descripción</th><th>Categoría</th><th>Monto</th></tr>
            </thead>
            <tbody>
            @foreach($datos['gastos'] as $g)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($g->fecha ?? now())) }}</td>
                    <td>{{ $g->descripcion ?? '-' }}</td>
                    <td>{{ $g->categoria ?? '-' }}</td>
                    <td style="text-align:right;">{{ number_format($g->monto ?? 0,2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
