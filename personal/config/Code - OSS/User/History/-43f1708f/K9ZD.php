<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Publicacioness',
    ],
]">


    <x-slot name="action">
    <a class="btn btn-blue" href="{{ route('admin.blog.categories.create') }}">
        Nuevo
    </a>
    </x-slot> 


</x-admin-layout>