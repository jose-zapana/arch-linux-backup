<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
    ],
]">


    <x-slot name="action">
    <a class="btn btn-blue" href="{{ route('admin.posts.categories.create') }}">
        Nuevo
    </a>
    </x-slot>


    



</x-admin-layout>