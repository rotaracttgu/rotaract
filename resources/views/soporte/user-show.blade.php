@extends($layout)

@section('page-title', 'Ticket #'.$ticket->id)

@push('styles')
<style>
    .ticket-shell {
        background: radial-gradient(circle at right top, rgba(59, 130, 246, 0.13), transparent 36%),
                    radial-gradient(circle at left bottom, rgba(99, 102, 241, 0.1), transparent 40%);
        border-radius: 1rem;
        padding: 0.65rem;
    }

    .ticket-panel {
        border: 1px solid rgba(147, 197, 253, 0.45);
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.95), rgba(255, 255, 255, 0.97));
    }

    .ticket-panel-header {
        background: linear-gradient(90deg, rgba(219, 234, 254, 0.7), rgba(224, 231, 255, 0.5));
    }

    .composer-panel {
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.6), rgba(224, 231, 255, 0.32));
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.2rem 0.7rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: capitalize;
    }

    .status-chip-abierto { background: #fef3c7; color: #92400e; }
    .status-chip-en_proceso { background: #dbeafe; color: #1d4ed8; }
    .status-chip-resuelto { background: #dcfce7; color: #166534; }
    .status-chip-cerrado { background: #e5e7eb; color: #374151; }

    .message-item {
        animation: message-in 0.35s ease;
    }

    .message-box {
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.8), rgba(239, 246, 255, 0.45));
    }

    .composer-field {
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .composer-field:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }

    @keyframes message-in {
        from { opacity: 0; transform: translateY(7px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto py-6 ticket-shell">
    <div class="ticket-panel rounded-xl shadow overflow-hidden">
        <div class="ticket-panel-header px-6 py-4 border-b border-blue-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Estado:
                    <span id="ticket-status" class="status-chip status-chip-{{ $ticket->status }}">{{ str_replace('_', ' ', $ticket->status) }}</span>
                </p>
            </div>
            <a href="{{ route($routePrefix.'.soporte.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Volver a mis tickets</a>
        </div>

        <div id="messages-box" class="message-box p-6 space-y-4 max-h-[28rem] overflow-y-auto" data-last-id="{{ $ticket->mensajes->max('id') ?? 0 }}">
            @foreach($ticket->mensajes as $msg)
                <div class="message-item {{ $msg->is_admin ? 'bg-indigo-50 border-indigo-200' : 'bg-slate-50 border-slate-200' }} border rounded-lg px-4 py-3 shadow-sm">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-semibold {{ $msg->is_admin ? 'text-indigo-700' : 'text-gray-700' }}">
                            {{ $msg->sender->username ?? $msg->sender->name }}
                            @if($msg->is_admin)
                                <span class="text-xs font-normal text-indigo-500">(Soporte)</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $msg->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $msg->message }}</p>
                </div>
            @endforeach
        </div>

        @if($canReply)
            <div class="composer-panel px-6 py-4 border-t border-blue-100">
                <form method="POST" action="{{ route($routePrefix.'.soporte.reply', $ticket->id) }}" class="space-y-3">
                    @csrf
                    <textarea name="message" rows="4" required class="composer-field w-full rounded-lg border-blue-200" placeholder="Escribe tu mensaje..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold hover:from-indigo-700 hover:to-blue-700 transition-all hover:-translate-y-0.5 shadow">Enviar mensaje</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function () {
    const box = document.getElementById('messages-box');
    if (!box) {
        return;
    }

    const endpoint = '{{ route($routePrefix.'.soporte.messages', $ticket->id) }}';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function appendMessages(messages) {
        messages.forEach((msg) => {
            const wrapper = document.createElement('div');
            const isAdmin = !!msg.is_admin;
            wrapper.className = (isAdmin ? 'bg-indigo-50 border-indigo-200' : 'bg-slate-50 border-slate-200') + ' message-item border rounded-lg px-4 py-3 shadow-sm';
            wrapper.innerHTML = `
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-semibold ${isAdmin ? 'text-indigo-700' : 'text-gray-700'}">
                        ${escapeHtml(msg.sender_name)}
                        ${isAdmin ? '<span class="text-xs font-normal text-indigo-500">(Soporte)</span>' : ''}
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
