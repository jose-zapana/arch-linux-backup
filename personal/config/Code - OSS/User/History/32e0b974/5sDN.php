<x-app-layout>
    <x-container class="px-4 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 dark:bg-gray-900 dark:text-white">
            <div class="col-span-2">
                @livewire('shipping-addresses')
            </div>

            <div class="col-span-1">
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
                                        <img class="h-12 w-12 object-cover rounded" src="{{ $item->options->image }}" alt="">
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
                                            S/ {{ number_format($item->price * 1.18, 2) }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                
                @if ($addresses->count())

                @endif
                <a href="{{ route('checkout.index') }}" class="btn bg-[#00a1b4] text-white block w-full mt-4 py-2 text-center text-base md:text-lg hover:bg-[#008c95] transition">
                    Siguiente
                </a>

                
            </div>
        </div>
    </x-container>
</x-app-layout>
