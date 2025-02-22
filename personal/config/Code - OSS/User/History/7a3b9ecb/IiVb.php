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

    <div>
        @if($addresses && count($addresses) > 0)
            <div class="bg-white p-4 rounded-lg shadow dark:bg-gray-800">
                <h2 class="text-xl font-semibold dark:text-gray-300">Direcciones de Envío</h2>
                <ul class="mt-4">
                    @foreach($addresses as $address)
                        <li class="mb-4">
                            <p class="text-base dark:text-gray-300">
                                Hola
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-yellow-100 p-4 rounded-lg shadow dark:bg-gray-700">
                <p class="text-base text-yellow-800 dark:text-yellow-300">No tienes direcciones registradas. Añade una dirección para continuar con tu compra.</p>
            </div>
        @endif
    </div>


</div>
