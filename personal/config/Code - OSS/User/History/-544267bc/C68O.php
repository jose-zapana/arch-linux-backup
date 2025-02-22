<div class="card mt-4">

  <div class="flex justify-between font-semibold mb-2">
      <p> Subtotal </p>
      <p> S/ {{ Cart::subtotal() }}</p>
  </div>
  <div class="flex justify-between font-semibold mb-2">
      <p> IGV </p>
      <p> S/ {{ Cart::tax() }}</p>
  </div>
  <hr class="w-full">
  <div class="flex justify-between font-semibold mb-2">
      <p> Total </p>
      <p> S/ {{ Cart::total() }}</p>
  </div>



  <x-button class="w-full" wire:click="store">
      Crear Cotización
  </x-button>


</div>