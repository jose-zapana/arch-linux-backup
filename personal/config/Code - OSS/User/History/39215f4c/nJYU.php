@if ($shipment->status === \App\Enums\ShipmentStatus::Pending)
    
    <button class="underline hover:no-underline text-blue-500 hover:text-blue-700">
        Marcar como entregado
    </button>

    <br>

    <button class="underline hover:no-underline text-blue-500 hover:text-blue-700">
        Marcar como error en la entrega
    </button>

@endif