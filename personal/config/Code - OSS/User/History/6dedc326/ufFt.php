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
        'name' => $blogcategory->name,
    ],
]">

<form action="{{ route('admin.posts.categories.update', $blogcategory) }}" method="POST">

    @csrf

    <div class="card dark:bg-gray-800 dark:text-white">
        @method('PUT')
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Nombre
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el nombre de la categoría" name="name" id="name" value="{{ old('name', $blogcategory->name) }}" />
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">
                Slug
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la categoría" name="slug" id="slug" value="{{ old('name', $blogcategory->slug) }}" />
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

<form action="{{ route('admin.posts.categories.destroy', $blogcategory) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

</form>
  
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