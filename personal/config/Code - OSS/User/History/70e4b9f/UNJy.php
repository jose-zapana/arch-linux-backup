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
        'name' => $role->name,
    ],
]">
<form action="{{ route('admin.roles.update', $role) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card bg-white dark:bg-gray-800">
        <x-validation-errors class="mb-4" />

        <!-- Campo Nombre del Rol -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Nombre</x-label>
            <x-input 
                class="w-full dark:bg-gray-700 dark:text-gray-300" 
                placeholder="Ingrese el nombre del rol" 
                name="name" 
                value="{{ old('name', $role->name) }}" 
                required 
            />
        </div>

        <!-- Campo Selección de Permisos (Checkboxes) -->
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300" for="permissions">
                Permisos
            </x-label>
            <div class="space-y-2">
                @foreach ($permissions as $permission)
                    <div class="flex items-center">
                        <x-checkbox 
                            name="permissions[]" 
                            value="{{ $permission->id }}" 
                            :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))" 
                            class="dark:bg-gray-700 dark:border-gray-600"
                        />
                        <x-label class="ml-2 dark:text-gray-300">
                            {{ $permission->name }}
                        </x-label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-end space-x-2">
            <x-danger-button onclick="confirmDelete()" class="dark:bg-red-700">Eliminar</x-danger-button>
            <x-button class="dark:bg-blue-700">Actualizar</x-button>
        </div>
    </div>
</form>

<!-- Formulario de eliminación (oculto) -->
<form action="{{ route('admin.roles.destroy', $role) }}" method="POST" id="delete-form">
    @csrf
    @method('DELETE')
</form>

@push('js')
    <script>
        function confirmDelete() {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, elimínalo!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }
    </script>
@endpush

</x-admin-layout>
