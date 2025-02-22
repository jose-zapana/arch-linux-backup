<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Entradas del blog', 'route' => route('admin.blogs.index')],
    ['name' => 'Nuevo']
]">

    @include('admin.blogs.partials.form')

    @push('js')

    <!-- CKEditor --> 
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script> 
    <!-- Scripts personalizados --> 
    <script src="{{ asset('js/scripts/ckeditor-init.js') }}"></script> <script src="{{ asset('js/scripts/slug-generator.js') }}"></script> <script src="{{ asset('js/scripts/image-preview.js') }}"></script>

    @endpush
</x-admin-layout>
