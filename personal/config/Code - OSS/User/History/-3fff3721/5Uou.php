<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías del blog',
    ],
]">


    <x-slot name="action">
    <a class="btn btn-blue" href="{{ route('admin.posts.categories.create') }}">
        Nuevo
    </a>
    </x-slot>

    

    @livewire('admin.posts.category-table')
   



</x-admin-layout>