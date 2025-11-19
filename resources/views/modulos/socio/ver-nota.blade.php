@extends('modulos.socio.layout')

@section('page-title', $nota->Titulo)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.notas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Notas
        </a>
        <div class="mt-3 rounded-xl p-6 shadow-lg border-2 
            {{ $nota->Categoria === 'proyecto' ? 'bg-gradient-to-r from-blue-500 to-blue-600 border-blue-400 text-white' : '' }}
            {{ $nota->Categoria === 'reunion' ? 'bg-gradient-to-r from-green-500 to-green-600 border-green-400 text-white' : '' }}
            {{ $nota->Categoria === 'capacitacion' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 border-yellow-400 text-white' : '' }}
            {{ $nota->Categoria === 'idea' ? 'bg-gradient-to-r from-purple-500 to-purple-600 border-purple-400 text-white' : '' }}
            {{ $nota->Categoria === 'personal' ? 'bg-gradient-to-r from-pink-500 to-pink-600 border-pink-400 text-white' : '' }}">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-4 py-1 text-sm font-bold rounded-full bg-white bg-opacity-30 backdrop-blur">
                            {{ ucfirst($nota->Categoria) }}
                        </span>
                        @if($nota->Visibilidad === 'publica')
                            <span class="px-4 py-1 text-sm font-semibold rounded-full bg-white bg-opacity-30 backdrop-blur">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pública
                            </span>
                        @else
                            <span class="px-4 py-1 text-sm font-semibold rounded-full bg-white bg-opacity-30 backdrop-blur">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Privada
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold">
                        {{ $nota->Titulo }}
                    </h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('socio.notas.editar', $nota->NotaID) }}" 
                       class="px-6 py-3 bg-white bg-opacity-30 backdrop-blur text-white rounded-lg hover:bg-opacity-40 transition-colors shadow-md hover:shadow-lg font-semibold">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('socio.notas.eliminar', $nota->NotaID) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta nota?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Creada</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($nota->FechaCreacion)->format('d/m/Y') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($nota->FechaCreacion)->format('H:i') }}
                    </p>
                </div>
            </div>
        </div>

        @if($nota->FechaActualizacion)
            <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Actualizada</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($nota->FechaActualizacion)->format('d/m/Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($nota->FechaActualizacion)->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Hace</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($nota->FechaCreacion)->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-orange-500">
            <div class="flex items-center">
                <div class="bg-orange-100 p-3 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Caracteres</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ number_format(strlen($nota->Contenido)) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                Contenido de la Nota
            </h2>
        </div>
        <div class="p-8">
            <div class="prose prose-lg max-w-none">
                <div class="text-gray-800 whitespace-pre-wrap leading-relaxed" style="font-family: 'Georgia', serif;">{{ $nota->Contenido }}</div>
            </div>
        </div>
    </div>

    <!-- Etiquetas -->
    @if($nota->Etiquetas)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    Etiquetas
                </h2>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    @foreach(explode(',', $nota->Etiquetas) as $etiqueta)
                        <span class="px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 font-semibold rounded-full text-sm border-2 border-purple-200">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ trim($etiqueta) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Acciones Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Compartir -->
        <button onclick="copiarEnlace()" 
                class="flex items-center justify-center px-6 py-4 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-blue-100 transition-colors group">
            <svg class="w-6 h-6 text-blue-600 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
            </svg>
            <div class="text-left">
                <p class="font-bold text-gray-900">Compartir Enlace</p>
                <p class="text-xs text-gray-600">Copiar URL de esta nota</p>
            </div>
        </button>

        <!-- Imprimir -->
        <button onclick="window.print()" 
                class="flex items-center justify-center px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl hover:bg-gray-100 transition-colors group">
            <svg class="w-6 h-6 text-gray-600 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            <div class="text-left">
                <p class="font-bold text-gray-900">Imprimir</p>
                <p class="text-xs text-gray-600">Versión para imprimir</p>
            </div>
        </button>

        <!-- Exportar -->
        <button onclick="exportarTexto()" 
                class="flex items-center justify-center px-6 py-4 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-green-100 transition-colors group">
            <svg class="w-6 h-6 text-green-600 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <div class="text-left">
                <p class="font-bold text-gray-900">Exportar .txt</p>
                <p class="text-xs text-gray-600">Descargar como texto</p>
            </div>
        </button>
    </div>

    <!-- Información Adicional -->
    <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-purple-900 mb-2">Información de la Nota</h4>
                <ul class="text-sm text-purple-800 space-y-1">
                    <li>• <strong>ID:</strong> #{{ $nota->NotaID }}</li>
                    <li>• <strong>Estado:</strong> {{ ucfirst($nota->Estado) }}</li>
                    <li>• <strong>Autor:</strong> {{ $nota->NombreAutor ?? 'Tú' }}</li>
                    @if($nota->Visibilidad === 'publica')
                        <li>• Esta nota es visible para todos los miembros del club</li>
                    @else
                        <li>• Esta nota es privada, solo tú puedes verla</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function copiarEnlace() {
        const url = window.location.href;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                mostrarNotificacion('Enlace copiado al portapapeles', 'success');
            }, function() {
                mostrarNotificacion('No se pudo copiar el enlace', 'error');
            });
        } else {
            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            mostrarNotificacion('Enlace copiado al portapapeles', 'success');
        }
    }

    function exportarTexto() {
        const titulo = '{{ $nota->Titulo }}';
        const contenido = `{{ str_replace(["\r\n", "\n", "\r"], "\\n", addslashes($nota->Contenido)) }}`;
        const categoria = '{{ $nota->Categoria }}';
        const fecha = '{{ \Carbon\Carbon::parse($nota->FechaCreacion)->format("d/m/Y H:i") }}';
        
        const texto = `${titulo}\n${'='.repeat(titulo.length)}\n\n` +
                     `Categoría: ${categoria}\n` +
                     `Fecha: ${fecha}\n\n` +
                     `${contenido}\n`;
        
        const blob = new Blob([texto], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${titulo.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        mostrarNotificacion('Nota exportada correctamente', 'success');
    }

    function mostrarNotificacion(mensaje, tipo) {
        const div = document.createElement('div');
        div.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold animate-fade-in ${
            tipo === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;
        div.innerHTML = `
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${tipo === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                }
            </svg>
            ${mensaje}
        `;
        document.body.appendChild(div);
        
        setTimeout(() => {
            div.remove();
        }, 3000);
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    @media print {
        nav, header, .fixed, button, a[href*="editar"], a[href*="eliminar"], .bg-purple-50 {
            display: none !important;
        }
    }
</style>
@endpush