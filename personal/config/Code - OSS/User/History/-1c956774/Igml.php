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

        
    @endpush
</x-admin-layout>
