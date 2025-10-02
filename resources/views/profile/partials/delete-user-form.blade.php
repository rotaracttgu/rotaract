<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Eliminar Cuenta
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Una vez que su cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar su cuenta, por favor descargue cualquier dato o información que desee conservar.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Eliminar Cuenta</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('perfil.eliminar') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                ¿Está seguro de que desea eliminar su cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez que su cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Contraseña" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Contraseña"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Eliminar Cuenta
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>