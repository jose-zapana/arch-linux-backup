<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')

    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script>
        // Asegurarse de que el código se ejecute solo una vez cuando el DOM esté completamente cargado
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar CKEditor solo una vez para el campo #body
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
                        // Configuración para evitar desbordamiento de texto
                        contentsCss: 'body { word-wrap: break-word; overflow-wrap: break-word; }', // Asegura que las palabras largas se ajusten
                        removePlugins: 'elementspath', // Opcional: remueve los elementos de ruta que pueden afectar el diseño
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
                        // Configuración para evitar desbordamiento de texto
                        contentsCss: 'body { word-wrap: break-word; overflow-wrap: break-word; }',
                        removePlugins: 'elementspath',
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
    
            // Generar el slug al escribir en el campo de nombre
            const nameInput = document.getElementById("name");
            const slugInput = document.getElementById("slug");
    
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
    
            // Cambiar la imagen al seleccionar un archivo
            document.getElementById("file").addEventListener("change", function (event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = function (event) {
                    document
                        .getElementById("picture")
                        .setAttribute("src", event.target.result);
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
</x-admin-layout>
