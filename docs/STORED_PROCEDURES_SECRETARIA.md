# Guía de Stored Procedures - Módulo Secretaría

## 📚 Índice
1. [Introducción](#introducción)
2. [SP_EstadisticasSecretaria](#sp_estadisticassecretaria)
3. [SP_ReporteDiplomas](#sp_reportediplomas)
4. [SP_BusquedaDocumentos](#sp_busquedadocumentos)
5. [SP_ResumenActas](#sp_resumenactas)
6. [Integración en Controller](#integración-en-controller)
7. [Uso desde Frontend](#uso-desde-frontend)
8. [Troubleshooting](#troubleshooting)

---

## Introducción

Los **Stored Procedures** son rutinas almacenadas en la base de datos MySQL que optimizan consultas complejas y mejoran el rendimiento del módulo de secretaría. Se ejecutan directamente en el servidor de base de datos, reduciendo el tráfico de red y procesamiento en PHP.

### Ventajas
- ⚡ **Rendimiento**: Consultas pre-compiladas y optimizadas
- 🔒 **Seguridad**: Parametrización automática previene SQL injection
- 🔄 **Reutilización**: Lógica centralizada en un solo lugar
- 📊 **Complejidad**: Manejan agregaciones y cálculos complejos eficientemente

### Instalación
Los stored procedures se crean automáticamente al ejecutar las migraciones:
```bash
php artisan migrate
```

### Verificación
```sql
-- Ver todos los procedimientos almacenados
SHOW PROCEDURE STATUS WHERE Db = 'nombre_tu_base_datos';

-- Ver definición de un procedimiento
SHOW CREATE PROCEDURE SP_EstadisticasSecretaria;
```

---

## SP_EstadisticasSecretaria

### Descripción
Genera estadísticas globales del módulo de secretaría para el dashboard principal. Retorna 4 conjuntos de resultados con métricas de consultas, actas, diplomas y documentos.

### Sintaxis SQL
```sql
CALL SP_EstadisticasSecretaria();
```

### Parámetros
**Ninguno** - No requiere parámetros de entrada.

### Resultados

#### Conjunto 1: Estadísticas de Consultas
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total` | int | Total de consultas en el sistema |
| `pendientes` | int | Consultas con estado 'pendiente' |
| `respondidas` | int | Consultas con estado 'respondida' |
| `cerradas` | int | Consultas con estado 'cerrada' |
| `hoy` | int | Consultas creadas hoy |
| `este_mes` | int | Consultas del mes actual |

#### Conjunto 2: Estadísticas de Actas
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total` | int | Total de actas registradas |
| `ordinarias` | int | Actas de reuniones ordinarias |
| `extraordinarias` | int | Actas de reuniones extraordinarias |
| `juntas` | int | Actas de juntas directivas |
| `este_mes` | int | Actas del mes actual |
| `este_anio` | int | Actas del año actual |

#### Conjunto 3: Estadísticas de Diplomas
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total` | int | Total de diplomas emitidos |
| `participacion` | int | Diplomas de participación |
| `reconocimiento` | int | Diplomas de reconocimiento |
| `merito` | int | Diplomas de mérito |
| `asistencia` | int | Diplomas de asistencia |
| `enviados` | int | Diplomas enviados por email |

#### Conjunto 4: Estadísticas de Documentos
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total` | int | Total de documentos archivados |
| `oficiales` | int | Documentos oficiales |
| `internos` | int | Documentos internos |
| `categorias` | int | Número de categorías distintas |
| `este_mes` | int | Documentos del mes actual |
| `este_anio` | int | Documentos del año actual |

### Ejemplo de Uso en PHP (Controller)

```php
use Illuminate\Support\Facades\DB;

public function dashboard()
{
    try {
        // Ejecutar stored procedure
        $results = DB::select('CALL SP_EstadisticasSecretaria()');
        
        // Procesar resultados
        $estadisticas = [
            // Consultas
            'consultas_total' => $results[0]->total ?? 0,
            'consultas_pendientes' => $results[0]->pendientes ?? 0,
            'consultas_respondidas' => $results[0]->respondidas ?? 0,
            'consultas_cerradas' => $results[0]->cerradas ?? 0,
            'consultas_hoy' => $results[0]->hoy ?? 0,
            'consultas_este_mes' => $results[0]->este_mes ?? 0,
            
            // Actas
            'total_actas' => $results[1]->total ?? 0,
            'actas_ordinarias' => $results[1]->ordinarias ?? 0,
            'actas_extraordinarias' => $results[1]->extraordinarias ?? 0,
            'actas_juntas' => $results[1]->juntas ?? 0,
            'actas_este_mes' => $results[1]->este_mes ?? 0,
            'actas_este_anio' => $results[1]->este_anio ?? 0,
            
            // Diplomas
            'total_diplomas' => $results[2]->total ?? 0,
            'diplomas_participacion' => $results[2]->participacion ?? 0,
            'diplomas_reconocimiento' => $results[2]->reconocimiento ?? 0,
            'diplomas_merito' => $results[2]->merito ?? 0,
            'diplomas_asistencia' => $results[2]->asistencia ?? 0,
            'diplomas_enviados' => $results[2]->enviados ?? 0,
            
            // Documentos
            'total_documentos' => $results[3]->total ?? 0,
            'documentos_oficiales' => $results[3]->oficiales ?? 0,
            'documentos_internos' => $results[3]->internos ?? 0,
            'categorias_documentos' => $results[3]->categorias ?? 0,
            'documentos_este_mes' => $results[3]->este_mes ?? 0,
            'documentos_este_anio' => $results[3]->este_anio ?? 0,
        ];
        
        return view('modulos.secretaria.dashboard', compact('estadisticas'));
        
    } catch (\Exception $e) {
        // Fallback a consultas individuales
        Log::error('Error en SP_EstadisticasSecretaria: ' . $e->getMessage());
        
        // Método alternativo...
    }
}
```

### Ejemplo de Uso Directo en MySQL
```sql
-- Ejecutar y ver todos los resultados
CALL SP_EstadisticasSecretaria();

-- Resultado esperado:
-- Resultado 1 (Consultas):
-- +-------+------------+-------------+----------+------+----------+
-- | total | pendientes | respondidas | cerradas | hoy  | este_mes |
-- +-------+------------+-------------+----------+------+----------+
-- |   150 |         12 |         118 |       20 |    3 |       45 |
-- +-------+------------+-------------+----------+------+----------+

-- Resultado 2 (Actas):
-- +-------+------------+-----------------+--------+----------+-----------+
-- | total | ordinarias | extraordinarias | juntas | este_mes | este_anio |
-- +-------+------------+-----------------+--------+----------+-----------+
-- |    48 |         36 |               8 |      4 |        4 |        48 |
-- +-------+------------+-----------------+--------+----------+-----------+

-- ... etc
```

---

## SP_ReporteDiplomas

### Descripción
Genera un reporte detallado de diplomas emitidos en un rango de fechas, con filtro opcional por tipo. Útil para auditorías y reportes periódicos.

### Sintaxis SQL
```sql
CALL SP_ReporteDiplomas(fecha_inicio, fecha_fin, tipo);
```

### Parámetros

| Parámetro | Tipo | Obligatorio | Descripción |
|-----------|------|-------------|-------------|
| `p_fecha_inicio` | DATE | ✅ Sí | Fecha inicial del período (YYYY-MM-DD) |
| `p_fecha_fin` | DATE | ✅ Sí | Fecha final del período (YYYY-MM-DD) |
| `p_tipo` | VARCHAR(50) | ❌ No | Filtro por tipo: `participacion`, `reconocimiento`, `merito`, `asistencia` o `NULL` para todos |

### Resultados

#### Conjunto 1: Diplomas Detallados
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID del diploma |
| `tipo` | varchar | Tipo de diploma |
| `motivo` | varchar | Motivo de la emisión |
| `fecha_emision` | date | Fecha de emisión |
| `enviado_email` | boolean | Si fue enviado por email |
| `fecha_envio_email` | datetime | Fecha de envío del email |
| `miembro_nombre` | varchar | Nombre del miembro |
| `miembro_email` | varchar | Email del miembro |
| `emisor_nombre` | varchar | Nombre de quien emitió |
| `fecha_creacion` | datetime | Fecha de creación del registro |
| `estado_archivo` | varchar | 'Con archivo' o 'Sin archivo' |

#### Conjunto 2: Resumen
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total_diplomas` | int | Total de diplomas en el período |
| `total_participacion` | int | Diplomas de participación |
| `total_reconocimiento` | int | Diplomas de reconocimiento |
| `total_merito` | int | Diplomas de mérito |
| `total_asistencia` | int | Diplomas de asistencia |
| `total_enviados` | int | Diplomas enviados por email |
| `total_no_enviados` | int | Diplomas pendientes de envío |

### Ejemplo de Uso en PHP (Controller)

```php
public function reporteDiplomas(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'tipo' => 'nullable|in:participacion,reconocimiento,merito,asistencia'
    ]);

    try {
        $results = DB::select('CALL SP_ReporteDiplomas(?, ?, ?)', [
            $request->fecha_inicio,
            $request->fecha_fin,
            $request->tipo
        ]);

        // Separar resultados
        $diplomas = [];
        $resumen = null;

        foreach ($results as $row) {
            if (isset($row->total_diplomas)) {
                $resumen = $row;
            } else {
                $diplomas[] = $row;
            }
        }

        return response()->json([
            'success' => true,
            'diplomas' => $diplomas,
            'resumen' => $resumen
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al generar el reporte: ' . $e->getMessage()
        ], 500);
    }
}
```

### Ejemplo de Uso desde Frontend (JavaScript)

```javascript
async function generarReporteDiplomas() {
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    const tipo = document.getElementById('tipo_diploma').value || null;

    try {
        const response = await fetch('/secretaria/reportes/diplomas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin,
                tipo: tipo
            })
        });

        const data = await response.json();

        if (data.success) {
            console.log('Total diplomas:', data.resumen.total_diplomas);
            console.log('Enviados:', data.resumen.total_enviados);
            
            // Mostrar diplomas en tabla
            mostrarDiplomasEnTabla(data.diplomas);
            
            // Mostrar resumen
            document.getElementById('total-diplomas').textContent = data.resumen.total_diplomas;
            document.getElementById('total-enviados').textContent = data.resumen.total_enviados;
        }
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al generar el reporte');
    }
}

function mostrarDiplomasEnTabla(diplomas) {
    const tbody = document.getElementById('tabla-diplomas-body');
    tbody.innerHTML = '';
    
    diplomas.forEach(diploma => {
        const row = `
            <tr>
                <td>${diploma.miembro_nombre}</td>
                <td>${diploma.tipo}</td>
                <td>${diploma.fecha_emision}</td>
                <td>
                    <span class="badge ${diploma.enviado_email ? 'bg-success' : 'bg-warning'}">
                        ${diploma.enviado_email ? 'Enviado' : 'Pendiente'}
                    </span>
                </td>
                <td>${diploma.estado_archivo}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}
```

### Ejemplo Directo en MySQL
```sql
-- Reporte de todos los diplomas del año 2025
CALL SP_ReporteDiplomas('2025-01-01', '2025-12-31', NULL);

-- Reporte solo de diplomas de reconocimiento del último trimestre
CALL SP_ReporteDiplomas('2025-10-01', '2025-12-31', 'reconocimiento');

-- Reporte del mes actual
SET @inicio = DATE_FORMAT(NOW(), '%Y-%m-01');
SET @fin = LAST_DAY(NOW());
CALL SP_ReporteDiplomas(@inicio, @fin, NULL);
```

---

## SP_BusquedaDocumentos

### Descripción
Realiza búsquedas avanzadas en documentos con múltiples filtros combinables. Busca en título, descripción y nombre de archivo simultáneamente.

### Sintaxis SQL
```sql
CALL SP_BusquedaDocumentos(busqueda, tipo, categoria, fecha_inicio, fecha_fin);
```

### Parámetros

| Parámetro | Tipo | Obligatorio | Descripción |
|-----------|------|-------------|-------------|
| `p_busqueda` | VARCHAR(255) | ❌ No | Término de búsqueda (busca en título, descripción, archivo_nombre) |
| `p_tipo` | VARCHAR(50) | ❌ No | Filtro por tipo: `oficial`, `interno`, `comunicado`, `carta`, `informe`, `otro` |
| `p_categoria` | VARCHAR(100) | ❌ No | Filtro por categoría exacta |
| `p_fecha_inicio` | DATE | ❌ No | Fecha inicial del rango |
| `p_fecha_fin` | DATE | ❌ No | Fecha final del rango |

**Nota**: Todos los parámetros son opcionales. Se pueden usar `NULL` o `''` (string vacío) para omitirlos.

### Resultados

#### Conjunto 1: Documentos Encontrados
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID del documento |
| `titulo` | varchar | Título del documento |
| `tipo` | varchar | Tipo de documento |
| `categoria` | varchar | Categoría asignada |
| `descripcion` | text | Descripción completa |
| `archivo_path` | varchar | Ruta del archivo en storage |
| `archivo_nombre` | varchar | Nombre original del archivo |
| `visible_para_todos` | boolean | Si es visible públicamente |
| `creador_nombre` | varchar | Nombre del creador |
| `fecha_creacion` | datetime | Fecha de creación |
| `fecha_actualizacion` | datetime | Última actualización |
| `tipo_archivo` | varchar | Tipo identificado: 'PDF', 'Word', 'Excel', 'Otro' |

#### Conjunto 2: Resumen de Búsqueda
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total_encontrados` | int | Total de documentos encontrados |
| `oficiales` | int | Documentos oficiales |
| `internos` | int | Documentos internos |
| `comunicados` | int | Comunicados |
| `cartas` | int | Cartas |
| `informes` | int | Informes |
| `publicos` | int | Documentos visibles para todos |
| `categorias_encontradas` | varchar | Lista de categorías separadas por comas |

### Ejemplo de Uso en PHP (Controller)

```php
public function buscarDocumentos(Request $request)
{
    $request->validate([
        'busqueda' => 'nullable|string|max:255',
        'tipo' => 'nullable|in:oficial,interno,comunicado,carta,informe,otro',
        'categoria' => 'nullable|string|max:100',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio'
    ]);

    try {
        $results = DB::select('CALL SP_BusquedaDocumentos(?, ?, ?, ?, ?)', [
            $request->busqueda,
            $request->tipo,
            $request->categoria,
            $request->fecha_inicio,
            $request->fecha_fin
        ]);

        $documentos = [];
        $resumen = null;

        foreach ($results as $row) {
            if (isset($row->total_encontrados)) {
                $resumen = $row;
            } else {
                $documentos[] = $row;
            }
        }

        return response()->json([
            'success' => true,
            'documentos' => $documentos,
            'resumen' => $resumen
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error en la búsqueda: ' . $e->getMessage()
        ], 500);
    }
}
```

### Ejemplo desde Frontend (JavaScript)

```javascript
async function buscarDocumentos() {
    const formData = {
        busqueda: document.getElementById('buscar').value,
        tipo: document.getElementById('filtro_tipo').value || null,
        categoria: document.getElementById('filtro_categoria').value || null,
        fecha_inicio: document.getElementById('fecha_desde').value || null,
        fecha_fin: document.getElementById('fecha_hasta').value || null
    };

    try {
        const response = await fetch('/secretaria/reportes/documentos/buscar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            mostrarResultados(data.documentos);
            actualizarResumen(data.resumen);
        }
        
    } catch (error) {
        console.error('Error:', error);
    }
}

function mostrarResultados(documentos) {
    const container = document.getElementById('resultados');
    container.innerHTML = '';
    
    if (documentos.length === 0) {
        container.innerHTML = '<p class="text-gray-500">No se encontraron documentos</p>';
        return;
    }
    
    documentos.forEach(doc => {
        const iconClass = doc.tipo_archivo === 'PDF' ? 'fa-file-pdf text-red-500' :
                          doc.tipo_archivo === 'Word' ? 'fa-file-word text-blue-500' :
                          doc.tipo_archivo === 'Excel' ? 'fa-file-excel text-green-500' :
                          'fa-file text-gray-500';
        
        const card = `
            <div class="bg-white rounded-lg shadow p-4 mb-3">
                <div class="flex items-start gap-3">
                    <i class="fas ${iconClass} text-2xl"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold">${doc.titulo}</h3>
                        <p class="text-sm text-gray-600">${doc.descripcion || 'Sin descripción'}</p>
                        <div class="flex gap-2 mt-2 text-xs text-gray-500">
                            <span class="badge">${doc.tipo}</span>
                            <span>${doc.categoria}</span>
                            <span>${doc.fecha_creacion}</span>
                        </div>
                    </div>
                    <a href="/storage/${doc.archivo_path}" target="_blank" 
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
        `;
        container.innerHTML += card;
    });
}

function actualizarResumen(resumen) {
    document.getElementById('total-encontrados').textContent = resumen.total_encontrados;
    document.getElementById('oficiales').textContent = resumen.oficiales;
    document.getElementById('internos').textContent = resumen.internos;
    document.getElementById('categorias').textContent = resumen.categorias_encontradas || 'N/A';
}
```

### Ejemplos Directos en MySQL

```sql
-- Búsqueda simple por palabra clave
CALL SP_BusquedaDocumentos('acta', NULL, NULL, NULL, NULL);

-- Búsqueda de documentos oficiales del último mes
CALL SP_BusquedaDocumentos(
    NULL, 
    'oficial', 
    NULL, 
    DATE_SUB(NOW(), INTERVAL 1 MONTH), 
    NOW()
);

-- Búsqueda completa con todos los filtros
CALL SP_BusquedaDocumentos(
    'proyecto', 
    'informe', 
    'Proyectos Sociales', 
    '2025-01-01', 
    '2025-12-31'
);

-- Búsqueda por categoría específica
CALL SP_BusquedaDocumentos(NULL, NULL, 'Actas', NULL, NULL);
```

---

## SP_ResumenActas

### Descripción
Genera un resumen estadístico completo de las actas de reuniones, agrupadas por período y tipo. Incluye métricas agregadas y las actas más recientes.

### Sintaxis SQL
```sql
CALL SP_ResumenActas(anio, mes);
```

### Parámetros

| Parámetro | Tipo | Obligatorio | Descripción |
|-----------|------|-------------|-------------|
| `p_anio` | INT | ❌ No | Año para filtrar (ej: 2025). `NULL` para todos los años |
| `p_mes` | INT | ❌ No | Mes para filtrar (1-12). `NULL` para todos los meses |

**Ejemplos de combinaciones**:
- `(2025, 11)` → Solo noviembre 2025
- `(2025, NULL)` → Todo el año 2025
- `(NULL, 11)` → Todos los noviembres de todos los años
- `(NULL, NULL)` → Todas las actas históricas

### Resultados

#### Conjunto 1: Resumen por Período
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `periodo` | varchar | Período en formato 'YYYY-MM' |
| `mes` | int | Número del mes (1-12) |
| `anio` | int | Año |
| `tipo_reunion` | varchar | Tipo: ordinaria, extraordinaria, junta, asamblea |
| `total_actas` | int | Total de actas en ese período y tipo |
| `dias_con_reunion` | int | Número de días distintos con reuniones |
| `titulos` | text | Lista de títulos separados por ' \| ' |

#### Conjunto 2: Estadísticas Generales
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `total_actas` | int | Total de actas en el período |
| `ordinarias` | int | Actas de reuniones ordinarias |
| `extraordinarias` | int | Actas de reuniones extraordinarias |
| `juntas` | int | Actas de juntas directivas |
| `asambleas` | int | Actas de asambleas |
| `total_dias_reunion` | int | Días distintos con reuniones |
| `primera_reunion` | datetime | Fecha de la primera reunión |
| `ultima_reunion` | datetime | Fecha de la última reunión |
| `promedio_longitud_contenido` | decimal | Promedio de caracteres en el contenido |

#### Conjunto 3: Top 5 Actas Recientes
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID del acta |
| `titulo` | varchar | Título del acta |
| `tipo_reunion` | varchar | Tipo de reunión |
| `fecha_reunion` | date | Fecha de la reunión |
| `asistentes` | text | Lista de asistentes |
| `creador_nombre` | varchar | Nombre del creador |
| `fecha_creacion` | datetime | Fecha de creación del registro |
| `estado_archivo` | varchar | 'Con archivo' o 'Sin archivo' |

### Ejemplo de Uso en PHP (Controller)

```php
public function resumenActas(Request $request)
{
    $request->validate([
        'anio' => 'nullable|integer|min:2020|max:2100',
        'mes' => 'nullable|integer|min:1|max:12'
    ]);

    try {
        $results = DB::select('CALL SP_ResumenActas(?, ?)', [
            $request->anio,
            $request->mes
        ]);

        $resumenPorPeriodo = [];
        $estadisticasGenerales = null;
        $topActas = [];

        $currentSection = 'resumen';
        foreach ($results as $row) {
            if (isset($row->total_actas) && isset($row->promedio_longitud_contenido)) {
                $estadisticasGenerales = $row;
                $currentSection = 'estadisticas';
            } elseif (isset($row->periodo)) {
                $resumenPorPeriodo[] = $row;
            } elseif (isset($row->titulo) && $currentSection === 'estadisticas') {
                $topActas[] = $row;
            }
        }

        return response()->json([
            'success' => true,
            'resumen_por_periodo' => $resumenPorPeriodo,
            'estadisticas_generales' => $estadisticasGenerales,
            'top_actas' => $topActas
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al generar el resumen: ' . $e->getMessage()
        ], 500);
    }
}
```

### Ejemplo desde Frontend (JavaScript)

```javascript
async function generarResumenActas() {
    const anio = document.getElementById('select_anio').value || null;
    const mes = document.getElementById('select_mes').value || null;

    try {
        const response = await fetch('/secretaria/reportes/actas/resumen', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ anio: anio, mes: mes })
        });

        const data = await response.json();

        if (data.success) {
            // Mostrar resumen por período en gráfico
            mostrarGraficoResumen(data.resumen_por_periodo);
            
            // Mostrar estadísticas generales
            mostrarEstadisticas(data.estadisticas_generales);
            
            // Mostrar top actas
            mostrarTopActas(data.top_actas);
        }
        
    } catch (error) {
        console.error('Error:', error);
    }
}

function mostrarEstadisticas(stats) {
    document.getElementById('stat-total').textContent = stats.total_actas;
    document.getElementById('stat-ordinarias').textContent = stats.ordinarias;
    document.getElementById('stat-extraordinarias').textContent = stats.extraordinarias;
    document.getElementById('stat-juntas').textContent = stats.juntas;
    document.getElementById('stat-asambleas').textContent = stats.asambleas;
    document.getElementById('stat-dias').textContent = stats.total_dias_reunion;
    
    if (stats.primera_reunion && stats.ultima_reunion) {
        document.getElementById('periodo-info').textContent = 
            `Del ${formatFecha(stats.primera_reunion)} al ${formatFecha(stats.ultima_reunion)}`;
    }
}

function mostrarGraficoResumen(resumen) {
    // Ejemplo con Chart.js
    const labels = resumen.map(r => `${r.periodo} (${r.tipo_reunion})`);
    const datos = resumen.map(r => r.total_actas);
    
    new Chart(document.getElementById('grafico-actas'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Actas por Período',
                data: datos,
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

function mostrarTopActas(actas) {
    const lista = document.getElementById('lista-top-actas');
    lista.innerHTML = '';
    
    actas.forEach((acta, index) => {
        const item = `
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full 
                            flex items-center justify-center font-bold">
                    ${index + 1}
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">${acta.titulo}</h4>
                    <p class="text-sm text-gray-600">
                        ${acta.tipo_reunion} • ${formatFecha(acta.fecha_reunion)} • 
                        ${acta.creador_nombre}
                    </p>
                </div>
                <span class="badge ${acta.estado_archivo === 'Con archivo' ? 'badge-success' : 'badge-warning'}">
                    ${acta.estado_archivo}
                </span>
            </div>
        `;
        lista.innerHTML += item;
    });
}

function formatFecha(fecha) {
    return new Date(fecha).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}
```

### Ejemplos Directos en MySQL

```sql
-- Resumen del mes actual
CALL SP_ResumenActas(YEAR(NOW()), MONTH(NOW()));

-- Resumen de todo el año 2025
CALL SP_ResumenActas(2025, NULL);

-- Resumen de noviembre de todos los años
CALL SP_ResumenActas(NULL, 11);

-- Resumen histórico completo
CALL SP_ResumenActas(NULL, NULL);

-- Ejemplo con variables
SET @anio_actual = YEAR(NOW());
SET @mes_anterior = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH));
CALL SP_ResumenActas(@anio_actual, @mes_anterior);
```

---

## Integración en Controller

### Patrón Recomendado

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SecretariaController extends Controller
{
    /**
     * Ejecutar stored procedure con manejo de errores
     */
    private function ejecutarSP(string $procedimiento, array $parametros = [])
    {
        try {
            $placeholders = implode(',', array_fill(0, count($parametros), '?'));
            $query = "CALL {$procedimiento}({$placeholders})";
            
            return DB::select($query, $parametros);
            
        } catch (\Exception $e) {
            Log::error("Error en {$procedimiento}: " . $e->getMessage(), [
                'parametros' => $parametros,
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Ejemplo de uso con fallback
     */
    public function dashboard()
    {
        try {
            $results = $this->ejecutarSP('SP_EstadisticasSecretaria');
            
            // Procesar resultados...
            
        } catch (\Exception $e) {
            // Fallback a consultas Eloquent
            $estadisticas = $this->obtenerEstadisticasEloquent();
        }
        
        return view('modulos.secretaria.dashboard', compact('estadisticas'));
    }
    
    /**
     * Fallback sin stored procedures
     */
    private function obtenerEstadisticasEloquent()
    {
        return [
            'consultas_pendientes' => Consulta::where('estado', 'pendiente')->count(),
            'total_actas' => Acta::count(),
            // ... etc
        ];
    }
}
```

---

## Uso desde Frontend

### Template HTML con Formulario de Búsqueda

```html
<!-- Formulario de búsqueda de documentos -->
<div class="card">
    <div class="card-header">
        <h3>Búsqueda Avanzada de Documentos</h3>
    </div>
    <div class="card-body">
        <form id="form-buscar-documentos" onsubmit="event.preventDefault(); buscarDocumentos();">
            <div class="row">
                <div class="col-md-4">
                    <label>Término de búsqueda</label>
                    <input type="text" id="buscar" class="form-control" 
                           placeholder="Buscar en título, descripción...">
                </div>
                
                <div class="col-md-2">
                    <label>Tipo</label>
                    <select id="filtro_tipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="oficial">Oficial</option>
                        <option value="interno">Interno</option>
                        <option value="comunicado">Comunicado</option>
                        <option value="carta">Carta</option>
                        <option value="informe">Informe</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label>Categoría</label>
                    <input type="text" id="filtro_categoria" class="form-control">
                </div>
                
                <div class="col-md-2">
                    <label>Desde</label>
                    <input type="date" id="fecha_desde" class="form-control">
                </div>
                
                <div class="col-md-2">
                    <label>Hasta</label>
                    <input type="date" id="fecha_hasta" class="form-control">
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
                <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Resultados -->
<div class="card mt-4">
    <div class="card-header">
        <h4>Resultados (<span id="total-encontrados">0</span>)</h4>
    </div>
    <div class="card-body">
        <div id="resultados"></div>
    </div>
</div>

<!-- Resumen -->
<div class="card mt-4">
    <div class="card-header">
        <h4>Resumen de Búsqueda</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Oficiales:</strong> <span id="oficiales">0</span>
            </div>
            <div class="col-md-3">
                <strong>Internos:</strong> <span id="internos">0</span>
            </div>
            <div class="col-md-3">
                <strong>Comunicados:</strong> <span id="comunicados">0</span>
            </div>
            <div class="col-md-3">
                <strong>Categorías:</strong> <span id="categorias">-</span>
            </div>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

async function buscarDocumentos() {
    const formData = {
        busqueda: document.getElementById('buscar').value || null,
        tipo: document.getElementById('filtro_tipo').value || null,
        categoria: document.getElementById('filtro_categoria').value || null,
        fecha_inicio: document.getElementById('fecha_desde').value || null,
        fecha_fin: document.getElementById('fecha_hasta').value || null
    };

    try {
        const response = await fetch('/secretaria/reportes/documentos/buscar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            mostrarResultados(data.documentos);
            actualizarResumen(data.resumen);
        } else {
            alert('Error en la búsqueda: ' + data.message);
        }
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al realizar la búsqueda');
    }
}

function limpiarFiltros() {
    document.getElementById('form-buscar-documentos').reset();
    document.getElementById('resultados').innerHTML = '';
    document.getElementById('total-encontrados').textContent = '0';
}
</script>
```

---

## Troubleshooting

### Problema: "SQLSTATE[42000]: Syntax error or access violation: 1305 PROCEDURE does not exist"

**Causa**: El stored procedure no existe en la base de datos.

**Solución**:
```bash
# Re-ejecutar migraciones
php artisan migrate:rollback --step=4
php artisan migrate

# Verificar en MySQL
mysql -u usuario -p base_datos
SHOW PROCEDURE STATUS WHERE Db = 'base_datos';
```

### Problema: "Incorrect number of arguments for PROCEDURE"

**Causa**: Número incorrecto de parámetros al llamar al SP.

**Solución**:
```php
// ❌ Incorrecto
DB::select('CALL SP_ReporteDiplomas(?)', ['2025-01-01']); // Faltan 2 parámetros

// ✅ Correcto
DB::select('CALL SP_ReporteDiplomas(?, ?, ?)', [
    '2025-01-01',
    '2025-12-31',
    null  // Explícitamente pasar null si no hay filtro
]);
```

### Problema: "Results truncated or incomplete"

**Causa**: Laravel puede tener problemas con múltiples result sets.

**Solución**:
```php
// Usar PDO directamente para SPs con múltiples result sets
$pdo = DB::connection()->getPdo();
$stmt = $pdo->prepare('CALL SP_EstadisticasSecretaria()');
$stmt->execute();

$allResults = [];
do {
    $allResults[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
} while ($stmt->nextRowset());

// Ahora $allResults[0] = consultas, $allResults[1] = actas, etc.
```

### Problema: "Stored procedure performance is slow"

**Causa**: Falta de índices en las columnas usadas en WHERE/JOIN.

**Solución**:
```sql
-- Añadir índices en columnas frecuentemente consultadas
ALTER TABLE consultas ADD INDEX idx_estado (estado);
ALTER TABLE actas ADD INDEX idx_fecha_tipo (fecha_reunion, tipo_reunion);
ALTER TABLE diplomas ADD INDEX idx_fecha_tipo (fecha_emision, tipo);
ALTER TABLE documentos ADD INDEX idx_tipo_categoria (tipo, categoria);

-- Analizar y optimizar
ANALYZE TABLE consultas, actas, diplomas, documentos;
```

### Problema: "Cannot call stored procedure from transaction"

**Causa**: Laravel puede abrir transacciones automáticas que interfieren con SPs.

**Solución**:
```php
// Ejecutar fuera de transacción
DB::connection()->unprepared('CALL SP_EstadisticasSecretaria()');

// O deshabilitar transacciones temporalmente
config(['database.connections.mysql.options' => [\PDO::ATTR_EMULATE_PREPARES => true]]);
```

---

## Performance Tips

### 1. Cache de Resultados
```php
use Illuminate\Support\Facades\Cache;

public function dashboard()
{
    $estadisticas = Cache::remember('secretaria.estadisticas', 300, function () {
        return DB::select('CALL SP_EstadisticasSecretaria()');
    });
    
    // ... procesar resultados
}
```

### 2. Lazy Loading de Reportes
```javascript
// Cargar reportes solo cuando se necesiten
document.getElementById('btn-generar-reporte').addEventListener('click', async () => {
    mostrarSpinner();
    try {
        const data = await generarReporteDiplomas();
        mostrarReporte(data);
    } finally {
        ocultarSpinner();
    }
});
```

### 3. Paginación de Resultados
```php
public function buscarDocumentos(Request $request)
{
    // ... ejecutar SP
    
    // Paginar resultados en PHP
    $page = $request->input('page', 1);
    $perPage = 20;
    
    $documentosPaginados = collect($documentos)
        ->forPage($page, $perPage)
        ->values();
    
    return response()->json([
        'documentos' => $documentosPaginados,
        'total' => count($documentos),
        'per_page' => $perPage,
        'current_page' => $page
    ]);
}
```

---

## Conclusión

Los stored procedures del módulo de secretaría proporcionan:
- ⚡ **Mayor velocidad** en consultas complejas
- 🔒 **Seguridad** con parametrización automática
- 📊 **Agregaciones eficientes** de estadísticas
- 🔄 **Reutilización** de lógica de negocio
- 🎯 **Mantenibilidad** centralizada

Para más información, consulta la [documentación principal](./MODULO_SECRETARIA.md).
