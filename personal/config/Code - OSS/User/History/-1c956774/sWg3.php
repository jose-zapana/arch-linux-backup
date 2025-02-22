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
        function initializeCKEditor() {
            const fields = ['#description'];
    
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
                            }
                        })
                        .then(editor => {
                            field.ckeditorInstance = editor;
                        })
                        .catch(error => console.error(error));
                }
            });
        }
    
        document.addEventListener("DOMContentLoaded", function () {
            initializeCKEditor();
    
            Livewire.hook('message.processed', () => {
                initializeCKEditor();
            });
        });
    </script>
    @endpush
    


</x-admin-layout>
