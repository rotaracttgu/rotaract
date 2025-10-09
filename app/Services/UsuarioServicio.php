<?php

namespace App\Services;

use App\Repositories\UsuarioRepositorio;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UsuarioServicio
{
    protected $usuarioRepositorio;
    
    public function __construct(UsuarioRepositorio $usuarioRepositorio)
    {
        $this->usuarioRepositorio = $usuarioRepositorio;
    }
    
    /**
     * Obtener usuarios con paginación
     */
    public function obtenerUsuariosPaginados(array $opciones = []): LengthAwarePaginator
    {
        $pagina = $opciones['pagina'] ?? request()->get('page', 1);
        $porPagina = $opciones['por_pagina'] ?? 10;
        $ordenarPor = $opciones['ordenar_por'] ?? 'created_at';
        $direccionOrden = $opciones['direccion_orden'] ?? 'desc';
        
        return $this->usuarioRepositorio->obtenerUsuariosPaginados(
            $pagina,
            $porPagina,
            $ordenarPor,
            $direccionOrden
        );
    }
    
    /**
     * Obtener total de usuarios
     */
    public function contarUsuarios(): int
    {
        return $this->usuarioRepositorio->contarUsuarios();
    }
    
    /**
     * Obtener usuario específico
     */
    public function obtenerUsuario(int $usuarioId): ?object
    {
        return $this->usuarioRepositorio->obtenerUsuarioPorId($usuarioId);
    }
    
    /**
     * Buscar usuarios
     */
    public function buscarUsuarios(string $termino, array $opciones = []): array
    {
        $pagina = $opciones['pagina'] ?? request()->get('page', 1);
        $porPagina = $opciones['por_pagina'] ?? 10;
        
        return $this->usuarioRepositorio->buscarUsuarios($termino, $pagina, $porPagina);
    }
    
    /**
     * Obtener estadísticas
     */
    public function obtenerEstadisticas(): ?object
    {
        return $this->usuarioRepositorio->obtenerEstadisticas();
    }
    
    /**
     * Crear nuevo usuario
     */
    public function crearUsuario(array $datos): ?int
    {
        $passwordHasheado = Hash::make($datos['password']);
        
        return $this->usuarioRepositorio->crearUsuario(
            $datos['name'],
            $datos['email'],
            $passwordHasheado
        );
    }
    
    /**
     * Actualizar usuario
     */
    public function actualizarUsuario(int $usuarioId, array $datos): bool
    {
        return $this->usuarioRepositorio->actualizarUsuario(
            $usuarioId,
            $datos['name'],
            $datos['email']
        );
    }
    
    /**
     * Eliminar usuario
     */
    public function eliminarUsuario(int $usuarioId): bool
    {
        return $this->usuarioRepositorio->eliminarUsuario($usuarioId);
    }
}