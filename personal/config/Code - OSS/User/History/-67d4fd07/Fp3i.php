<div class="lg:col-span-5">
  <div class="flex justify-between font-semibold mb-2">



      <h5 class=" font-semibold text-gray-600" id="cart-count">
          Artículos: {{ Cart::count() }}
      </h5>

      <button class="font-semibold text-gray-600 underline hover:text-[#00a1b4] hover:no-underline"
          wire:click="destroy()">
          Limpiar Todo
      </button>
  </div>
  <div>

      @if (Cart::count() > 0)

          <div class="overflow-auto rounded-lg md:lg:h-[450px] lg:h-[650px] shadow hidden md:block">

              <table class="table">

                  <thead class="bg-gray-50 border-b-2 border-gray-200">
                      <tr>

                          <th></th>
                          <th>DESCRIPCIÓN</th>
                          <th>PRECIO</th>
                          <th>CANT</th>
                          <th>IMPORTE</th>
                          <th>ACTIONS</th>

                      </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-100">
                      @foreach (Cart::content() as $item)
                          <tr class="bg-white" wire:key="cart-{{ $item->rowId }}">
                              <td class="text-center table-th">
                                  <img class="w-full lg:w-40 aspect-[16/9] rounded object-cover object-center"
                                      src="{{ $item->options->image }}" alt="" height="90" width="90">
                              </td>
                              <td>
                                  <h6>{{ $item->name }}</h6>
                              </td>
                              <td>
                                  S/ {{ number_format($item->price, 2) }}
                              </td>
                              <td>

                                  <h6>{{ $item->qty }}</h6>
                              </td>
                              <td>
                                  <h6>
                                      S/ {{ number_format($item->price * $item->qty, 2) }}
                                  </h6>
                              </td>
                              <td>

                                  <button wire:click.live="decrease('{{ $item->rowId }}')"
                                      class="btn btn-sm btn-warning">
                                      <i class="fa fa-minus"></i>
                                  </button>

                                  <button wire:click.live="increase('{{ $item->rowId }}')"
                                      class="btn btn-sm btn-warning">
                                      <i class="fa fa-plus"></i>
                                  </button>

                                  <button class="btn btn-sm  font-bold text-red-600"
                                      wire:click="remove('{{ $item->rowId }}')">
                                      <i class="fa fa-trash"></i>
                                  </button>

                              </td>
                          </tr>
                      @endforeach

                  </tbody>

              </table>

          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">

              @foreach (Cart::content() as $item)
                  <div class="bg-white space-y-2 p-4 rounded-lg shadow" wire:key="cart-{{ $item->rowId }}">


                      <div class="flex items-center space-x-2 text-sm">
                          <div class="text-blue-500 font-blod hover:underline">
                              Cant: {{ $item->qty }}
                          </div>
                          <div class="text-gray-500">

                              <button wire:click.prevent="decrease('{{ $item->rowId }}')"
                                  class="btn btn-sm btn-warning">
                                  <i class="fa fa-minus"></i>
                              </button>


                              <button wire:click.prevent="increase('{{ $item->rowId }}')"
                                  class="btn btn-sm btn-warning">
                                  <i class="fa fa-plus"></i>
                              </button>


                          </div>
                          <div>
                              <button class="btn btn-sm  font-bold text-red-600"
                                  wire:click="remove('{{ $item->rowId }}')">
                                  <i class="fa fa-trash"></i>
                              </button>
                          </div>
                      </div>

                      <div class="text-sm text-gray-700" style="word-wrap: break-word;">
                          {{ $item->name }}
                      </div>
                      <div class="text-sm font-medium text-black">S/ {{ number_format($item->price, 2) }}
                      </div>
                  </div>
              @endforeach
          </div>
      @else
          <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
              role="alert">
              <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor" viewBox="0 0 20 20">
                  <path
                      d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
              </svg>
              <span class="sr-only">Info</span>
              <div>
                  <span class="font-medium">Info!</span> No hay items en la cotización actual
              </div>
          </div>

      @endif

      <div wire:loading.inline wire:target="saveSale">
          <h4 class="text-center text-danger">Guardando Venta...</h4>
      </div>

  </div>
</div>