<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Etiquetas',
        'route' => route('admin.tags.index'),
    ],
    [
        'name' => $tag->name,
    ],
]">

<form action="{{ route('admin.tags.update', $tag) }}" method="POST">
    @csrf

    <x-validation-errors class="mb-4" />

    <div class="card dark:bg-gray-800 dark:text-white">
        @method('PUT')
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Nombre
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la categoría" name="name" id="name" value="{{ old('name', $tag->name) }}" />
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Slug
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la categoría" name="slug" id="slug" value="{{ old('name', $tag->slug) }}" readonly/>
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Color
            </x-label>

            <div class="flex items-center space-x-2">
                <input type="color" name="color" id="color" class="w-10 h-10" value="{{ old('color', $tag->color) }}">
                <input type="text" name="color" id="color" class="w-32 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="{{ old('color', $tag->color) }}">
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <x-danger-button class="dark:bg-red-700 dark:text-white" onclick="confirmDelete()">
                Eliminar
            </x-danger-button>
            <x-button>
                Actualizar
            </x-button>
        </div>
    </div>
</form>

<form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

</form>
  
  @push('js')

    <script src="{{ asset('js/scripts/delete-confirmation.js') }}"></script>
    <script src="{{ asset('js/scripts/slug-generator.js') }}"></script>   
  @endpush


</x-admin-layout>