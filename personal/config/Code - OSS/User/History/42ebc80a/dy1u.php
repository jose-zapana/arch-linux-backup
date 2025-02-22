<div>
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6 dark:bg-gray-900 dark:text-white min-h-[380px]">
        <div class="lg:col-span-5">
            <div class="flex justify-between mb-2">
                <h1 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                    Carrito de compras ({{ Cart::count() }} productos)
                </h1>
                <button class="font-semibold text-gray-600 underline hover:text-[#00a1b4] hover:no-underline dark:text-gray-300"
                    wire:click="destroy()">
                    Limpiar carro
                </button>
            </div>

            <div class="card dark:bg-gray-800">
                <ul class="space-y-4">

                    @forelse (Cart::content() as $item)
                        <li class="lg:flex lg:items-center space-y-2 lg:space-y-0  {{ $item->qty > $item->options['stock'] ? 'text-red-600' : '' }}">
                            
                            <img src="{{ $item->options->image }}" alt=""
                            class="w-full sm:w-1/2 md:w-1/3 lg:w-36 aspect-[4/3] object-cover object-center mr-2">

                            <div class="lg:w-64 xl:w-80">

                                @if ($item->qty > $item->options['stock'])
                                    <p class="font-semibold">
                                        No hay stock disponible
                                    </p>
                                @endif

                                <p class="text-sm truncate">
                                    <a href="{{ route('products.show', $item->id) }}" class="dark:text-gray-300">
                                        {{ $item->name }}
                                    </a>
                                </p>

                                <button
                                    class="bg-red-100 hover:bg-red-200 text-red-800 text-sm font-semibold rounded px-2.5 py-0.5"
                                    wire:click="remove('{{ $item->rowId }}')">
                                    <i class="fas fa-xmark"></i>
                                    Quitar
                                </button>
                            </div>

                                 <p class="dark:text-gray-300">
                                    {{ $item->price }} USD
                                </p>    

                            <div class="ml-auto space-x-3">
                                <button class="btn btn-gray dark:bg-gray-700 dark:text-gray-300" wire:click="decrease('{{ $item->rowId }}')">
                                    -
                                </button>
                                <span class="inline-block w-2 text-center dark:text-gray-300">
                                    {{ $item->qty }}
                                </span>

                                <button class="btn btn-gray dark:bg-gray-700 dark:text-gray-300" wire:click="increase('{{ $item->rowId }}')"
                                wire:loading.attr="disabled"
                                wire:target="increase('{{ $item->rowId }}')"
                                @disabled($item->qty >= $item->options['stock'])
                                >
                                    +
                                </button>
                            </div>
                        </li>
                    @empty
                        <p class="text-center dark:text-gray-300">
                            No hay productos en el carrito
                        </p>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="card dark:bg-gray-900">
                <div class="flex justify-between font-semibold mb-2">
                    <p class="dark:text-gray-300"> Subtotal </p>
                    <p class="dark:text-gray-300"> {{ $this->subtotal }} USD</p>
                </div>

                @if (Cart::count())
                    <a href="{{ route('shipping.index') }}" class="btn btn-verde block w-full text-center ">
                        Continuar compra
                    </a>
                @else
                    <a href="{{ route('welcome.index') }}" class="btn btn-verde block w-full text-center ">
                        Ir al inicio
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
