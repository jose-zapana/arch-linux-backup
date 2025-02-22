<div class="dark:bg-gray-900 dark:text-white">
    <form wire:submit.prevent="store">
        <x-validation-errors class="mb-4" />

        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" wire:model="file" class="hidden" accept="image/*">
                </label>
            </div>
            <img id="picture" class="aspect-[16/9] object-cover object-center w-1/2 mx-auto rounded-lg shadow-md dark:shadow-lg" src="{{ $file ? $file->temporaryUrl() : (isset($postEdit->image_path) ? Storage::url($postEdit->image_path) : asset('img/no-image.png')) }}" alt="Imagen no disponible">
        </figure>

        <div class="card dark:bg-gray-800">
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="postEdit.name" class="w-full dark:bg-gray-700 dark:text-gray-300"
                         placeholder="Por favor ingrese el nombre del post" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Slug
                </x-label>
                <x-input wire:model="postEdit.slug" class="w-full dark:bg-gray-700 dark:text-gray-300" readonly />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Categorías
                </x-label>
                <x-select wire:model="postEdit.blogcategory_id" class="w-full dark:bg-gray-700 dark:text-gray-300">
                    <option value="">Seleccionar categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Etiquetas
                </x-label>
                <div class="flex flex-wrap space-x-4">
                    @foreach ($tags as $tag)
                        <div>
                            <input type="checkbox" id="tag{{ $tag->id }}" wire:model="selectedTags" value="{{ $tag->id }}">
                            <label for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Estado
                </x-label>
                <div class="flex items-center space-x-4">
                    <div>
                        <input type="radio" wire:model="postEdit.status" id="status1" value="1">
                        <label for="status1">Borrador</label>
                    </div>
                    <div>
                        <input type="radio" wire:model="postEdit.status" id="status2" value="2">
                        <label for="status2">Publicado</label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Extracto
                </x-label>
                <x-textarea wire:model="postEdit.extract" class="w-full dark:bg-gray-700 dark:text-gray-300"
                            placeholder="Escribe un extracto para el post"></x-textarea>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Cuerpo del Post
                </x-label>
                <x-textarea wire:model="postEdit.body" class="w-full dark:bg-gray-700 dark:text-gray-300"
                            placeholder="Escribe el contenido del post"></x-textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>
                <x-button>
                    Actualizar Entrada
                </x-button>
            </div>
        </div>
    </form>

    {{-- <form action="{{ route('admin.posts.destroy', $postEdit) }}" method="POST" id="delete-form">
        @csrf
        @method('DELETE')
    </form> --}}

    @push('js')
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, elimínelo",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    @endpush
</div>
