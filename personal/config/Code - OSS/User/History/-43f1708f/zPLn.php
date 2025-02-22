<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías de blog',
    ],
]">


    <x-slot name="action">
    <a class="btn btn-blue" href="{{ route('admin.blog.categories.create') }}">
        Nuevo
    </a>
    </x-slot> 


</x-admin-layout>