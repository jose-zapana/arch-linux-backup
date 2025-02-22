<x-dialog-modal wire:model="new_shipment.openModal">

  <x-slot name="title">
    {{ __('Order Details') }} 
  </x-slot>

  <x-slot name="content">
      
    <x-label>
      Unidad
    </x-label>

    <x-select class="w-full" wire:model="new_shipment.driver_id">

      <option value="">{{ __('Select') }}</option>

      @foreach ($drivers as $driver)
        <option value="{{ $driver->id }}">
          {{ $driver->name }}
        </option>
      @endforeach

    </x-select>
    
  </x-slot> 

  <x-slot name="footer">

  </x-slot>

</x-dialog-modal>