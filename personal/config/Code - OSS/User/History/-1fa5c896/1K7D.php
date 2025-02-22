<div class="card bg-white dark:bg-gray-800">

    <form wire:submit.prevent="store" class="p-4">

        @csrf

        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Nombre
            </x-label>
            <x-input 
                wire:model="userEdit.name" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                placeholder="Por favor ingrese el nombre" 
            />
        </div>

        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Apellidos
            </x-label>
            <x-input 
                wire:model="userEdit.last_name" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                placeholder="Por favor ingrese los apellidos" 
            />
        </div>

        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Email
            </x-label>
            <x-input 
                wire:model="userEdit.email" 
                type="email" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                placeholder="Por favor ingrese el email" 
            />
        </div>

        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Rol
            </x-label>
            <x-select 
                name="role_id" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400"
                wire:model="userEdit.role_id"
            >
                <option value="" disabled class="dark:bg-gray-700 dark:text-gray-200">
                    Seleccione un rol
                </option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" class="dark:bg-gray-700 dark:text-gray-200">
                        {{ $role->name }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <div class="flex justify-end">
            <x-button class="dark:bg-blue-700 dark:hover:bg-blue-800">
                Guardar
            </x-button>
        </div>

    </form>

</div>
