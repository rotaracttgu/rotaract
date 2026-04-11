@extends('layouts.app-admin')

@push('styles')
<style>
    .admin-soporte-shell {
        background: radial-gradient(circle at 85% 5%, rgba(56, 189, 248, 0.18), transparent 34%),
                    radial-gradient(circle at 10% 80%, rgba(99, 102, 241, 0.2), transparent 35%);
        border-radius: 1rem;
        padding: 0.65rem;
    }

    .stats-card {
        border-radius: 0.85rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(15, 23, 42, 0.1);
    }

    .stats-open {
        border: 1px solid #fcd34d;
        background: linear-gradient(145deg, #fff7d6, #ffecb2);
    }

    .stats-progress {
        border: 1px solid #93c5fd;
        background: linear-gradient(145deg, #e8f2ff, #dbeafe);
    }

    .stats-solved {
        border: 1px solid #86efac;
        background: linear-gradient(145deg, #ecfdf3, #dcfce7);
    }

    .stats-closed {
        border: 1px solid #cbd5e1;
        background: linear-gradient(145deg, #f8fafc, #e2e8f0);
    }

    .stats-unread {
        border: 1px solid #fca5a5;
        background: linear-gradient(145deg, #fff1f2, #ffe4e6);
    }

    .tickets-panel {
        border: 1px solid rgba(147, 197, 253, 0.45);
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.95), rgba(255, 255, 255, 0.97));
        backdrop-filter: blur(3px);
    }

    .tickets-panel-header {
        background: linear-gradient(90deg, rgba(219, 234, 254, 0.75), rgba(224, 231, 255, 0.6));
    }

    .tickets-filter-select {
        background: rgba(255, 255, 255, 0.9);
        border-color: #93c5fd;
    }

    .tickets-filter-btn {
        background: linear-gradient(90deg, #334155, #1e3a8a);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .tickets-filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(30, 58, 138, 0.22);
    }

    .ticket-row {
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .ticket-row:hover {
        transform: translateY(-2px);
    }

    .status-chip {
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.28rem 0.8rem;
    }

    .status-chip-abierto { background: #fef3c7; color: #b45309; }
    .status-chip-en_proceso { background: #dbeafe; color: #1d4ed8; }
    .status-chip-resuelto { background: #dcfce7; color: #15803d; }
    .status-chip-cerrado { background: #e5e7eb; color: #374151; }

    .unread-badge {
        animation: badge-pulse 1.6s ease-in-out infinite;
    }

    @keyframes badge-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
</style>
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto admin-soporte-shell">
        <div class="bg-gradient-to-r from-slate-800 via-slate-900 to-indigo-900 rounded-xl p-6 text-white shadow-lg mb-6">
            <h1 class="text-2xl font-bold">Bandeja de soporte</h1>
            <p class="text-slate-200 mt-1">Solo Admin y Super Admin responden consultas.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="stats-card stats-open p-4 shadow-sm"><p class="text-xs text-amber-800/80">Abiertos</p><p class="text-2xl font-bold text-amber-700">{{ $stats['abiertos'] }}</p></div>
            <div class="stats-card stats-progress p-4 shadow-sm"><p class="text-xs text-blue-800/80">En proceso</p><p class="text-2xl font-bold text-blue-700">{{ $stats['en_proceso'] }}</p></div>
            <div class="stats-card stats-solved p-4 shadow-sm"><p class="text-xs text-emerald-800/80">Resueltos</p><p class="text-2xl font-bold text-emerald-700">{{ $stats['resueltos'] }}</p></div>
            <div class="stats-card stats-closed p-4 shadow-sm"><p class="text-xs text-slate-700/80">Cerrados</p><p class="text-2xl font-bold text-slate-700">{{ $stats['cerrados'] }}</p></div>
            <div class="stats-card stats-unread p-4 shadow-sm"><p class="text-xs text-red-700/80">Sin leer</p><p class="text-2xl font-bold text-red-700">{{ $stats['sin_leer'] }}</p></div>
        </div>

        <div class="tickets-panel rounded-xl shadow overflow-hidden">
            <div class="tickets-panel-header px-6 py-4 border-b border-blue-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Tickets</h2>
                <form method="GET" class="flex items-center gap-2">
                    <select name="status" class="tickets-filter-select rounded-lg text-sm">
                        <option value="">Todos</option>
                        <option value="abierto" {{ $status === 'abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="en_proceso" {{ $status === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="resuelto" {{ $status === 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                        <option value="cerrado" {{ $status === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                    <button class="tickets-filter-btn px-3 py-2 text-white rounded-lg text-sm">Filtrar</button>
                </form>
            </div>

            @if($tickets->isEmpty())
                <div class="px-6 py-10 text-center text-gray-500">No hay tickets para mostrar.</div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($tickets as $ticket)
                        <a href="{{ route('admin.soporte.show', $ticket->id) }}" class="ticket-row block px-6 py-4 hover:bg-blue-50/40 transition-colors">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900">#{{ $ticket->id }} - {{ $ticket->subject }}</p>
                                    <p class="text-sm text-gray-500">{{ $ticket->user->username ?? $ticket->user->name }} - {{ $ticket->updated_at?->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="status-chip status-chip-{{ $ticket->status }}">
                                        {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                    </span>
                                    @if($ticket->unread_user_messages_count > 0)
                                        <span class="unread-badge px-2 py-1 bg-red-600 text-white rounded-full text-xs font-bold">{{ $ticket->unread_user_messages_count }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="px-6 py-4 border-t border-blue-100">{{ $tickets->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
