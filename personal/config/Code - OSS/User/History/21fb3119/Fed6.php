<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Cotizaciones',
        'route' => route('admin.quotes.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    @livewire('admin.quotes.quotation-create')

</x-admin-layout>


@push('js')
    @include('livewire.admin.quotes.scripts.shortcuts')
    @include('livewire.admin.quotes.scripts.general')
    @include('livewire.admin.quotes.scripts.select2')
@endpush
