<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'route' => route('admin.roles.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

<form action="{{ route('admin.roles.store') }}" method="POST">
    @csrf

    <div class="card dark:bg-gray-800 dark:text-white">
        <x-validation-errors class="mb-4" />

        <!-- Campo Nombre del Rol -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300" for="name">
                Nombre
            </x-label>
            <x-input 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                placeholder="Ingrese el nombre del rol" 
                name="name" 
                value="{{ old('name') }}" 
                required 
            />
        </div>

        <!-- Campo Descripción del Rol -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300" for="description">
                Descripción
            </x-label>
            <x-input 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                placeholder="Ingrese una descripción para el rol" 
                name="description" 
                value="{{ old('description') }}" 
            />
        </div>

        <!-- Campo Selección de Permisos -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300" for="permissions">
                Permisos
            </x-label>
            <x-select 
                name="permissions[]" 
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                multiple
            >
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}" @selected(in_array($permission->id, old('permissions', [])))>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end">
            <x-button class="dark:bg-gray-700 dark:text-white">
                Guardar
            </x-button>
        </div>
    </div>
</form>



</x-admin-layout>
