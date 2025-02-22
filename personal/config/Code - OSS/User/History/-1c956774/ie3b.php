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

                    // Sincronizar datos con Livewire usando Livewire.emit
                    editor.model.document.on('change:data', () => {
                        window.Livewire.emit('setProductDescription', editor.getData());
                    });

                    // Establecer valor inicial desde Livewire
                    editor.setData(@json($product['description']));
                })
                .catch(error => {
                    console.error('Error al inicializar CKEditor:', error);
                });

            // Actualizar CKEditor cuando Livewire actualiza la descripción
            window.Livewire.on('refreshCKEditor', (data) => {
                if (editor) {
                    editor.setData(data.description);
                }
            });
        });
    </script>
    
    @endpush

</x-admin-layout>
