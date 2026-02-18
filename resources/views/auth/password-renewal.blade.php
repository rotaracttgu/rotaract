@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-950 to-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4
                {{ $passwordExpired ? 'bg-red-500/20 border-2 border-red-500' : 'bg-yellow-500/20 border-2 border-yellow-500' }}">
                <i class="fas {{ $passwordExpired ? 'fa-lock text-red-400' : 'fa-clock text-yellow-400' }} text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">
                {{ $passwordExpired ? '¡Contraseña Vencida!' : 'Renovar Contraseña' }}
            </h1>
            <p class="text-gray-400 mt-2">
                @if($passwordExpired)
                    Tu contraseña ha caducado. Debes renovarla para continuar.
                @elseif($diasRestantes !== null && $diasRestantes <= 7)
                    Tu contraseña vence en <span class="font-bold text-yellow-400">{{ $diasRestantes }} día(s)</span>. Te recomendamos renovarla ahora.
                @else
                    Cambia tu contraseña cuando lo desees.
                @endif
            </p>
        </div>

        {{-- Card del formulario --}}
        <div class="bg-gray-800/70 backdrop-blur-md border border-gray-700 rounded-2xl shadow-2xl p-8">

            {{-- Alertas --}}
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500 text-red-300 rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 rounded-xl px-4 py-3 mb-6">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contrasena.renovar.store') }}" id="formRenovar">
                @csrf

                {{-- Contraseña actual --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-key mr-1 text-gray-400"></i> Contraseña Actual
                    </label>
                    <div class="relative">
                        <input type="password"
                               name="password_actual"
                               id="password_actual"
                               class="w-full bg-gray-700/60 border border-gray-600 text-white rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 @error('password_actual') border-red-500 @enderror"
                               placeholder="Ingresa tu contraseña actual"
                               required>
                        <button type="button" onclick="togglePassword('password_actual', 'ico_actual')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200">
                            <i id="ico_actual" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_actual')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-gray-400"></i> Nueva Contraseña
                    </label>
                    <div class="relative">
                        <input type="password"
                               name="password"
                               id="password"
                               class="w-full bg-gray-700/60 border border-gray-600 text-white rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 @error('password') border-red-500 @enderror"
                               placeholder="Mínimo 8 caracteres, mayúsculas y números"
                               required>
                        <button type="button" onclick="togglePassword('password', 'ico_nueva')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200">
                            <i id="ico_nueva" class="fas fa-eye"></i>
                        </button>
                    </div>
                    {{-- Indicador de fuerza --}}
                    <div id="strength-bar" class="mt-2 h-1.5 w-full bg-gray-600 rounded-full overflow-hidden">
                        <div id="strength-fill" class="h-full w-0 rounded-full transition-all duration-300"></div>
                    </div>
                    <p id="strength-text" class="text-xs text-gray-500 mt-1"></p>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-check-double mr-1 text-gray-400"></i> Confirmar Nueva Contraseña
                    </label>
                    <div class="relative">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="w-full bg-gray-700/60 border border-gray-600 text-white rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500"
                               placeholder="Repite tu nueva contraseña"
                               required>
                        <button type="button" onclick="togglePassword('password_confirmation', 'ico_confirm')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-200">
                            <i id="ico_confirm" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p id="match-text" class="text-xs mt-1 hidden"></p>
                </div>

                {{-- Requisitos --}}
                <div class="bg-gray-700/40 rounded-xl p-4 mb-6 text-xs text-gray-400 space-y-1">
                    <p class="font-semibold text-gray-300 mb-2"><i class="fas fa-info-circle mr-1"></i> Requisitos de la contraseña:</p>
                    <p id="req-len"  class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-xs"></i> Mínimo 8 caracteres</p>
                    <p id="req-upper"class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-xs"></i> Al menos una mayúscula</p>
                    <p id="req-num"  class="flex items-center gap-2"><i class="fas fa-circle text-gray-600 text-xs"></i> Al menos un número</p>
                </div>

                <button type="submit" id="btnSubmit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <i class="fas fa-shield-alt mr-2"></i> Renovar Contraseña
                </button>

                @if(!$passwordExpired)
                    <a href="{{ url()->previous() }}"
                       class="block text-center text-gray-400 hover:text-gray-200 text-sm mt-4 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Volver sin cambiar
                    </a>
                @endif
            </form>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            Rotaract Fuerza Tegucigalpa Sur &mdash; Sistema de Gestión
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

const passwordInput = document.getElementById('password');
const confirmInput  = document.getElementById('password_confirmation');

passwordInput.addEventListener('input', function () {
    const val = this.value;

    // Requisitos
    const hasLen   = val.length >= 8;
    const hasUpper = /[A-Z]/.test(val);
    const hasNum   = /[0-9]/.test(val);

    setReq('req-len',   hasLen);
    setReq('req-upper', hasUpper);
    setReq('req-num',   hasNum);

    // Barra de fuerza
    const score = [hasLen, hasUpper, hasNum, val.length >= 12, /[^A-Za-z0-9]/.test(val)].filter(Boolean).length;
    const fill  = document.getElementById('strength-fill');
    const text  = document.getElementById('strength-text');
    const levels = [
        { pct: '0%',   cls: '',                     label: '' },
        { pct: '25%',  cls: 'bg-red-500',           label: 'Muy débil' },
        { pct: '50%',  cls: 'bg-orange-500',        label: 'Débil' },
        { pct: '75%',  cls: 'bg-yellow-400',        label: 'Buena' },
        { pct: '87%',  cls: 'bg-blue-400',          label: 'Fuerte' },
        { pct: '100%', cls: 'bg-green-500',         label: 'Muy fuerte' },
    ];
    fill.style.width = levels[score].pct;
    fill.className   = 'h-full rounded-full transition-all duration-300 ' + levels[score].cls;
    text.textContent = levels[score].label;
    text.className   = 'text-xs mt-1 ' + (score >= 3 ? 'text-green-400' : 'text-orange-400');
});

confirmInput.addEventListener('input', function () {
    const matchText = document.getElementById('match-text');
    if (this.value === '') { matchText.classList.add('hidden'); return; }
    matchText.classList.remove('hidden');
    if (this.value === passwordInput.value) {
        matchText.textContent = '✓ Las contraseñas coinciden';
        matchText.className   = 'text-xs mt-1 text-green-400';
    } else {
        matchText.textContent = '✗ Las contraseñas no coinciden';
        matchText.className   = 'text-xs mt-1 text-red-400';
    }
});

function setReq(id, ok) {
    const el   = document.getElementById(id);
    const icon = el.querySelector('i');
    if (ok) {
        icon.className = 'fas fa-check-circle text-green-400 text-xs';
        el.classList.remove('text-gray-400');
        el.classList.add('text-green-400');
    } else {
        icon.className = 'fas fa-circle text-gray-600 text-xs';
        el.classList.add('text-gray-400');
        el.classList.remove('text-green-400');
    }
}
</script>
@endpush
