<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Proyectos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #3b82f6;
        }
        .header h1 {
            color: #3b82f6;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .proyecto-nombre {
            font-weight: bold;
            color: #3b82f6;
        }
        .estado {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .estado-activo {
            background-color: #d1fae5;
            color: #065f46;
        }
        .estado-finalizado {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .estado-planificacion {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rotaract - Reporte de Proyectos</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Total de proyectos: {{ $proyectos->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Responsable</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Participantes</th>
                <th>Presupuesto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $proyecto)
                <tr>
                    <td>{{ $proyecto->ProyectoID }}</td>
                    <td class="proyecto-nombre">{{ $proyecto->Nombre }}</td>
                    <td>
                        @if($proyecto->responsable)
                            {{ $proyecto->responsable->Nombre }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($proyecto->FechaInicio)
                            {{ \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($proyecto->FechaFin)
                            {{ \Carbon\Carbon::parse($proyecto->FechaFin)->format('d/m/Y') }}
                        @else
                            En curso
                        @endif
                    </td>
                    <td>
                        @php
                            $estadoClass = 'estado-planificacion';
                            if ($proyecto->FechaInicio && !$proyecto->FechaFin) {
                                $estadoClass = 'estado-activo';
                            } elseif ($proyecto->FechaFin) {
                                $estadoClass = 'estado-finalizado';
                            }
                        @endphp
                        <span class="estado {{ $estadoClass }}">
                            {{ $proyecto->EstadoProyecto ?? $proyecto->Estatus ?? 'Planificación' }}
                        </span>
                    </td>
                    <td style="text-align: center;">{{ $proyecto->total_participantes ?? 0 }}</td>
                    <td>${{ number_format($proyecto->Presupuesto ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado por el sistema Rotaract - Club de Rotaract Fuerza Tepeagatega Sur</p>
    </div>
</body>
</html>
