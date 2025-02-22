<div x-data="{ open: false }">
    <header class="bg-[#212B38] dark:bg-[#1E293B]">
        {{-- Menu de Navegación --}}
        <x-container class="px-4 py-4">
            <div class="flex justify-between items-center space-x-8">
                <button class="text-xl md:text-2xl" x-on:click="open=true">
                    <i class="fas fa-bars text-white dark:text-gray-300"></i>
                </button>
                {{-- Logo --}}
                <h1 class="text-white dark:text-gray-300">
                    <a href="/" class="inline-flex flex-col items-end">
                        <img src="{{ asset('img/logo.png') }}" class="h-16 me-3" alt="pchard Logo" />
                    </a>
                </h1>
                {{-- Buscador --}}
                <div class="flex-1 hidden md:block">
                    <x-input oninput="search(this.value)" type="text" class="w-full bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300" placeholder="Buscar..." />
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
                                <button class="text-xl md:text-2xl">
                                    <i class="fas fa-user text-white dark:text-gray-300"></i>
                                </button>
                            @endauth
                        </x-slot>
                        <x-slot name="content">
                            @guest
                                <div class="px-4 py-2 bg-gray-800 dark:bg-gray-900">
                                    <div class="flex justify-center">
                                        <a href="{{ route('login') }}" class="btn btn-verde mb-2">
                                            Iniciar sesión
                                        </a>
                                    </div>
                                    <p class="text-sm text-center mt text-gray-300 dark:text-gray-400">
                                        ¿No tienes cuenta?
                                        <a href="{{ route('register') }}"
                                            class="text-[#00a1b4] hover:underline mb-2 font-semibold">
                                            Regístrate
                                        </a>
                                    </p>
                                </div>
                            @else
                                <x-dropdown-link :href="route('profile.show')" class="text-gray-700 dark:text-gray-300">
                                    Mi perfil
                                </x-dropdown-link>

                                <div class="border-t border-gray-200 dark:border-gray-700">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-gray-700 dark:text-gray-300">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            @endguest
                        </x-slot>
                    </x-dropdown>

                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fas fa-shopping-cart text-white dark:text-gray-300 text-xl md:text-2xl"></i>
                        <span id="cart-count"
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>
                </div>

                <div class="mt-4 md:hidden">
                    <x-input oninput="search(this.value)" type="text" class="w-full bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300" placeholder="Buscar..." />
                </div>
            </div>
        </x-container>
    </header>

    <div x-show="open" x-on:click="open=false" style="display: none"
        class="fixed top-0 left-0 inset-0 bg-black opacity-25 z-10">
    </div>

    <div x-show="open" style="display: none" class="fixed top-0 left-0 z-20">
        <div class="flex">
            <div class="w-screen md:w-80 h-screen bg-white dark:bg-gray-800">
                <div class="px-4 py-3 bg-[#212B38] dark:bg-[#1E293B] text-white dark:text-gray-300 font-semibold">
                    <div class="flex justify-between">
                        <span class="text-lg">
                            ¡Bienvenido!
                        </span>
                        <button x-on:click="open=false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="h-[calc(100vh-52px)] overflow-auto dark:text-white">
                    <ul>
                        @foreach ($families as $family)
                            <li wire:mouseover="set('family_id', {{ $family->id }})">
                                <a href="{{ route('families.show', $family) }}"
                                    class="flex px-4 py-4 items-center justify-between hover:bg-gray-200 dark:hover:bg-gray-700">
                                    {{ $family->name }}
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-80 xl:w-[57rem] pt-[52px] hidden md:block">
                <div class="bg-white dark:bg-gray-800 h-[calc(100vh-52px)] overflow-auto px-6 py-8">
                    <div class="mb-8 flex justify-between items-center">
                        {{-- Cabecera sidabear --}}
                        <p class="border-b-[3px] border-[#00a1b4] font-semibold text-lg uppercase pb-1 text-gray-700 dark:text-gray-300">
                            {{ $this->familyName }}
                        </p>
                        <a href="{{ route('families.show', $family_id) }}" class="btn btn-verde">
                            Ver todo
                        </a>
                    </div>
                    <ul class="grid grid-cols-1 xl:grid-cols-3">
                        @foreach ($this->categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category) }}"
                                    class="text-[#00a1b4] font-semibold text-lg">
                                    {{ $category->name }}
                                </a>
                                <ul class="mt-4 space-y-2">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{ route('subcategories.show', $subcategory) }}"
                                                class="text-gray-600 dark:text-gray-400 text-sm hover:text-[#00a1b4]">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            Livewire.on('cartUpdated', (count) => {
                document.getElementById('cart-count').innerText = count;
            })

            function search(value) {
                Livewire.dispatch('search', {
                    search: value
                })
            }
        </script>
    @endpush
</div>
