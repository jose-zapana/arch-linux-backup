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
        'name' => 'Nuevo',
    ],
]">


<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">

<form action="{{route('admin.drivers.store')}}">


</form>


</div>

</x-admin-layout>