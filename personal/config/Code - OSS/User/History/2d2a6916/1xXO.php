<div>
  @switch($order->status)
      @case(\App\Enums\OrderStatus::Pending)
          
          <button class="underline text-blue-500 hover:no-underline">
              Listo para despachar
          </button>
          @break
      @case(\App\Enums\OrderStatus::Processing)
          <button class="underline text-blue-500 hover:no-underline">
            Asignar repartidor
          </button>
          @break
      @default
          
  @endswitch

  <button class="underline text-blue-500 hover:no-underline">
    Cancelar
  </button>

</div>