<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index'),
    ],
    [
        'name' => $family->name,
    ],
]">

<form action="{{ route('admin.families.update', $family) }}" method="POST">
    @csrf

    <div class="card dark:bg-gray-800 dark:text-white">
        @method('PUT')
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Nombre
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la familia" name="name" value="{{ old('name', $family->name) }}" />
        </div>

        <div class="flex justify-end space-x-2">
            <x-danger-button class="dark:bg-red-700 dark:text-white" onclick="confirmDelete()">
                Eliminar
            </x-danger-button>
            <x-button class="dark:bg-gray-700 dark:text-white">
                Actualizarr
            </x-button>
        </div>
    </div>
</form>
    <form action="{{ route('admin.families.destroy', $family) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

    </form>

    @push('js')
        <script>
            function confirmDelete() {
                // 

                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, elimínelo!",
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
