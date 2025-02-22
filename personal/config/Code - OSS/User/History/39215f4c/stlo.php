@if ($shipment->status === \App\Enums\ShipmentStatus::Pending)
    
    <button class="underline text-blue-500 hover:text-blue-600 no-underline">
        Marcar como entregado
    </button>

    <button class="underline">
        Marcar como error en la entrega
    </button>

@endif