<div>
  @switch($orde->status)
      @case(\App\Enums\OrderStatus::Pending)
          
          <button class="underline text-blue-500 hover:no-underline">

          </button>
          @break
      @case(2)
          
          @break
      @default
          
  @endswitch
</div>