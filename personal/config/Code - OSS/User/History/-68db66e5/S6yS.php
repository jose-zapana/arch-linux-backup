<div class="bg-white dark:bg-gray-900 py-12">
    <x-container class="px-4 md:flex">
        <aside class="md:w-52 md:flex-shrink-0 md:mr-8 mb-8 md:mb-0">
            <ul class="space-y-4">
                @forelse ($options as $option)
                    <li x-data="{ open: false }">
                        <button @click="open = !open"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-800 w-full text-left text-gray-700 dark:text-gray-300 flex justify-between items-center">
                            {{ $option['name'] }}
                            <i :class="{ 'fa-solid fa-angle-down': open, 'fa-solid fa-angle-right': !open }"></i>
                        </button>
                        <ul class="mt-2 space-y-2" x-show="open">
                            @foreach ($option['features'] as $feature)
                                <li>
                                    <label class="inline-flex items-center text-gray-700 dark:text-gray-300">
                                        <x-checkbox value="{{ $feature['id'] }}" wire:model.live="selected_features"
                                            class="mr-2" />
                                        {{ $feature['description'] }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @empty
                    <!-- Si no hay opciones disponibles, mostrar un mensaje o contenido alternativo -->
                    <li class="text-gray-700 dark:text-gray-300">No hay opciones disponibles</li>
                @endforelse
            </ul>
        </aside>
        <div class="md:flex-1">

            <div class="flex items-center">
                <span class="mr-2 text-gray-700 dark:text-gray-300">
                    Ordenar por:
                </span>
                <x-select wire:model.live="orderBy" class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <option value="1">
                        Relevancia
                    </option>
                    <option value="2">
                        Precio: Mayor - Menor
                    </option>
                    <option value="3">
                        Precio: Menor - Mayor
                    </option>
                </x-select>
            </div>
            <hr class="my-4 border-gray-300 dark:border-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <article class="bg-white dark:bg-gray-800 shadow rounded overflow-hidden">
                        <img src="{{ $product->image }}" alt="" class="w-full h-48 object-cover object-center">
                        <div class="p-4">
                            <h1 class="text-lg text-gray-700 dark:text-gray-300 font-bold line-clamp-2 min-h-[56px]">
                                {{ $product->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                S/ {{ number_format($product->price * 1.18, 2) }}
                            </p>
                            <a href="{{ route('products.show', $product) }}"
                                class="btn btn-verde block w-full text-center">
                                Ver más
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </x-container>
</div>
