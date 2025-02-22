<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')

    <!-- Cargar el CKEditor solo si el elemento está presente -->
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar CKEditor solo si el elemento está presente
            if (document.querySelector('#body')) {
                ClassicEditor
                    .create(document.querySelector('#body'), {
                        simpleUpload: {
                            uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                            withCredentials: true,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            }
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    </script>
    
    <!-- Incluir el archivo JS para la generación del slug -->
    <script src="{{ asset('js/scripts/slug-generator.js') }}"></script>

    @endpush
</x-admin-layout>
