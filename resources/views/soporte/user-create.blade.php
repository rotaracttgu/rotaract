@extends($layout)

@section('page-title', 'Nueva Consulta de Soporte')

@push('styles')
<style>
    .soporte-create-wrap {
        background: linear-gradient(180deg, rgba(37, 99, 235, 0.08), rgba(99, 102, 241, 0.04));
        border-radius: 1rem;
        padding: 0.75rem;
    }

    .soporte-card {
        animation: fade-in-up 0.4s ease;
        border: 1px solid rgba(147, 197, 253, 0.45);
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.92), rgba(255, 255, 255, 0.97));
    }

    .form-section {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.8), rgba(239, 246, 255, 0.45));
        border: 1px solid rgba(191, 219, 254, 0.6);
        border-radius: 0.85rem;
        padding: 1rem;
    }

    .hero-mini {
        background: linear-gradient(120deg, #2563eb, #4f46e5, #0ea5e9);
        color: #fff;
        border-radius: 0.9rem;
        padding: 1rem 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    .field-focus {
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .field-focus:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }

    .priority-hint {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
        margin-top: 0.65rem;
    }

    .priority-hint span {
        border-radius: 9999px;
        padding: 0.2rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .priority-low { background: #dcfce7; color: #166534; }
    .priority-med { background: #dbeafe; color: #1e40af; }
    .priority-high { background: #ffedd5; color: #c2410c; }
    .priority-urgent { background: #fee2e2; color: #b91c1c; }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto py-6 suporte-create-wrap">
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 suporte-card">
        <div class="hero-mini">
            <h1 class="text-2xl font-bold mb-1">Nueva consulta de soporte</h1>
            <p class="text-indigo-100">Describe el problema con detalle. El equipo de soporte responde en un maximo de 24 horas.</p>
        </div>

        <p class="text-gray-600 mb-6">Mientras mas contexto compartas, mas rapida sera la solucion.</p>

        <form method="POST" action="{{ route($routePrefix.'.soporte.store') }}" class="space-y-5">
            @csrf

            <div class="form-section">
                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Asunto</label>
                <input id="subject" name="subject" type="text" maxlength="200" value="{{ old('subject') }}" required
                       class="field-focus w-full rounded-lg border-gray-300" />
            </div>

            <div class="form-section">
                <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">Prioridad</label>
                <select id="priority" name="priority" required class="field-focus w-full rounded-lg border-gray-300">
                    <option value="media" {{ old('priority', 'media') === 'media' ? 'selected' : '' }}>Media</option>
                    <option value="baja" {{ old('priority') === 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="alta" {{ old('priority') === 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="urgente" {{ old('priority') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
                <div class="priority-hint" aria-hidden="true">
                    <span class="priority-low">Baja</span>
                    <span class="priority-med">Media</span>
                    <span class="priority-high">Alta</span>
                    <span class="priority-urgent">Urgente</span>
                </div>
            </div>

            <div class="form-section">
                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Mensaje</label>
                <textarea id="message" name="message" rows="8" required
                          class="field-focus w-full rounded-lg border-gray-300">{{ old('message') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route($routePrefix.'.soporte.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold hover:from-indigo-700 hover:to-blue-700 transition-all hover:-translate-y-0.5 shadow">Enviar consulta</button>
            </div>
        </form>
    </div>
</div>
@endsection
