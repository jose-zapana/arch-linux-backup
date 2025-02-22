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
            // Inicializar CKEditor solo una vez
            if (document.querySelector('#body')) {
                ClassicEditor
                    .create(document.querySelector('#body'), {
                        simpleUpload: {
                            // La URL a la que se suben las imágenes.
                            uploadUrl: "{{ route('admin.ckeditor.upload') }}",

                            // Habilitar la propiedad XMLHttpRequest.withCredentials.
                            withCredentials: true,

                            // Encabezados enviados junto con la solicitud XMLHttpRequest al servidor de carga.
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

    @endpush
</x-admin-layout>
