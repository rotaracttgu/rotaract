<x-guest-layout>
    
    <!-- El Logo Centrado y Estilizado ha sido eliminado por solicitud del usuario. -->

    <!-- Descripción del Proceso -->
    <div class="mb-6 text-sm text-gray-700 text-center">
        {{ __('Se ha enviado un código de 6 dígitos a tu correo electrónico.') }}
        <p class="mt-1 font-semibold text-gray-900">{{ __('Por favor, ingrésalo a continuación para continuar.') }}</p>
    </div>

    <!-- Mensajes de Estado (Success/Error) -->
    @if (session('success'))
        <div class="mb-4 font-medium text-sm p-3 bg-green-50 border border-green-200 text-green-600 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.verify.post') }}" class="space-y-6">
        @csrf

        <!-- Código de verificación - Estilo Moderno -->
        <div>
            <x-input-label for="code" :value="__('Código de 6 dígitos')" class="text-center" />
            
            <x-text-input 
                id="code" 
                class="block mt-1 w-full text-center text-3xl font-mono p-4 border-2 border-indigo-400 focus:border-indigo-600 rounded-xl transition duration-150 shadow-md tracking-widest" 
                type="text" 
                name="code" 
                maxlength="6"
                pattern="[0-9]{6}"
                placeholder="000000"
                autofocus 
                autocomplete="off" 
            />
            <x-input-error :messages="$errors->get('code')" class="mt-2 text-center" />
        </div>

        <!-- Botón Principal -->
        <div class="flex justify-center mt-6">
            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold uppercase rounded-xl shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                {{ __('Verificar') }}
            </button>
        </div>
    </form>

    <!-- Enlaces Secundarios: Reenviar y Cancelar -->
    <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center text-center">
        
        <!-- Reenviar código -->
        <form method="POST" action="{{ route('2fa.resend') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition duration-150">
                {{ __('Reenviar código') }}
            </button>
        </form>

        <!-- Logout / Cancelar -->
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition duration-150">
                {{ __('Cancelar y cerrar sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
