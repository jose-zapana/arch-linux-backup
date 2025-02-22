<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.products.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    @livewire('admin.products.product-create')

    @push('js')
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        function uploadImage(event) {
            const file = event.target.files[0];
    
            if (file) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');
    
                // Enviar la imagen con AJAX
                fetch('{{ route("admin.blogs.uploadImage") }}', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar la imagen de vista previa
                        document.getElementById('picture').src = data.imageUrl;
                    } else {
                        alert('Error al cargar la imagen');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar la imagen:', error);
                });
            }
        }
    
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar CKEditor solo si no está inicializado
            initializeCKEditor();
    
            Livewire.hook('message.processed', () => {
                initializeCKEditor();
            });
        });
    
        function initializeCKEditor() {
            const fields = ['#description', '#extract', '#body'];
    
            fields.forEach(fieldSelector => {
                const field = document.querySelector(fieldSelector);
                if (field && !field.ckeditorInstance) {
                    ClassicEditor
                        .create(field, {
                            simpleUpload: {
                                uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                                withCredentials: true,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                }
                            },
                            toolbar: [
                                'heading', '|', 
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'link', 'bulletedList', 'numberedList', '|',
                                'blockQuote', 'insertTable', 'imageUpload', '|',
                                'undo', 'redo'
                            ],
                            table: {
                                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                            },
                            image: {
                                toolbar: [
                                    'imageTextAlternative', 
                                    'imageStyle:full', 
                                    'imageStyle:side'
                                ]
                            },
                        })
                        .then(editor => {
                            field.ckeditorInstance = editor;
                        })
                        .catch(error => console.error(error));
                }
            });
        }
    </script>
    @endpush
    


</x-admin-layout>
