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
        'name' => $category->name,
    ],
]">
<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card bg-white dark:bg-gray-800">
      <x-validation-errors class="mb-4" />
      <div class="mb-4">
        <x-label class="mb-2 dark:text-gray-300">Familia</x-label>
        <x-select name="family_id" class="w-full dark:bg-gray-700 dark:text-gray-300">
          @foreach ($families as $family)
            <option value="{{ $family->id }}" @selected(old('family_id', $category->family_id) == $family->id)>
              {{ $family->name }}
            </option>
          @endforeach
        </x-select>
      </div>
      <div class="mb-4">
        <x-label class="mb-2 dark:text-gray-300">Nombre</x-label>
        <x-input class="w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Ingrese el nombre de la categoría" name="name" value="{{ old('name', $category->name) }}" />
      </div>
      <div class="flex justify-end space-x-2">
        <x-danger-button onclick="confirmDelete()" class="dark:bg-red-700">Eliminar</x-danger-button>
        <x-button class="dark:bg-blue-700">Actualizar</x-button>
      </div>
    </div>
</form>

<form action="{{ route('admin.categories.destroy', $category) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

</form>

    @push('js')
    <script src="{{ asset('js/scripts/delete-confirmation.js') }}"></script>
    @endpush

</x-admin-layout>
