<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Etiquetas',
        'route' => route('admin.posts.tags.index'),
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

<script>
    function confirmDelete() {
        // Detecta si el dark mode está activo
        const isDarkMode = document.documentElement.classList.contains('dark'); // Si usas la clase 'dark' de Tailwind

        // Definir colores según el modo
        const background = isDarkMode ? '#1f2937' : '#fff'; // Fondo oscuro o claro
        const color = isDarkMode ? '#fff' : '#000'; // Texto blanco o negro
        const iconColor = isDarkMode ? '#f87171' : '#f87171'; // Mismo color de advertencia para ambos modos
        const confirmButtonColor = isDarkMode ? '#34d399' : '#3085d6'; // Verde claro en dark, azul en light
        const cancelButtonColor = isDarkMode ? '#ef4444' : '#d33'; // Rojo oscuro en dark, rojo estándar en light

        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            background: background,
            color: color,
            iconColor: iconColor,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: cancelButtonColor,
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