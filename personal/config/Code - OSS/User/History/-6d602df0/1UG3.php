<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
    ],
]">

    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.users.create') }}">
            Nuevo
        </a>
    </x-slot>

    @livewire('admin.users.user-table')



</x-admin-layout>
