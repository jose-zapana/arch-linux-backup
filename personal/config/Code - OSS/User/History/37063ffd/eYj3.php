<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

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
    
    

    @endpush
</x-admin-layout>
