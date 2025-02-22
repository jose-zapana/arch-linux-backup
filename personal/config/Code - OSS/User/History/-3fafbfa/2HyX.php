<x-dialog-modal wire:model="new_shipment.openModal">

  <x-slot name="title">
    {{ __('Order Details') }} 
  </x-slot>

  <x-slot name="content">
      
    <x-label>
      Unidad
    </x-label>

    <x-select class="w-full" wire:model="new_shipment.driver_id">

      <option value="">Seleccione una Unidad</option>

      @foreach ($drivers as $driver)
        <option value="{{ $driver->id }}">
          {{ $driver->user->name }} {{ $driver->user->last_name }}
        </option>
      @endforeach

    </x-select>

    <x-input-error for="new_shipment.driver_id" />
    
  </x-slot> 

  <x-slot name="footer">

    <x-danger-button>
      Cancelar
    </x-danger-button>

    <x-button>
      Asignar
    </x-button>

  </x-slot>

</x-dialog-modal>