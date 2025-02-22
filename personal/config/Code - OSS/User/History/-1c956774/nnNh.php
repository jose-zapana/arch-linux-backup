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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let editor;
    
            ClassicEditor
                .create(document.querySelector('#description-editor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                })
                .then(newEditor => {
                    editor = newEditor;
    
                    // Sincronizar datos con Livewire
                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    });
    
                    // Establecer valor inicial desde Livewire
                    editor.setData(@this.get('product.description'));
                })
                .catch(error => {
                    console.error('Error al inicializar CKEditor:', error);
                });
    
            // Actualizar CKEditor cuando Livewire actualiza la descripción
            Livewire.on('refreshCKEditor', () => {
                if (editor) {
                    editor.setData(@this.get('product.description'));
                }
            });
        });
    </script>
    @endpush

</x-admin-layout>
