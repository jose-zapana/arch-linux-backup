<div class="dark:bg-gray-900 dark:text-gray-100">
    <div>
        <x-button class="mr-3 mb-3 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white" wire:click="$set('openModal', true)">
            <i class="fas fa-search"></i>
            <span class="ml-2">Buscar</span>
        </x-button>
    </div>

    <div>
        <x-dialog-modal wire:ignore.self wire:model="openModal">
            <x-slot name="title">
                <span class="dark:text-gray-200">Agregar Productos</span>
            </x-slot>

            <x-slot name="content">
                <x-validation-errors class="mb-4" />

                <div class="mb-4 relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <x-input class="block w-full ps-10 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        wire:model.live="search" id="modal-search-input" type="text" placeholder="Buscar..." autocapitalize="off"
                        autocorrect="off" spellcheck="false" autocomplete="off" />
                </div>

                <div class="row p-2">
                    <div class="table-responsive rounded-lg shadow hidden md:block">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th width="8%"></th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left dark:text-gray-300">NOMBRE</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left dark:text-gray-300">PRECIO</th>
                                    <th width="10%" class="p-3 text-sm font-semibold tracking-wide text-left dark:text-gray-300">
                                        CATEGORÍA
                                    </th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left dark:text-gray-300">SELECT</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($products as $product)
                                    <tr wire:key="product-{{ $product->id }}" class="bg-gray-50 dark:bg-gray-800">
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="img" height="50"
                                                width="50" class="rounded">
                                        </td>
                                        <td>
                                            <div class="p-3 text-left dark:text-gray-300 truncate">
                                                <h6><b>{{ $product->name }}</b></h6>
                                                <div class="grid grid-cols-2">
                                                    <div>
                                                        <small class="text-blue-500">{{ $product->barcode }}</small>
                                                    </div>
                                                    <div>
                                                        <small class="text-gray-700 dark:text-gray-400">Stock: {{ $product->stock }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center dark:text-gray-300">
                                            <h6><b>{{ number_format($product->price, 2) }}</b></h6>
                                        </td>
                                        <td class="text-center dark:text-gray-300">
                                            {{ $product->subcategory->category->name }}
                                        </td>
                                        <td class="text-center">
                                            <button wire:click="selectProduct({{ $product->id }})"
                                                class="btn btn-sm btn-info dark:bg-blue-600 dark:hover:bg-blue-500">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="dark:text-gray-300">SIN RESULTADOS</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-danger-button wire:click="hideModal" class="dark:bg-red-600 dark:hover:bg-red-500">
                    Cerrar
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
