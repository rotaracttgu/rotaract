@extends('layouts.app-admin')

@push('styles')
<style>
    .admin-chat-shell {
        background: radial-gradient(circle at 12% 10%, rgba(37, 99, 235, 0.14), transparent 36%),
                    radial-gradient(circle at 90% 85%, rgba(14, 165, 233, 0.12), transparent 35%);
        border-radius: 1rem;
        padding: 0.7rem;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.22rem 0.72rem;
    }

    .status-chip-abierto { background: #fef3c7; color: #92400e; }
    .status-chip-en_proceso { background: #dbeafe; color: #1d4ed8; }
    .status-chip-resuelto { background: #dcfce7; color: #166534; }
    .status-chip-cerrado { background: #e5e7eb; color: #374151; }

    .message-item {
        animation: msg-enter 0.35s ease;
    }

    @keyframes msg-enter {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto admin-chat-shell">
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h1>
                    <p class="text-sm text-gray-500">
                        Usuario: {{ $ticket->user->username ?? $ticket->user->name }}
                        <span id="ticket-status" class="ml-2 status-chip status-chip-{{ $ticket->status }}">{{ str_replace('_', ' ', ucfirst($ticket->status)) }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('admin.soporte.status', $ticket->id) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded-lg border-gray-300 text-sm">
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                            @endforeach
                        </select>
                        <button class="px-3 py-2 bg-slate-700 text-white rounded-lg text-sm">Actualizar</button>
                    </form>
                    <a href="{{ route('admin.soporte.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Volver</a>
                </div>
            </div>

            <div id="messages-box" class="p-6 space-y-4 max-h-[30rem] overflow-y-auto" data-last-id="{{ $ticket->mensajes->max('id') ?? 0 }}">
                @foreach($ticket->mensajes as $msg)
                    <div class="message-item {{ $msg->is_admin ? 'bg-indigo-50 border-indigo-200' : 'bg-amber-50 border-amber-200' }} border rounded-lg px-4 py-3 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-semibold {{ $msg->is_admin ? 'text-indigo-700' : 'text-amber-700' }}">
                                {{ $msg->sender->username ?? $msg->sender->name }}
                                @if($msg->is_admin)
                                    <span class="text-xs font-normal text-indigo-500">(Soporte)</span>
                                @else
                                    <span class="text-xs font-normal text-amber-600">(Usuario)</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">{{ $msg->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $msg->message }}</p>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <form method="POST" action="{{ route('admin.soporte.reply', $ticket->id) }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <textarea name="message" rows="4" required class="md:col-span-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Escribe la respuesta para el usuario..."></textarea>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Estado despues de responder</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 text-sm">
                                <option value="en_proceso">En proceso</option>
                                <option value="resuelto">Resuelto</option>
                                <option value="cerrado">Cerrado</option>
                                <option value="abierto">Abierto</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Enviar respuesta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const box = document.getElementById('messages-box');
    if (!box) {
        return;
    }

    const endpoint = '{{ route('admin.soporte.messages', $ticket->id) }}';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function appendMessages(messages) {
        messages.forEach((msg) => {
            const wrapper = document.createElement('div');
            const isAdmin = !!msg.is_admin;
            wrapper.className = (isAdmin ? 'bg-indigo-50 border-indigo-200' : 'bg-amber-50 border-amber-200') + ' message-item border rounded-lg px-4 py-3 shadow-sm';
            wrapper.innerHTML = `
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-semibold ${isAdmin ? 'text-indigo-700' : 'text-amber-700'}">
                        ${escapeHtml(msg.sender_name)}
                        ${isAdmin ? '<span class="text-xs font-normal text-indigo-500">(Soporte)</span>' : '<span class="text-xs font-normal text-amber-600">(Usuario)</span>'}
                    </p>
                    <p class="text-xs text-gray-500">${escapeHtml(msg.created_at ?? '')}</p>
                </div>
                <p class="text-sm text-gray-800 whitespace-pre-wrap">${escapeHtml(msg.message)}</p>
            `;
            box.appendChild(wrapper);
        });

        if (messages.length > 0) {
            box.scrollTop = box.scrollHeight;
        }
    }

    function setStatusChip(status) {
        const statusNode = document.getElementById('ticket-status');
        if (!statusNode || !status) {
            return;
        }

        statusNode.textContent = String(status).replace('_', ' ');
        statusNode.classList.remove('status-chip-abierto', 'status-chip-en_proceso', 'status-chip-resuelto', 'status-chip-cerrado');

        const safeStatus = String(status);
        if (['abierto', 'en_proceso', 'resuelto', 'cerrado'].includes(safeStatus)) {
            statusNode.classList.add('status-chip-' + safeStatus);
        }
    }

    async function poll() {
        const lastId = Number(box.dataset.lastId || 0);

        try {
            const response = await fetch(endpoint + '?after_id=' + encodeURIComponent(lastId), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();
            appendMessages(data.messages || []);
            box.dataset.lastId = data.last_id || lastId;
            setStatusChip(data.status);
        } catch (error) {
            // silent polling
        }
    }

    setInterval(poll, 6000);
})();
</script>
@endpush
@endsection
