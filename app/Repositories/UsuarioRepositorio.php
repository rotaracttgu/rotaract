<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UsuarioRepositorio
{
    /**
     * Obtener usuarios paginados
     */
    public function obtenerUsuariosPaginados(
        int $pagina = 1,
        int $porPagina = 10,
        string $ordenarPor = 'created_at',
        string $direccionOrden = 'desc'
    ): LengthAwarePaginator {
        try {
            // Llamar al procedimiento para obtener usuarios
            $usuarios = DB::select('CALL pa_obtener_usuarios_paginados(?, ?, ?, ?)', [
                $pagina,
                $porPagina,
                $ordenarPor,
                $direccionOrden
            ]);
            
            // Llamar al procedimiento para obtener total
            $resultadoTotal = DB::select('CALL pa_contar_usuarios()');
            $total = $resultadoTotal[0]->total ?? 0;
            
            // Crear paginador manualmente
            return new LengthAwarePaginator(
                $usuarios,
                $total,
                $porPagina,
                $pagina,
                [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Error en obtenerUsuariosPaginados: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Contar total de usuarios
     */
    public function contarUsuarios(): int
    {
        try {
            $resultado = DB::select('CALL pa_contar_usuarios()');
            return $resultado[0]->total ?? 0;
        } catch (\Exception $e) {
            \Log::error('Error en contarUsuarios: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Obtener usuario por ID
     */
    public function obtenerUsuarioPorId(int $usuarioId): ?object
    {
        try {
            $resultado = DB::select('CALL pa_obtener_usuario_por_id(?)', [$usuarioId]);
            return $resultado[0] ?? null;
        } catch (\Exception $e) {
            \Log::error('Error en obtenerUsuarioPorId: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener usuarios activos
     */
    public function obtenerUsuariosActivos(): Collection
    {
        try {
            $usuarios = DB::select('CALL pa_obtener_usuarios_activos()');
            return collect($usuarios);
        } catch (\Exception $e) {
            \Log::error('Error en obtenerUsuariosActivos: ' . $e->getMessage());
            return collect([]);
        }
    }
    
    /**
     * Buscar usuarios
     */
    public function buscarUsuarios(
        string $terminoBusqueda,
        int $pagina = 1,
        int $porPagina = 10
    ): array {
        try {
            // Usar PDO para obtener múltiples result sets
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('CALL pa_buscar_usuarios(?, ?, ?)');
            $stmt->execute([$terminoBusqueda, $pagina, $porPagina]);
            
            // Primer result set: usuarios
            $usuarios = $stmt->fetchAll(\PDO::FETCH_OBJ);
            
            // Segundo result set: total
            $stmt->nextRowset();
            $totalResult = $stmt->fetch(\PDO::FETCH_OBJ);
            $total = $totalResult->total ?? 0;
            
            // Crear paginador
            $usuariosPaginados = new LengthAwarePaginator(
                $usuarios,
                $total,
                $porPagina,
                $pagina,
                [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]
            );
            
            return [
                'usuarios' => $usuariosPaginados,
                'total' => $total
            ];
        } catch (\Exception $e) {
            \Log::error('Error en buscarUsuarios: ' . $e->getMessage());
            return [
                'usuarios' => new LengthAwarePaginator([], 0, $porPagina, $pagina),
                'total' => 0
            ];
        }
    }
    
    /**
     * Obtener estadísticas de usuarios
     */
    public function obtenerEstadisticas(): ?object
    {
        try {
            $resultado = DB::select('CALL pa_estadisticas_usuarios()');
            return $resultado[0] ?? null;
        } catch (\Exception $e) {
            \Log::error('Error en obtenerEstadisticas: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Crear usuario
     */
    public function crearUsuario(string $nombre, string $email, string $password): ?int
    {
        try {
            $resultado = DB::select('CALL pa_crear_usuario(?, ?, ?)', [
                $nombre,
                $email,
                $password
            ]);
            
            return $resultado[0]->id ?? null;
        } catch (\Exception $e) {
            \Log::error('Error en crearUsuario: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Actualizar usuario
     */
    public function actualizarUsuario(int $usuarioId, string $nombre, string $email): bool
    {
        try {
            $resultado = DB::select('CALL pa_actualizar_usuario(?, ?, ?)', [
                $usuarioId,
                $nombre,
                $email
            ]);
            
            $filasAfectadas = $resultado[0]->filas_afectadas ?? 0;
            return $filasAfectadas > 0;
        } catch (\Exception $e) {
            \Log::error('Error en actualizarUsuario: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Eliminar usuario
     */
    public function eliminarUsuario(int $usuarioId): bool
    {
        try {
            $resultado = DB::select('CALL pa_eliminar_usuario(?)', [$usuarioId]);
            $filasAfectadas = $resultado[0]->filas_afectadas ?? 0;
            return $filasAfectadas > 0;
        } catch (\Exception $e) {
            \Log::error('Error en eliminarUsuario: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Método genérico para ejecutar cualquier procedimiento almacenado
     */
    public function ejecutarProcedimiento(string $nombreProcedimiento, array $parametros = []): array
    {
        try {
            $marcadores = implode(',', array_fill(0, count($parametros), '?'));
            $sql = "CALL {$nombreProcedimiento}({$marcadores})";
            
            return DB::select($sql, $parametros);
        } catch (\Exception $e) {
            \Log::error("Error en ejecutarProcedimiento {$nombreProcedimiento}: " . $e->getMessage());
            throw $e;
        }
    }
}