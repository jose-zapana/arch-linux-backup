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
        // Función para previsualizar la imagen seleccionada
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
    
            reader.onload = function(e) {
                document.getElementById('picture').src = e.target.result;
            };
    
            if (file) {
                reader.readAsDataURL(file);
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
