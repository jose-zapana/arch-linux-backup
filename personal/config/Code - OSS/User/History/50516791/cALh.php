<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Conductores',
        'route' => route('admin.drivers.index'),
    ],  
    [
        'name' => $driver->user->name,
    ],
]">


</x-admin-layout>