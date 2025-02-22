<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Conductores',
    ],
]">


<x-slot name="action">
  <a class="btn btn-blue" href="{{ route('admin.drivers.create') }}">
      Nuevo
  </a>
</x-slot>


</x-admin-layout>