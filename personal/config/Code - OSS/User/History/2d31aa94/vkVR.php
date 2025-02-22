<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div class="card dark:bg-gray-800 dark:text-white">
        <x-validation-errors class="mb-4" />

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Familia
            </x-label>

            <x-select name="family_id" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                @foreach ($families as $family)
                    <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                        {{ $family->name }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Nombre
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la categoría" name="name" value="{{ old('name') }}" />
        </div>

        <div class="flex justify-end">
            <x-button class="dark:bg-gray-700 dark:text-white">
                Guardar
            </x-button>
        </div>
    </div>
</form>

</x-admin-layout>
