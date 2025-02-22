<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')

    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar CKEditor para el campo #body con subida de imágenes
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
                        // Configuración para imágenes
                        image: {
                            toolbar: [
                                'imageTextAlternative', // Permitir edición de texto alternativo
                                'imageStyle:full',
                                'imageStyle:side'
                            ],
                            // Ajuste dinámico del atributo "alt" al cargar imágenes
                            upload: {
                                types: ['jpeg', 'png', 'gif', 'webp']
                            }
                        },
                        // CSS para ajustar contenido
                        contentsCss: `
                            .ck-content {
                                word-wrap: break-word;
                                overflow-wrap: break-word;
                                white-space: pre-wrap;
                            }
                        `
                    })
                    .then(editor => {
                        // Agregar un "alt" dinámico a las imágenes cuando se carguen
                        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                            return {
                                upload: () => {
                                    return loader.file
                                        .then(file => {
                                            const formData = new FormData();
                                            formData.append('upload', file);
    
                                            return fetch("{{ route('admin.ckeditor.upload') }}", {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.url) {
                                                    return {
                                                        default: data.url,
                                                        alt: file.name || 'Imagen sin descripción'
                                                    };
                                                } else {
                                                    throw new Error('Error al subir la imagen.');
                                                }
                                            });
                                        });
                                }
                            };
                        };
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
    
            // Inicializar CKEditor para el campo #extract sin permitir subida de imágenes
            if (document.querySelector('#extract')) {
                ClassicEditor
                    .create(document.querySelector('#extract'), {
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
    
                    let normalizedTitle = title
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "");
    
                    let slug = normalizedTitle
                        .toLowerCase()
                        .replace(/[^a-z0-9\s]/g, "")
                        .trim()
                        .replace(/\s+/g, "-");
    
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
