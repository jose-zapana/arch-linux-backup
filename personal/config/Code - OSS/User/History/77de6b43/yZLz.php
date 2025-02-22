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

    <div class="mb-4">
      <x-label class="mb-1">
          Usurio
      </x-label>

      <x-select class="w-full">

          <option value="" selected disabled>
              Seleccione un usuario
          </option>

          @foreach ($users as $user)
              <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
          @endforeach

      </x-select>

    </div>



</form>


</div>

</x-admin-layout>