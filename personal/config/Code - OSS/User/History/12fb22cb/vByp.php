<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Entradas del blog',
        'route' => route('admin.blogs.index'),
    ],
    [
        'name' => $blog->name,
    ],
]">   

<form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="card bg-white dark:bg-gray-800">
        <x-validation-errors class="mb-4" />

        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" id="file" name="file" class="hidden" accept="image/*">
                </label>
            </div>
            <img id="picture" 
            class="aspect-[16/9] object-cover object-center w-1/2 mx-auto rounded-lg shadow-md dark:shadow-lg" 
            src="{{ $blog->image ? asset('storage/' . $blog->image->url) : asset('img/no-image.png') }}" 
            alt="Imagen actual">
        </figure>

        <div class="mb-4">
            <x-input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
            <x-label for="name" class="mb-2 dark:text-gray-300">Nombre</x-label>
            <x-input id="name" name="name" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Escribe un título" value="{{ old('name', $blog->name) }}" autocomplete="off" />
        </div>

        <div class="mb-4">
            <x-label for="slug" class="mb-2 dark:text-gray-300">Slug</x-label>
            <x-input id="slug" name="slug" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Ingrese el slug de la entrada" value="{{ old('slug', $blog->slug) }}" readonly />
        </div>

        <div class="mb-4">
            <x-label for="blogcategory_id" class="mb-2 dark:text-gray-300">Categorías</x-label>
            <x-select id="blogcategory_id" name="blogcategory_id" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                <option value="">Seleccionar categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('blogcategory_id', $blog->blogcategory_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Etiquetas</x-label>
            <div class="flex flex-wrap space-x-4 text-gray-700 dark:text-gray-200">
                @foreach ($tags as $tag)
                    <div>
                        <input type="checkbox" id="tag{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', $blog->tags->pluck('id')->toArray()))) class="dark:bg-gray-700 dark:border-gray-600">
                        <label for="tag{{ $tag->id }}" class="dark:text-gray-300">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Status</x-label>
            <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status1" value="1" @checked(old('status', $blog->status) == 1) aria-labelledby="status1" class="dark:bg-gray-700 dark:border-gray-600">
                    <label for="status1" class="dark:text-gray-300">Borrador</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="status" id="status2" value="2" @checked(old('status', $blog->status) == 2) aria-labelledby="status2" class="dark:bg-gray-700 dark:border-gray-600">
                    <label for="status2" class="dark:text-gray-300">Publicado</label>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Extracto</x-label>
            <textarea name="extract" id="extract" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400">
                {!! old('extract', $blog->extract) !!}
            </textarea>
        </div>
        
        <div class="mb-4">
            <x-label class="mb-2 dark:text-gray-300">Cuerpo del post</x-label>
            <textarea name="body" id="body" class="w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400">
                {!! old('body', $blog->body) !!}
            </textarea>
        </div>
        

        <div class="flex justify-end space-x-2">
            <x-danger-button onclick="confirmDelete()" class="dark:bg-red-700">Eliminar</x-danger-button>
            <x-button class="dark:bg-blue-700">Actualizar</x-button>
        </div>
    </div>
</form>

<form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" id="delete-form">
    @csrf
    @method('DELETE')
</form>

@push('js')

<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar CKEditor para el campo #body
        if (document.querySelector('#body')) {
            ClassicEditor
                .create(document.querySelector('#body'), {
                    simpleUpload: {
                        uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    },
                    // Asegurar que las palabras largas se ajusten dentro del editor
                    contentsCss: `
                        .ck-content {
                            word-wrap: break-word;
                            overflow-wrap: break-word;
                            white-space: pre-wrap;
                        }
                    `
                })

                .then(editor => {
                // Interceptar el evento de inserción de imágenes para añadir 'alt'
                editor.model.document.on('change:data', () => {
                    const root = editor.model.document.getRoot();
                    const writer = editor.model.change(writer => {
                        for (const element of root.getChildren()) {
                            if (element.is('imageBlock') || element.is('imageInline')) {
                                if (!element.getAttribute('alt')) {
                                    writer.setAttribute('alt', 'Descripción de imagen', element);
                                }
                            }
                        }
                    });
                });
                })

                .catch(error => {
                    console.error(error);
                });
        }

        // Inicializar CKEditor para el campo #extract
        if (document.querySelector('#extract')) {
            ClassicEditor
                .create(document.querySelector('#extract'), {
                    simpleUpload: {
                        uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    },
                    // Asegurar que las palabras largas se ajusten dentro del editor
                    contentsCss: `
                        .ck-content {
                            word-wrap: break-word;
                            overflow-wrap: break-word;
                            white-space: pre-wrap;
                        }
                    `
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Generar el slug al escribir en el campo de nombre
        const nameInput = document.getElementById("name");
        const slugInput = document.getElementById("slug");

        if (nameInput && slugInput) {
            nameInput.addEventListener("keyup", function () {
                let title = nameInput.value;

                // Normalizar y eliminar caracteres diacríticos (tildes)
                let normalizedTitle = title
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "");

                // Convertir a minúsculas, reemplazar caracteres no permitidos y eliminar guiones al inicio o final
                let slug = normalizedTitle
                    .toLowerCase()
                    .replace(/[^a-z0-9\s]/g, "") // Elimina caracteres especiales excepto espacios
                    .trim() // Elimina espacios en blanco al inicio y final
                    .replace(/\s+/g, "-"); // Reemplaza espacios internos con guiones

                slugInput.value = slug;
            });
        }

        // Cambiar la imagen al seleccionar un archivo
        const fileInput = document.getElementById("file");
        const picture = document.getElementById("picture");

        if (fileInput && picture) {
            fileInput.addEventListener("change", function (event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = function (event) {
                    picture.setAttribute("src", event.target.result);
                };
                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    console.error("No file selected or the file is not accessible.");
                }
            });
        }
    });
</script>


<script src="{{ asset('js/scripts/delete-confirmation.js') }}"></script>

@endpush
</x-admin-layout>
