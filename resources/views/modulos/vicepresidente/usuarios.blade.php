@extends('modulos.vicepresidente.layout')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Gestión de Usuarios
                </h1>
                <p class="text-blue-100 mt-2">Administra los usuarios del sistema</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                    <span class="text-yellow-300 font-bold text-lg">{{ $totalUsuarios ?? 0 }}</span>
                    <span class="text-sm ml-1">{{ $totalUsuarios === 1 ? 'usuario' : 'usuarios' }}</span>
                </div>
                <a href="{{ route('vicepresidente.usuarios.crear') }}" 
                    class="inline-flex items-center px-5 py-2.5 bg-white text-blue-600 rounded-lg hover:bg-blue-50 font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Nuevo Usuario
                </a>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 p-4 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-white font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Filtros y búsqueda -->
        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex-1 max-w-lg">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                            id="search" 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Buscar por nombre, email o usuario..." 
                            onkeyup="buscarUsuario()">
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <select id="filterRole" 
                        class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg" 
                        onchange="filtrarPorRol()">
                        <option value="">Todos los roles</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Presidente">Presidente</option>
                        <option value="Vicepresidente">Vicepresidente</option>
                        <option value="Secretario">Secretario</option>
                        <option value="Tesorero">Tesorero</option>
                        <option value="Vocero">Vocero</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Información de Contacto
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="usuariosTable">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($usuario->name, 0, 1)) }}{{ strtoupper(substr($usuario->apellidos ?? '', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $usuario->name }} {{ $usuario->apellidos }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $usuario->email }}</div>
                                <div class="text-sm text-gray-500">{{ $usuario->telefono ?? 'Sin teléfono' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $roleColors = [
                                        'Super Admin' => 'from-red-500 to-pink-600',
                                        'Presidente' => 'from-purple-500 to-indigo-600',
                                        'Vicepresidente' => 'from-blue-500 to-cyan-600',
                                        'Secretario' => 'from-green-500 to-emerald-600',
                                        'Tesorero' => 'from-yellow-500 to-orange-600',
                                        'Vocero' => 'from-pink-500 to-rose-600'
                                    ];
                                    $roleName = $usuario->roles->first()->name ?? 'Sin rol';
                                    $colorClass = $roleColors[$roleName] ?? 'from-gray-500 to-gray-600';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r {{ $colorClass }} text-white">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($usuario->email_verified_at)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('vicepresidente.usuarios.ver', $usuario->id) }}" 
                                        class="text-blue-600 hover:text-blue-900" 
                                        title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('vicepresidente.usuarios.editar', $usuario->id) }}" 
                                        class="text-indigo-600 hover:text-indigo-900" 
                                        title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('vicepresidente.usuarios.eliminar', $usuario->id) }}" 
                                        method="POST" 
                                        class="inline-block"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay usuarios registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($usuarios->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>

    <script>
        function buscarUsuario() {
            const input = document.getElementById('search');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('usuariosTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let txtValue = '';
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue += td[j].textContent || td[j].innerText;
                    }
                }
                
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }

        function filtrarPorRol() {
            const select = document.getElementById('filterRole');
            const filter = select.value.toUpperCase();
            const table = document.getElementById('usuariosTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[2]; // Columna de rol
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (filter === '' || txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
@endsection
