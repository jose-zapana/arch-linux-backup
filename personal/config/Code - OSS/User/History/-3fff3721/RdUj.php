<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Etiquetas',
    ],
]">


    <x-slot name="action">
    <a class="btn btn-blue" href="{{ route('admin.tags.create') }}">
        Nuevo
    </a>
    </x-slot>

    

    @livewire('admin.posts.tag-table')
   



</x-admin-layout>