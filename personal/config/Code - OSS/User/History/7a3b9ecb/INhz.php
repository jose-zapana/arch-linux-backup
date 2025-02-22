<div>    
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800">
        <!-- Header -->
        <div class="bg-[#212B38] p-4 text-white flex justify-between items-center dark:bg-gray-800">
            <p class="font-semibold text-lg md:text-xl dark:text-gray-300">
                Resumen de Compra ({{ Cart::instance('shopping')->count() }})
            </p>
            <a href="{{ route('cart.index') }}" class="text-white hover:text-gray-300 transition">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>

        <!-- Cart Items -->
        <div class="p-4 text-gray-600 dark:text-gray-300">
            <ul>
                @foreach (Cart::content() as $item)
                    <li class="flex items-center space-x-4 mb-4">
                        <figure class="shrink-0">
                            <img class="h-12 w-12 object-cover rounded" 
                                 src="{{ $item->model->getFirstMediaUrl('images', 'thumb') ?: asset('img/no-image.png') }}" 
                                 alt="{{ $item->name }}">
                        </figure>
                        <div class="flex-1">
                            <p class="text-base md:text-lg dark:text-gray-300">
                                {{ $item->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-base md:text-lg dark:text-gray-300">
                               cant. {{ $item->qty }}
                            </p>
                            <p class="font-semibold text-base md:text-lg dark:text-gray-300">
                                {{ $item->price }} USD
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-span-1">
        @if ($addresses->count() && !$editAddress->id)
            <a href="{{ route('checkout.index') }}" 
               class="btn bg-indigo-500 text-white block w-full mt-4 py-2 text-center text-base md:text-lg hover:bg-indigo-600 transition">
                Siguiente
            </a>
        @elseif (!$addresses->count())
            <p class="text-center">Para continuar con la compra, agregue una dirección de envío</p>
        @endif
    </div>
    
</div>
