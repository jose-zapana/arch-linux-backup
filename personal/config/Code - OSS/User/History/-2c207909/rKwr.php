<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías del blog',
        'route' => route('admin.tags.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">


<div class="card dark:bg-gray-800 dark:text-white">
  <form action="{{ route('admin.tags.store') }}" method="POST">
      @csrf

      <x-validation-errors class="mb-4" />

      <div class="mb-4">
          <x-label class="mb-2 dark:text-gray-300">
              Nombre
          </x-label>
          <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la etiqueta" id="name" name="name" value="{{ old('name') }}" />
      </div>
      <div class="mb-4">
          <x-label class="mb-2 dark:text-gray-300">
              Slug
          </x-label>
          <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la etiqueta" name="slug" id="slug" value="{{ old('slug') }}" readonly/>
      </div>
      <div class="mb-4">
        <x-label class="mb-2 dark:text-gray-300">
            Color
        </x-label>
        <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el color de la etiqueta" name="color" id="color" value="{{ old('color') }}"/>
    </div>

      <div class="flex justify-end">
          <x-button>
              Crear Etiqueta
          </x-button>
      </div>
  </form>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('keyup', function() {
                let title = nameInput.value;
                let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        });
    </script>
@endpush

</x-admin-layout>