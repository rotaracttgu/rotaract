<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\BackupConfiguracion;
use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        $ultimoBackup = Backup::latest('fecha_ejecucion')->first();
        $configuracion = BackupConfiguracion::first();
        $historial = Backup::with('user')->latest('fecha_ejecucion')->paginate(10);
        
        // Estadísticas
        $estadisticas = [
            'total_backups' => Backup::count(),
            'backups_exitosos' => Backup::where('estado', 'completado')->count(),
            'espacio_usado' => $this->calcularEspacioTotal(),
            'ultimo_automatico' => Backup::where('tipo', 'automatico')->latest('fecha_ejecucion')->first()
        ];
        
        return view('modulos.users.backup.index', compact('ultimoBackup', 'configuracion', 'historial', 'estadisticas'));
    }

    public function ejecutarBackup(Request $request)
    {
        set_time_limit(300); // 5 minutos máximo
        
        try {
            // Crear registro de backup
            $backup = Backup::create([
                'nombre_archivo' => '',
                'tipo' => 'manual',
                'ruta_archivo' => '',
                'estado' => 'en_proceso',
                'descripcion' => $request->descripcion ?? 'Backup manual de base de datos',
                'user_id' => auth()->id(),
                'fecha_ejecucion' => now()
            ]);

            $this->agregarLog($backup->id, 'info', 'Iniciando proceso de backup...');

            // Crear directorio si no existe
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Generar nombre único para el archivo
            $nombreArchivo = 'backup_' . date('Y_m_d_His') . '_' . uniqid() . '.sql';
            $rutaCompleta = $backupPath . DIRECTORY_SEPARATOR . $nombreArchivo;
            
            // Configuración de la base de datos
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);
            
            // Ruta de mysqldump en XAMPP
            $mysqldumpPath = 'mysqldump'; // Por defecto
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows con XAMPP
                $xamppPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
                if (file_exists($xamppPath)) {
                    $mysqldumpPath = '"' . $xamppPath . '"';
                }
            }
            
            // Construir comando
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s --port=%s --single-transaction --routines --triggers --add-drop-table %s > %s 2>&1',
                $mysqldumpPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                $port,
                escapeshellarg($database),
                escapeshellarg($rutaCompleta)
            );
            
            // Ejecutar el comando
            exec($command, $output, $return);
            
            if ($return === 0 && file_exists($rutaCompleta) && filesize($rutaCompleta) > 0) {
                $tamaño = $this->formatearTamaño(filesize($rutaCompleta));
                
                $backup->update([
                    'nombre_archivo' => $nombreArchivo,
                    'ruta_archivo' => 'backups/' . $nombreArchivo,
                    'tamaño' => $tamaño,
                    'estado' => 'completado'
                ]);
                
                $this->agregarLog($backup->id, 'info', 'Backup completado exitosamente. Tamaño: ' . $tamaño);
                
                // Registrar en bitácora si existe
                if (class_exists('App\Services\BitacoraService')) {
                    app('App\Services\BitacoraService')->registrar(
                        'create',
                        'backup',
                        'backups',
                        $backup->id,
                        'Backup manual ejecutado exitosamente'
                    );
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Backup ejecutado exitosamente',
                    'data' => $backup->fresh()
                ]);
            } else {
                throw new \Exception('Error al generar el archivo de backup. Código de salida: ' . $return);
            }
            
        } catch (\Exception $e) {
            if (isset($backup)) {
                $backup->update([
                    'estado' => 'fallido',
                    'error_mensaje' => $e->getMessage()
                ]);
                
                $this->agregarLog($backup->id, 'error', 'Error: ' . $e->getMessage());
            }
            
            Log::error('Error en backup: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al ejecutar el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restaurar($id)
    {
        set_time_limit(300); // 5 minutos máximo
        
        try {
            $backup = Backup::findOrFail($id);
            
            // Verificar que el archivo existe
            $rutaCompleta = storage_path('app/' . $backup->ruta_archivo);
            if (!file_exists($rutaCompleta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo de backup no existe'
                ], 404);
            }
            
            // Registrar en bitácora
            $this->agregarLog($backup->id, 'info', 'Iniciando restauración de base de datos...');
            
            // Configuración de la base de datos
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);
            
            // Ruta de mysql en XAMPP
            $mysqlPath = 'mysql'; // Por defecto
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows con XAMPP
                $xamppPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';
                if (file_exists($xamppPath)) {
                    $mysqlPath = '"' . $xamppPath . '"';
                }
            }
            
            // Construir comando para restaurar
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s --port=%s %s < %s 2>&1',
                $mysqlPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                $port,
                escapeshellarg($database),
                escapeshellarg($rutaCompleta)
            );
            
            // Ejecutar el comando
            exec($command, $output, $return);
            
            if ($return === 0) {
                $this->agregarLog($backup->id, 'info', 'Base de datos restaurada exitosamente');
                
                // Registrar en bitácora del sistema si existe
                if (class_exists('App\Services\BitacoraService')) {
                    app('App\Services\BitacoraService')->registrar(
                        'restore',
                        'backup',
                        'backups',
                        $backup->id,
                        'Base de datos restaurada desde: ' . $backup->nombre_archivo
                    );
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Base de datos restaurada exitosamente',
                    'data' => $backup
                ]);
            } else {
                throw new \Exception('Error al ejecutar la restauración. Código de salida: ' . $return . '. Output: ' . implode("\n", $output));
            }
            
        } catch (\Exception $e) {
            if (isset($backup)) {
                $this->agregarLog($backup->id, 'error', 'Error en restauración: ' . $e->getMessage());
            }
            
            Log::error('Error en restauración de backup: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al restaurar el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarConfiguracion(Request $request)
    {
        $request->validate([
            'frecuencia' => 'required|in:diario,semanal,mensual',
            'hora_programada' => 'required|date_format:H:i',
            'dias_semana' => 'nullable|string',
            'dia_mes' => 'nullable|integer|min:1|max:31'
        ]);

        $configuracion = BackupConfiguracion::firstOrNew();
        
        $configuracion->fill([
            'frecuencia' => $request->frecuencia,
            'hora_programada' => $request->hora_programada,
            'activo' => $request->has('activo'),
            'dias_semana' => $request->dias_semana,
            'dia_mes' => $request->dia_mes,
            'proxima_ejecucion' => $this->calcularProximaEjecucion($request)
        ]);
        
        $configuracion->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración guardada exitosamente',
            'data' => $configuracion
        ]);
    }

    public function descargar($id)
    {
        $backup = Backup::findOrFail($id);
        $rutaCompleta = storage_path('app/' . $backup->ruta_archivo);
        
        if (file_exists($rutaCompleta)) {
            return response()->download($rutaCompleta, $backup->nombre_archivo);
        }
        
        return back()->with('error', 'Archivo de backup no encontrado');
    }

    public function eliminar($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $rutaCompleta = storage_path('app/' . $backup->ruta_archivo);
            
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
            
            $backup->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Backup eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el backup: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para backup automático
    public function ejecutarBackupAutomatico()
    {
        try {
            $backup = Backup::create([
                'nombre_archivo' => '',
                'tipo' => 'automatico',
                'ruta_archivo' => '',
                'estado' => 'en_proceso',
                'descripcion' => 'Backup automático programado',
                'user_id' => null,
                'fecha_ejecucion' => now()
            ]);

            // Mismo proceso que el backup manual...
            // (copiar el código del método ejecutarBackup)
            
            // Actualizar última ejecución
            $configuracion = BackupConfiguracion::first();
            if ($configuracion) {
                $configuracion->update([
                    'ultima_ejecucion' => now(),
                    'proxima_ejecucion' => $this->calcularProximaEjecucion($configuracion)
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error en backup automático: ' . $e->getMessage());
        }
    }

    private function formatearTamaño($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    private function calcularEspacioTotal()
    {
        $backupsCompletados = Backup::where('estado', 'completado')->get();
        $totalBytes = 0;
        
        foreach ($backupsCompletados as $backup) {
            $rutaCompleta = storage_path('app/' . $backup->ruta_archivo);
            if (file_exists($rutaCompleta)) {
                $totalBytes += filesize($rutaCompleta);
            }
        }
        
        return $this->formatearTamaño($totalBytes);
    }

    private function agregarLog($backupId, $tipoLog, $mensaje)
    {
        BackupLog::create([
            'backup_id' => $backupId,
            'tipo_log' => $tipoLog,
            'mensaje' => $mensaje,
            'fecha_log' => now()
        ]);
    }

    private function calcularProximaEjecucion($config)
    {
        $hora = Carbon::parse($config->hora_programada ?? $config['hora_programada']);
        $ahora = Carbon::now();
        
        switch($config->frecuencia ?? $config['frecuencia']) {
            case 'diario':
                $proxima = $ahora->copy()->setTimeFromTimeString($hora->format('H:i'));
                if ($proxima->isPast()) {
                    $proxima->addDay();
                }
                break;
                
            case 'semanal':
                $proxima = $ahora->copy()->next(Carbon::MONDAY)->setTimeFromTimeString($hora->format('H:i'));
                break;
                
            case 'mensual':
                $dia = $config->dia_mes ?? $config['dia_mes'] ?? 1;
                $proxima = $ahora->copy()->day($dia)->setTimeFromTimeString($hora->format('H:i'));
                if ($proxima->isPast()) {
                    $proxima->addMonth();
                }
                break;
                
            default:
                $proxima = null;
        }
        
        return $proxima;
    }
}