<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Generador de slug a partir del nombre
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            nameInput.addEventListener('keyup', function() {
                let title = nameInput.value;
                let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
    
            document.addEventListener('DOMContentLoaded', function () {
            ClassicEditor
                .create(document.querySelector('#extract'))
                .then(editor => {
                    editor.setData(@json($blog->extract));
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#body'))
                .then(editor => {
                    editor.setData(@json($blog->body));
                })
                .catch(error => {
                    console.error(error);
                });
        });
    
            // Previsualización de imagen seleccionada
            document.getElementById("file").addEventListener('change', function(event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById("picture").setAttribute('src', event.target.result);
                };
                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    console.error("No file selected or the file is not accessible.");
                }
            });
        });
    </script>


    @endpush
</x-admin-layout>
