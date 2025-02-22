<div x-data="{ open: false }">
    <header class="bg-[#212B38] dark:bg-[#1E293B]">
        {{-- Menú de Navegación --}}
        <x-container class="px-4 py-4">
            <div class="flex justify-between items-center space-x-8">
                <button class="text-xl md:text-2xl" x-on:click="open=true" aria-label="Abrir menú de navegación">
                    <i class="fas fa-bars text-white dark:text-gray-300"></i>
                </button>
                {{-- Logo --}}
                <h1 class="text-white dark:text-gray-300">
                    <a href="/" class="inline-flex flex-col items-end">
                        <img src="{{ asset('img/logo-pchard.webp') }}" class="h-16 me-3" alt="pchard Logo" />
                    </a>
                </h1>
                {{-- Buscador --}}
                <div class="flex-1 hidden md:block">
                    <x-input oninput="search(this.value)" type="text"
                        class="w-full bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300"
                        placeholder="Buscar..." />
                </div>

                {{-- Botón de Usuario y Carrito --}}
                <div class="flex items-center space-x-4 md:space-x-8">
                    <x-dropdown>
                        <x-slot name="trigger">
                            @auth
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button class="text-xl md:text-2xl" aria-label="Iniciar sesión">
                                    <i class="fas fa-user text-white dark:text-gray-300"></i>
                                </button>
                            @endauth
                        </x-slot>
                        {{-- Contenido del dropdown --}}
                    </x-dropdown>

                    <a href="{{ route('cart.index') }}" class="relative" aria-label="Abrir carrito de compras">
                        <i class="fas fa-shopping-cart text-white dark:text-gray-300 text-xl md:text-2xl"></i>
                        <span id="cart-count"
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>
                </div>
            </div>
        </x-container>
    </header>

    <div x-show="open" x-on:click="open=false" style="display: none"
        class="fixed top-0 left-0 inset-0 bg-black opacity-25 z-10"></div>

    <div x-show="open" style="display: none" class="fixed top-0 left-0 z-20 bg-white dark:bg-gray-800">
        <div class="flex">
            <div class="w-screen md:w-80 h-screen bg-white dark:bg-gray-800">
                <div class="px-4 py-3 bg-[#212B38] dark:bg-[#1E293B] text-white dark:text-gray-300 font-semibold">
                    <div class="flex justify-between">
                        <span class="text-lg">¡Bienvenido!</span>
                        <button x-on:click="open=false" aria-label="Cerrar menú de navegación">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                {{-- Contenido del menú --}}
            </div>
        </div>
    </div>
</div>
