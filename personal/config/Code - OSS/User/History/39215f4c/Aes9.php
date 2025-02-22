@if ($shipment->status === \App\Enums\ShipmentStatus::Pending)
    
    <button class="underline hover:no-underline text-blue-500 hover:text-blue-600">
        Marcar como entregado
    </button>

    <button class="underline">
        Marcar como error en la entrega
    </button>

@endif