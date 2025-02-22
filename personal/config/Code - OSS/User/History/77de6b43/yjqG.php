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

<form action="{{route('admin.drivers.store')}}" method="POST">

  @csrf

  <div>
    <x-label class="mb-1">
        Usurio
    </x-label>

  </div>



</form>


</div>

</x-admin-layout>