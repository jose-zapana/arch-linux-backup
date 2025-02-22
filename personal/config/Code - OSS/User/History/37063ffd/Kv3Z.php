<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')

    <script>
            //Ckedtidor
            ClassicEditor
                .create(document.querySelector('#body'), {
                    simpleUpload: {
                        // The URL that the images are uploaded to.
                        uploadUrl: "{{ route('admin.ckeditor.upload') }}",

                        // Enable the XMLHttpRequest.withCredentials property.
                        withCredentials: true,

                        // Headers sent along with the XMLHttpRequest to the upload server.
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
    </script>



    <script src="{{ asset('js/scripts/slug-generator.js') }}"></script>

    @endpush
</x-admin-layout>
