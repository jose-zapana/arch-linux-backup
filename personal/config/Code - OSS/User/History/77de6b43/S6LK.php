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


<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">

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
                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} 
                    {{ $user->last_name }}
                </option>
            @endforeach

        </x-select>

      </div>

    <div class="grid grid-cols-2 gap-4">

        <div> 
          <x-label class="mb-1">
            Tipo de unidad
        </x-label>

        <x-select class="w-full">

          <option value="1">
              Motocicleta
          </option>

          <option value="2">
              Automovil
          </option>

        </x-select>

        </div>

        <div>
          <x-label class="mb-1">
              Placa
          </x-label>
          <x-input class="w-full" placeholder="Ej: AAA-123" name="plate" value="{{ old('plate') }}" />
      </div>

      </div>
      







      



  </form>


</div>

</x-admin-layout>