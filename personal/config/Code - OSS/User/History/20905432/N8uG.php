<div class="card dark:bg-gray-800 dark:text-white">
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <x-validation-errors class="mb-4" />

        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" wire:model="file" class="hidden" accept="image/*">
                </label>
            </div>
            <img id="picture" class="aspect-[16/9] object-cover object-center w-1/2 mx-auto rounded-lg shadow-md dark:shadow-lg" src="{{ $file ? $file->temporaryUrl() : asset('img/no-image.png') }}" alt="Imagen no disponible">
        </figure>
        
        <div class="mb-4">
            <x-input type="hidden" wire:model.defer="post.user_id" />
            <x-label for="name" class="mb-2 dark:text-gray-300">Nombre</x-label>
            <x-input id="name" wire:model.defer="post.name" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe un título" autocomplete="off" />
        </div>
        <div class="mb-4">
            <x-label for="slug" class="mb-2 dark:text-gray-300">Slug</x-label>
            <x-input id="slug" wire:model.defer="post.slug" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la categoría" readonly />
        </div>
        <div class="mb-4">
            <x-label for="blogcategory_id" class="mb-2 dark:text-gray-300">Categorías</x-label>
            <x-select id="blogcategory_id" wire:model.defer="post.blogcategory_id" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                <option value="">Seleccionar categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-select>
        </div>
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Etiquetas</x-label>
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
            <x-label class="mb-2 dark:text-gray-300">Status</x-label>
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-2">
                    <input type="radio" wire:model.defer="post.status" id="status1" value="1">
                    <label for="status1">Borrador</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" wire:model.defer="post.status" id="status2" value="2">
                    <label for="status2">Publicado</label>
                </div>
            </div>
        </div>
  
        <div class="mb-4 text-gray-700">
            <x-label class="mb-2 dark:text-gray-300">Extracto</x-label>
            <x-textarea wire:model.defer="post.extract" id="extract" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400"></x-textarea>
        </div>
  
        <div class="mb-4 text-gray-700">
            <x-label class="mb-2 dark:text-gray-300">Cuerpo del post</x-label>
            <x-textarea wire:model.defer="post.body" id="body" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400"></x-textarea>
        </div>
  
        <div class="flex justify-end">
            <x-button>
                Crear Entrada
            </x-button>
        </div>
    </form>
</div>

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        function initializeCKEditor() {
            ClassicEditor
                .create(document.querySelector('#body'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('post.body', editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }

        initializeCKEditor();

        Livewire.hook('message.processed', (message, component) => {
            initializeCKEditor();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        nameInput.addEventListener('keyup', function() {
            let title = nameInput.value;
            let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            slugInput.value = slug;
        });

        document.getElementById("file").addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };
            if (file) {
                reader.readAsDataURL(file);
            } else {
                console.error("No file selected or the file is not accessible.");
            }
        });
    });
</script>
@endpush
