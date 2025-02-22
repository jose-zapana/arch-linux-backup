@if ($shipment->status === \App\Enums\ShipmentStatus::Pending)
    
    <button class="underline">
        Marcar como entregado
    </button>

    <button class="underline">
        Marcar como error en la entrega
    </button>

@endif