@extends('modulos.socio.layout')

@section('page-title', $nota->Titulo)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.notas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Notas
        </a>
        <div class="mt-3 bg-gradient-to-r 
            {{ $nota->Categoria === 'proyecto' ? 'from-blue-50 to-blue-100' : '' }}
            {{ $nota->Categoria === 'reunion' ? 'from-green-50 to-green-100' : '' }}
            {{ $nota->Categoria === 'capacitacion' ? 'from-yellow-50 to-yellow-100' : '' }}
            {{ $nota->Categoria === 'idea' ? 'from-purple-50 to-purple-100' : '' }}
            {{ $nota->Categoria === 'personal' ? 'from-pink-50 to-pink-100' : '' }}
            rounded-lg p-6 border-2 
            {{ $nota->Categoria === 'proyecto' ? 'border-blue-200' : '' }}
            {{ $nota->Categoria === 'reunion' ? 'border-green-200' : '' }}
            {{ $nota->Categoria === 'capacitacion' ? 'border-yellow-200' : '' }}
            {{ $nota->Categoria === 'idea' ? 'border-purple-200' : '' }}
            {{ $nota->Categoria === 'personal' ? 'border-pink-200' : '' }}">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-4 py-1 text-sm font-bold rounded-full
                            {{ $nota->Categoria === 'proyecto' ? 'bg-blue-500 text-white' : '' }}
                            {{ $nota->Categoria === 'reunion' ? 'bg-green-500 text-white' : '' }}
                            {{ $nota->Categoria === 'capacitacion' ? 'bg-yellow-500 text-white' : '' }}
                            {{ $nota->Categoria === 'idea' ? 'bg-purple-500 text-white' : '' }}
                            {{ $nota->Categoria === 'personal' ? 'bg-pink-500 text-white' : '' }}">
                            {{ ucfirst($nota->Categoria) }}
                        </span>
                        @if($nota->Visibilidad === 'publica')
                            <span class="px-4 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-globe mr-1"></i>Pública
                            </span>
                        @else
                            <span class="px-4 py-1 bg-gray-100 text-gray-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-lock mr-1"></i>Privada
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $nota->Titulo }}
                    </h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('socio.notas.editar', $nota->NotaID) }}" 
                       class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    <form action="{{ route('socio.notas.eliminar', $nota->NotaID) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta nota?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-calendar-plus text-blue-600 text-xl"></i>
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
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-3">
                        <i class="fas fa-sync text-green-600 text-xl"></i>
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

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Hace</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($nota->FechaCreacion)->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-orange-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-align-left text-orange-600 text-xl"></i>
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
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-alt text-purple-500 mr-3"></i>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tags text-orange-500 mr-3"></i>
                    Etiquetas
                </h2>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    @foreach(explode(',', $nota->Etiquetas) as $etiqueta)
                        <span class="px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 font-semibold rounded-full text-sm border-2 border-purple-200">
                            <i class="fas fa-tag mr-1"></i>
                            {{ trim($etiqueta) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Acciones Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Compartir -->
        <button onclick="copiarEnlace()" 
                class="flex items-center justify-center px-6 py-4 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-blue-100 transition-colors group">
            <i class="fas fa-share-alt text-blue-600 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
            <div class="text-left">
                <p class="font-bold text-gray-900">Compartir Enlace</p>
                <p class="text-xs text-gray-600">Copiar URL de esta nota</p>
            </div>
        </button>

        <!-- Imprimir -->
        <button onclick="window.print()" 
                class="flex items-center justify-center px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl hover:bg-gray-100 transition-colors group">
            <i class="fas fa-print text-gray-600 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
            <div class="text-left">
                <p class="font-bold text-gray-900">Imprimir</p>
                <p class="text-xs text-gray-600">Versión para imprimir</p>
            </div>
        </button>

        <!-- Exportar -->
        <button onclick="exportarTexto()" 
                class="flex items-center justify-center px-6 py-4 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-green-100 transition-colors group">
            <i class="fas fa-download text-green-600 text-2xl mr-3 group-hover:scale-110 transition-transform"></i>
            <div class="text-left">
                <p class="font-bold text-gray-900">Exportar .txt</p>
                <p class="text-xs text-gray-600">Descargar como texto</p>
            </div>
        </button>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-purple-600 text-2xl mr-4 mt-1"></i>
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
    // Copiar enlace de la nota
    function copiarEnlace() {
        const url = window.location.href;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                mostrarNotificacion('Enlace copiado al portapapeles', 'success');
            }, function() {
                mostrarNotificacion('No se pudo copiar el enlace', 'error');
            });
        } else {
            // Fallback para navegadores antiguos
            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            mostrarNotificacion('Enlace copiado al portapapeles', 'success');
        }
    }

    // Exportar nota como texto
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

    // Mostrar notificación
    function mostrarNotificacion(mensaje, tipo) {
        const div = document.createElement('div');
        div.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold animate-fade-in ${
            tipo === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;
        div.innerHTML = `
            <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
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