<x-dialog-modal>

  <x-slot name="title">
    {{ __('Order') }} 
  </x-slot>

  <x-slot name="content">
    
  </x-slot> 

  <x-slot name="footer">
    <x-secondary-button wire:click="$set('openModal', false)">
      {{ __('Close') }}
    </x-secondary-button>
  </x-slot>

</x-dialog-modal>