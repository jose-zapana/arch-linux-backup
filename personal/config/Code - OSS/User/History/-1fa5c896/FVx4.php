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

        <!-- Campo Roles (Select2 Multi-Select) -->
        <div class="mb-4">
            <x-label class="mb-1 dark:text-gray-300">
                Roles
            </x-label>
            <select 
                name="roles[]" 
                id="roles" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400 select2" 
                multiple 
                wire:model="userEdit.roles"
            >
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end">
            <x-button class="dark:bg-blue-700 dark:hover:bg-blue-800">
                Guardar
            </x-button>
        </div>

    </form>

</div>
