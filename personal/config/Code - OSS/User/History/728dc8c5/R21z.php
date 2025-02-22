<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],
]">

    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.roles.create') }}">
            Nuevo
        </a>
    </x-slot>


    

</x-admin-layout>
