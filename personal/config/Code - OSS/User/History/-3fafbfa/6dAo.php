<x-dialog-modal wire:model="new_shipment.openModal">

  <x-slot name="title">
    {{ __('Order Details') }} 
  </x-slot>

  <x-slot name="content">
      
    <x-label>
      Unidad
    </x-label>

    <x-select class="w-full" wire:model="new_shipment.unit">
    
  </x-slot> 

  <x-slot name="footer">

  </x-slot>

</x-dialog-modal>