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
        'name' => 'Nuevo',
    ],
]">

    <div class="card">

        <form action="{{ route('admin.families.store') }}" method="POST" class="dark:bg-gray-800 dark:text-white">
            @csrf
        
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Nombre
                </x-label>
                <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la familia" name="name" value="{{ old('name') }}" />
            </div>
        
            <div class="flex justify-end">
                <x-button class="dark:bg-gray-700 dark:text-white">
                    Guardar
                </x-button>
            </div>
        </form>

    </div>

</x-admin-layout>
