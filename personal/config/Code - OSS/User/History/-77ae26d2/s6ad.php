<div>
    <div>
        <x-button class="mr-3 mb-3" wire:click="$set('openModal', true)">
            <i class="fas fa-search"></i>
            <span class="ml-2">
                Buscar
            </span>
        </x-button>
    </div>

    <div>
        <x-dialog-modal wire:ignore.self wire:model="openModal">

            <x-slot name="title">
                Agregar Productos

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
                    <x-input class="block w-full  ps-10 text-sm" wire:model.live="search" id="modal-search-input"
                        type="text" placeholder="Buscar..." autocapitalize="off" autocorrect="off" spellcheck="false"
                        autocomplete="off" />
                </div>

                <div class="row p-2">
                    <div class="table-responsive rounded-lg shadow hidden md:block">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">

                                <tr>
                                    <th width="8%"></th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">NOMBRE</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">PRECIO</th>
                                    <th width="10%" class="p-3 text-sm font-semibold tracking-wide text-left">
                                        CATEGORÍA
                                    </th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">
                                        SELECT
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($products as $product)
                                    <tr wire:key="product-{{ $product->id }}" class="bg-gray-50">
                                        <td>
                                            <span>
                                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="img"
                                                    heoght="50" width="50" class="rounded">
                                            </span>
                                        </td>

                                        <td>
                                            <div class="p-3 text-left">
                                                <h6><b>{{ $product->name }}</b></h6>
                                                <div class="grid grid-cols-2">
                                                    <div>
                                                        <small class="text-info text-blue-500">
                                                            {{ $product->barcode }}</small>
                                                    </div>
                                                    <div>
                                                        <small class="text-info text-gray-700">
                                                            Stock: {{ $product->stock }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <h6><b>{{ number_format($product->price, 2) }}</b></h6>
                                        </td>

                                        <td class="text-center">
                                            {{ $product->subcategory->category->name }}
                                        </td>

                                        <td class="text-center">
                                            <button wire:click="selectProduct({{ $product->id }})"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">SIN RESULTADOS</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">

                        @forelse ($products as $product)
                            <div class="bg-white space-y-2 p-4 rounded-lg shadow"
                                wire:key="product-{{ $product->id }}">




                                <div class="flex items-center space-x-6 text-sm">
                                    <div class="text-blue-500 font-blod hover:underline">

                                        <small class="text-info text-blue-500">
                                            Código: {{ $product->barcode }}</small>
                                    </div>

                                    <div class="text-gray-500">
                                        <small class="text-info text-gray-700">
                                            Stock: {{ $product->stock }}</small>

                                    </div>
                                    <div>
                                        <button class="text-violet-500 font-blod hover:underline"
                                            wire:click="selectProduct({{ $product->id }})"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-check"></i>
                                            Seleccionar
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-4">

                                    <div class="col-span-3">
                                        <div class="text-sm text-gray-700" style="word-wrap: break-word;">

                                            <small class="text-info text-blue-500">
                                                Categoría: {{ $product->subcategory->category->name }}</small>
                                        </div>

                                        <div class="text-sm text-gray-700" style="word-wrap: break-word;">
                                            Nombre: {{ $product->name }}
                                        </div>

                                        <div class="text-sm font-medium text-black flex items-center justify-end">
                                            Precio: S/ {{ number_format($product->price, 2) }}
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-center">
                                        <span class="mx-auto">
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="img"
                                                heoght="60" width="60" class="rounded">
                                        </span>
                                    </div>

                                </div>




                            </div>

                        @empty
                            <div>
                                SIN RESULTADOS
                            </div>
                        @endforelse
                    </div>
                </div>





            </x-slot>

            <x-slot name="footer">


                <div class="grid grid-cols-3 gap-4 content-center">

                    <div>

                    </div>

                    <div class="col-span-auto ">
                        <div wire:loading.inline wire:target="selectProduct">
                            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Producto Agregado</span>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="">
                        <x-danger-button wire:click="hideModal">
                            Cerrar
                        </x-danger-button>
                    </div>

                </div>




            </x-slot>

        </x-dialog-modal>

    </div>


</div>
@push('js')
    @include('livewire.admin.quotes.scripts.select2')
@endpush