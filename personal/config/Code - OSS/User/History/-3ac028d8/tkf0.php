<div class="flex flex-col space-y-2">
    @switch($quotaId->status)
        @case(\App\Enums\QuotationStatus::Pending)
            <button 
            wire:click="markAsSent({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Enviar Cotización
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Processing)
            <button 
            wire:click="acceptQuotation({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Aceptar Cotización
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Accepted)
            <button 
            wire:click="generateOrder({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Convertir en Orden
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Rejected)
            <button 
            wire:click="markAsCancelled({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Marcar como Rechazada
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Expired)
            <button 
            wire:click="markAsExpired({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Marcar como Expirada
            </button>
            @break
  
        @case(\App\Enums\QuotationStatus::Cancelled)
            <button 
            wire:click="reopenQuotation({{ $quotaId->id }})"
            class="underline text-blue-500 hover:no-underline">
                Reabrir Cotización
            </button>
            @break
  
        @default
            {{-- Sin acciones disponibles --}}
    @endswitch
  
    @if ($quotaId->status != \App\Enums\QuotationStatus::Cancelled)
        <button 
        wire:click="cancelQuotation({{ $quotaId->id }})"
        class="underline text-blue-500 hover:no-underline">
            Cancelar Cotización
        </button>
    @endif
</div>
