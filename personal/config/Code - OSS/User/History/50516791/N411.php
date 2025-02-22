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
        'name' => $driver->user->name . ' ' . $driver->user->last_name,
    ],
]">

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">

    <x-validation-errors class="mb-4" />
  
    <form action="{{route('admin.drivers.update', $driver)}}" method="POST">
  
      @csrf
      @method('PUT')
  
        <div class="mb-4">
          <x-label class="mb-1">
              Usurio
          </x-label>
  
          <x-select class="w-full" name="user_id">
  
              <option value="" selected disabled>
                  Seleccione un usuario
              </option>
  
              @foreach ($users as $user)
                  <option value="{{ $user->id }}" @selected(old('user_id', $driver->user_id) == $user->id)>{{ $user->name }} {{ $user->last_name }}
                  </option>
              @endforeach
  
          </x-select>
  
        </div>
  
        <div class="grid grid-cols-2 gap-4 mb-4">
  
          <div> 
            <x-label class="mb-1">
                Tipo de unidad
            </x-label>
  
            <x-select class="w-full"
              name="type">
  
              <option value="1" @selected(old('type', $driver->type) == 1)>
                  Motocicleta
              </option>
  
              <option value="2" @selected(old('type', $driver->type) == 2)>
                  Automovil
              </option>
  
            </x-select>
          </div>
  
          <div>          
            <x-label class="mb-1">
                Placa
            </x-label>
            <x-input class="w-full" placeholder="Ej: AAA-123" name="plate_number" value="{{ old('plate_number', $driver->plate_number) }}" />
          </div>
        </div>
  
        <div class="flex justify-end space-x-2">

            <x-danger-button>
                Eliminar
            </x-danger-button>

            <x-button>
                Actualizar
            </x-button>
        </div>   
    </form>
  </div>

</x-admin-layout>