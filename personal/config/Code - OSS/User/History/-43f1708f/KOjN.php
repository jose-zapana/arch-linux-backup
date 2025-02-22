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
    <a class="btn btn-blue" href="{{ route('admin.drivers.create') }}">
        Nuevo
    </a>
    </x-slot>


    @livewire('admin.drivers.driver-table')



</x-admin-layout>