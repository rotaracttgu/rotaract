@extends($layout)

@section('page-title', 'Soporte')

@push('styles')
<style>
    .soporte-shell {
        background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.12), transparent 40%),
                    radial-gradient(circle at left bottom, rgba(99, 102, 241, 0.12), transparent 38%);
        border-radius: 1rem;
    }

    .soporte-hero {
        position: relative;
        overflow: hidden;
    }

    .soporte-hero::after {
        content: '';
        position: absolute;
        width: 190px;
        height: 190px;
        border-radius: 9999px;
        right: -55px;
        top: -85px;
        background: rgba(255, 255, 255, 0.18);
        pointer-events: none;
    }

    .ticket-row {
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .ticket-row:hover {
        transform: translateY(-2px);
    }

    .tickets-panel {
        border: 1px solid rgba(147, 197, 253, 0.45);
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.95), rgba(255, 255, 255, 0.97));
        backdrop-filter: blur(2px);
    }

    .tickets-panel-header {
        background: linear-gradient(90deg, rgba(219, 234, 254, 0.75), rgba(224, 231, 255, 0.55));
    }

    .status-chip {
        border-radius: 9999px;
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 700;
        padding: 0.3rem 0.8rem;
    }

    .status-chip-abierto {
        background: #fef3c7;
        color: #b45309;
    }

    .status-chip-en_proceso {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-chip-resuelto {
        background: #dcfce7;
        color: #15803d;
    }

    .status-chip-cerrado {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-alert {
        animation: pulse-soft 1.8s ease-in-out infinite;
    }

    @keyframes pulse-soft {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto py-6 suporte-shell px-2 md:px-4">
    <div class="soporte-hero bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500 rounded-xl p-6 text-white shadow-lg mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Soporte</h1>
                <p class="text-indigo-100 mt-1">Tiempo objetivo de respuesta: 24 horas.</p>
            </div>
            <a href="{{ route($routePrefix.'.soporte.create') }}" class="inline-flex items-center px-4 py-2 bg-white/95 text-indigo-700 rounded-lg font-semibold hover:bg-white transition-all hover:-translate-y-0.5 shadow">
                Nueva consulta
            </a>
        </div>
    </div>

    <div class="tickets-panel rounded-xl shadow overflow-hidden">
        <div class="tickets-panel-header px-6 py-4 border-b border-blue-100">
            <h2 class="font-semibold text-gray-900">Mis tickets</h2>
        </div>

        @if($tickets->isEmpty())
            <div class="px-6 py-10 text-center text-gray-500">
                Aun no tienes tickets de soporte.
            </div>
        @else
            <div class="divide-y divide-blue-100">
                @foreach($tickets as $ticket)
                    <a href="{{ route($routePrefix.'.soporte.show', $ticket->id) }}" class="ticket-row block px-6 py-4 hover:bg-blue-50/40">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-900">#{{ $ticket->id }} - {{ $ticket->subject }}</p>
                                <p class="text-sm text-gray-500 mt-1">Actualizado: {{ $ticket->updated_at?->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="status-chip status-chip-{{ $ticket->status }}">
                                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                </span>
                                @if($ticket->unread_admin_messages_count > 0)
                                    <span class="badge-alert px-2 py-1 bg-red-600 text-white rounded-full text-xs font-bold">
                                        {{ $ticket->unread_admin_messages_count }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-blue-100">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
