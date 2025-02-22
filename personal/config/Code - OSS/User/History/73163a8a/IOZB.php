<div class="bg-white dark:bg-gray-900 text-black dark:text-white">
    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 cursor-pointer text-gray-700 dark:text-gray-300">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            <img class="aspect-[16/9] object-cover object-center w-1/2 mx-auto" src="{{ $image ? $image->temporaryUrl() : asset('img/no-image.png') }}" alt="">

        </figure>

        <div class="card bg-white dark:bg-gray-800">
            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Código
                </x-label>
                <x-input wire:model="product.sku" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el código del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Nombre
                </x-label>
                <x-input wire:model="product.name" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el nombre del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Precio
                </x-label>
                <x-input type="number" step="0.01" wire:model="product.price" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el precio del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Familias
                </x-label>
                <x-select name="family_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="family_id">
                    <option value="" disabled>
                        Seleccione una Familia
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                            {{ $family->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-2 text-gray-700 dark:text-gray-300">
                    Categorías
                </x-label>
                <x-select name="category_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="category_id">
                    <option value="" disabled>
                        Seleccione una Categoría
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-2 text-gray-700 dark:text-gray-300">
                    Subcategorías
                </x-label>
                <x-select name="category_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="product.subcategory_id">
                    <option value="" disabled>
                        Seleccione una Subcategoría
                    </option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" @selected(old('category_id') == $subcategory->id)>
                            {{ $subcategory->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4" wire:ignore>
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Descripción
                </x-label>
                <x-textarea wire:model="product.description" id="description" name="description" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese la descripción del producto">
                </x-textarea>
            </div>

            <x-validation-errors class="mb-4 text-red-500 dark:text-red-400" />

            <div class="flex justify-end">
                <x-button class="bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-600">
                    Crear Producto
                </x-button>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const root = document.documentElement;

        // Detectar tema actual (claro/oscuro)
        const getCurrentTheme = () => root.classList.contains('dark') ? 'dark' : 'light';

        // Obtener los estilos dinámicos según el tema
        const getThemeStyles = (theme) => {
            if (theme === 'dark') {
                return `
                    body {
                        background-color: #1a202c; /* Fondo oscuro */
                        color: #e2e8f0; /* Texto claro */
                    }
                    a {
                        color: #63b3ed; /* Enlaces */
                    }
                `;
            } else {
                return `
                    body {
                        background-color: #ffffff; /* Fondo claro */
                        color: #2d3748; /* Texto oscuro */
                    }
                    a {
                        color: #3182ce; /* Enlaces */
                    }
                `;
            }
        };

        // Inicializar CKEditor
        if (document.querySelector('#description')) {
            const theme = getCurrentTheme();

            ClassicEditor
                .create(document.querySelector('#description'), {
                    // Configuración para la carga de imágenes
                    simpleUpload: {
                        uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    },
                    // Configuración de encabezados
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Párrafo', class: 'ck-heading_paragraph' },
                            { model: 'heading2', view: 'h2', title: 'Encabezado 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Encabezado 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Encabezado 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Encabezado 5', class: 'ck-heading_heading5' }
                        ]
                    },
                    // Configuración de la barra de herramientas
                    toolbar: [
                        'heading', '|', 
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', 'imageUpload', '|',
                        'undo', 'redo'
                    ],
                    // Configuración de tablas
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    // Configuración de imágenes
                    image: {
                        toolbar: [
                            'imageTextAlternative', 
                            'imageStyle:full', 
                            'imageStyle:side'
                        ]
                    },
                    // CSS dinámico para el contenido
                    contentsCss: getThemeStyles(theme),
                })
                .then(function (editor) {
                    // Cuando haya un cambio en el editor, actualiza el valor en Livewire
                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    });

                    // Observador de tema
                    const observer = new MutationObserver(() => {
                        const newTheme = getCurrentTheme();
                        editor.ui.view.editable.element.style = getThemeStyles(newTheme);
                    });

                    observer.observe(root, { attributes: true });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>

