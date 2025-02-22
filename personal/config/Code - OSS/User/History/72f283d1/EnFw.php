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

        <!-- Campo Selección de Permisos -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300" for="permissions">
                Permisos
            </x-label>
            
            <!-- Iteramos sobre los permisos y creamos un checkbox para cada uno -->
            <div class="space-y-2">
                @foreach ($permissions as $permission)
                    <div class="flex items-center">
                        <x-checkbox 
                            name="permissions[]" 
                            value="{{ $permission->id }}" 
                            :checked="in_array($permission->id, old('permissions', []))" 
                            class="dark:bg-gray-700 dark:border-gray-600"
                        />
                        <x-label class="ml-2 dark:text-gray-300">
                            {{ $permission->name }}
                        </x-label>
                    </div>
                @endforeach
            </div>
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
