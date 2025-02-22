<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('livewire.admin.blogs.partials.form')

    @push('js')

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            nameInput.addEventListener('keyup', function() {
                let title = nameInput.value;
                let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        });

        ClassicEditor
            .create( document.querySelector( '#extract' ) )
            .catch( error => {
                console.error( error );
        });

        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
                console.error( error );
        });

    </script>

    @endpush
</x-admin-layout>
