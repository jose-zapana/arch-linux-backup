<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Cotizacion',
    ],
]">


    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.quotes.create') }}">
            Nuevo
        </a>
    </x-slot>

    @livewire('admin.quotes.quotation-table')


</x-admin-layout>
