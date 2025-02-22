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
            // Inicializar CKEditor para el campo #description
            if (document.querySelector('#description')) {
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        simpleUpload: {
                            uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                            withCredentials: true,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            }
                        },
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Párrafo', class: 'ck-heading_paragraph' },
                                { model: 'heading2', view: 'h2', title: 'Encabezado 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Encabezado 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Encabezado 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Encabezado 5', class: 'ck-heading_heading5' }
                            ]
                        },
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
        });
    </script>
  
    @endpush
</x-admin-layout>
