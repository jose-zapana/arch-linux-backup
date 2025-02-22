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
        document.addEventListener("DOMContentLoaded", function () {
            // Inicializar CKEditor para el campo #description
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(function(editor) {
                    // Establecer un evento para sincronizar CKEditor con Livewire
                    editor.model.document.on('change:data', () => {
                        const editorData = editor.getData();
                        // Usar Livewire.emit para emitir un evento y actualizar la propiedad 'product.description'
                        Livewire.emit('updateProductDescription', editorData);
                    });
                })
                .catch(function(error) {
                    console.error(error);
                });
        });
    </script>
        
    @endpush
</x-admin-layout>
