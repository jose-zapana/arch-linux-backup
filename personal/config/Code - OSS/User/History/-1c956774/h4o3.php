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
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .then(function(editor){
                editor.model.document.on('change:data', () => {
                    @this.set('product.description', editor.getData());
                })
            })

            .catch( error => {
                console.error( error );
            } );
    </script>

        
    @endpush
</x-admin-layout>
