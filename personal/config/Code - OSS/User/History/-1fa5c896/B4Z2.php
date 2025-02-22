<div class="card bg-white dark:bg-gray-800">

    <form wire:submit.prevent="store" class="p-4">

        @csrf

        <x-validation-errors class="mb-4" />

        <!-- Campo Nombre -->
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

        <!-- Campo Apellidos -->
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

        <!-- Campo Email -->
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

        <!-- Campo Roles (Checkboxes) -->
        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Roles
            </x-label>
            <div class="space-y-2">
                @foreach ($roles as $role)
                    <label class="flex items-center dark:text-gray-200">
                        <input 
                            type="checkbox" 
                            value="{{ $role->id }}" 
                            wire:model="userEdit.roles" 
                            class="dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-blue-600 mr-2"
                        />
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end">
            <x-button class="dark:bg-blue-700 dark:hover:bg-blue-800">
                Guardar
            </x-button>
        </div>

    </form>

</div>
