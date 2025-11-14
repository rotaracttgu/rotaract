<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Se ha enviado un código de verificación a tu correo electrónico. Por favor, ingrésalo a continuación.') }}
    </div>

    <!-- Session Status -->
    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.verify.post') }}">
        @csrf

        <!-- Código de verificación -->
        <div>
            <x-input-label for="code" :value="__('Código de 6 dígitos')" />
            <x-text-input id="code" class="block mt-1 w-full text-center text-2xl tracking-widest" 
                          type="text" 
                          name="code" 
                          maxlength="6"
                          pattern="[0-9]{6}"
                          placeholder="000000"
                          autofocus 
                          autocomplete="off" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verificar') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Reenviar código (formulario separado) -->
    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('2fa.resend') }}" class="inline">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Reenviar código') }}
            </button>
        </form>
    </div>

    <!-- Logout -->
    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Cancelar y cerrar sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>