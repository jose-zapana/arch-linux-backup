<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías del blog',
        'route' => route('admin.posts.categories.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">


<div class="card dark:bg-gray-800 dark:text-white">
  <form action="{{ route('admin.posts.categories.store') }}" method="POST">
      @csrf

      <x-validation-errors class="mb-4" />

      <div class="mb-4">
          <x-label class="mb-2 dark:text-gray-300">
              Nombre
          </x-label>
          <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la categoría" id="name" name="name" value="{{ old('name') }}" />
      </div>
      <div class="mb-4">
          <x-label class="mb-2 dark:text-gray-300">
              Slug
          </x-label>
          <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la categoría" name="slug" id="slug" value="{{ old('slug') }}" readonly/>
      </div>
      <div class="flex justify-end">
          <x-button>
              Crear Categoría
          </x-button>
      </div>
  </form>
</div>

@push('js')
    <script src="{{ asset('js/scripts/slug-generator.js') }}"></script> 
@endpush

</x-admin-layout>