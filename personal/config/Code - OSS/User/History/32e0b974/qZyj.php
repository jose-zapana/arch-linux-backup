<x-app-layout>
    <x-container class="px-4 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 dark:bg-gray-900 dark:text-white">
            <div class="col-span-2">
                @livewire('shipping-addresses')
            </div>

            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800">
                    <div class="bg-[#212B38] p-4 text-white flex justify-between items-center dark:bg-gray-700">
                        <p class="font-semibold text-lg dark:text-gray-300"> Resumen de Compra ({{ Cart::instance('shopping')->count() }})
                        </p>
                        <a href="{{ route('cart.index') }}" class="dark:text-gray-300">
                            <i class="fa-solid fa-cart-shopping"></i> </a>
                    </div>

                    <div class="p-4 text-gray-600 dark:text-gray-300">
                        <ul>
                            @foreach (Cart::content() as $item)
                                <li class="flex items-center space-x-4">
                                    <figure class="shrink-0">
                                        <img class="h-12 aspect-square" src="{{ $item->options->image }}"
                                            alt="">
                                    </figure>
                                    <div class="flex-1">
                                        <p class="dark:text-gray-300">
                                            {{ $item->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            {{ $item->qty }}
                                        </p>
                                        <p class="font-semibold">
                                            S/ {{ number_format($item->price * 1.18, 2) }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <a href="{{ route('checkout.index') }}"
                    class="btn bg-[#00a1b4]  text-white block w-full mt-4 text-center">Siguiente</a>
            </div>
        </div>
    </x-container>
</x-app-layout>
