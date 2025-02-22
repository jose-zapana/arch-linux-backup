<div class="flex flex-col space-y-2">
    @switch($data->status)
        @case(\App\Enums\QuotationStatus::Pending)
            <button 
            wire:click="markAsSent({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Enviar Cotización
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Processing)
            <button 
            wire:click="acceptQuotation({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Aceptar Cotización
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Accepted)
            <button 
            wire:click="generateOrder({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Convertir en Orden
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Rejected)
            <button 
            wire:click="markAsCancelled({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Marcar como Rechazada
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Expired)
            <button 
            wire:click="markAsExpired({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Marcar como Expirada
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Cancelled)
            <button 
            wire:click="reopenQuotation({{ $data->id }})"
            class="underline text-blue-500 hover:no-underline">
                Reabrir Cotización
            </button>
            @break
  
        @default
            {{-- Sin acciones disponibles --}}
    @endswitch
  
    @if ($data->status != \App\Enums\QuotationStatus::Cancelled)
        <button 
        wire:click="cancelQuotation({{ $data->id }})"
        class="underline text-blue-500 hover:no-underline">
            Cancelar Cotización
        </button>
    @endif
</div>
