<div>
    <section class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-4">
        <header class="bg-[#212B38] dark:bg-gray-800 px-4 py-2">
            <h2 class="text-white dark:text-gray-200 text-lg md:text-xl font-semibold">
                Direcciones de envío guardadas
            </h2>
        </header>

        <div class="p-4 lg:col-span-5">
            @if ($newAddress)
                <x-validation-errors class="mb-4" />

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    {{-- Tipo --}}
                    <div class="col-span-1">
                        <x-select wire:model="createAddress.type" class="w-full dark:bg-gray-700 dark:text-gray-200">
                            <option value="">Tipo de dirección</option>
                            <option value="1">Domicilio</option>
                            <option value="2">Oficina</option>
                        </x-select>
                    </div>
                    {{-- Descripción --}}
                    <div class="col-span-3">
                        <x-input wire:model="createAddress.description" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text" placeholder="Ingrese la dirección" />
                    </div>
                    {{-- Distrito --}}
                    <div class="col-span-2">
                        <x-input wire:model="createAddress.district" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text" placeholder="Ingrese el distrito" />
                    </div>
                    {{-- Referencia --}}
                    <div class="col-span-2">
                        <x-input wire:model="createAddress.reference" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text" placeholder="Ingrese la referencia" />
                    </div>
                </div>

                <hr class="my-4 dark:border-gray-700">

                <div x-data="{
                    receiver: @entangle('createAddress.receiver'),
                    receiver_info: @entangle('createAddress.receiver_info')
                
                }" x-init="$watch('receiver', value => {
                    if (value == 1) {
                        receiver_info.name = '{{ auth()->user()->name }}';
                        receiver_info.last_name = '{{ auth()->user()->last_name }}';
                        receiver_info.document_type = '{{ auth()->user()->document_type }}';
                        receiver_info.document_number = '{{ auth()->user()->document_number }}';
                        receiver_info.phone = '{{ auth()->user()->phone }}';
                
                    } else {
                        receiver_info.name = '';
                        receiver_info.last_name = '';
                        receiver_info.document_number = '';
                        receiver_info.phone = '';
                
                    }
                })">

                    <p class="font-semibold mb-2 dark:text-gray-300">
                        ¿Quién recibirá el pedido?
                    </p>

                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mb-4">
                        <label class="flex items-center dark:text-gray-300">
                            <input x-model="receiver" type="radio" value="1" class="mr-2">
                            Seré yo
                        </label>
                        <label class="flex items-center dark:text-gray-300">
                            <input x-model="receiver" type="radio" value="2" class="mr-2">
                            Otra persona
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                placeholder="Nombres" />
                        </div>
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full"
                                placeholder="Apellidos" />
                        </div>

                        <div>
                            <div class="flex space-x-2">

                                <x-select>

                                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                        <option value="{{ $item->value }}">{{ $item->name }}</option>
                                    @endforeach

                                </x-select>

                                <x-input x-model="receiver_info.document_number" class="w-full"
                                    placeholder="N° de documento" />

                            </div>
                        </div>
                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full" placeholder="Teléfono" />
                        </div>
                        <div>                            
                            <button wire:click="$set('newAddress', false)" class="btn btn-outline-gray w-full dark:text-gray-200 dark:border-gray-700">
                                Cancelar
                            </button>
                        </div>
                        <div>
                            <button wire:click="store" class="btn btn-verde w-full">
                                Guardar
                            </button>
                        </div>

                    </div>

                </div>
            @else

                @if ($editAddress->id)

                <x-validation-errors class="mb-4" />

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    {{-- Tipo --}}
                    <div class="col-span-1">                            
                        <x-select wire:model="editAddress.type" class="w-full dark:bg-gray-700 dark:text-gray-200">      
                            <option value=""> Tipo de dirección</option>
                            <option value="1"> Domicilio</option>
                            <option value="2"> Oficina</option>
                        </x-select>
                    </div>
                    {{-- Descripción --}}
                    <div class="col-span-3">
                        <x-input wire:model="editAddress.description" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text" placeholder="Ingrese la dirección" />
                    </div>
                    {{-- Distrito --}}
                    <div class="col-span-2">
                        <x-input wire:model="editAddress.district" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text"
                            placeholder="Ingrese la Distrito" />
                    </div>
                    {{-- Referencia --}}
                    <div class="col-span-2">
                        <x-input wire:model="editAddress.reference" class="w-full dark:bg-gray-700 dark:text-gray-200" type="text"
                            placeholder="Ingrese la referencia" />
                    </div>
                </div>

                <hr class="my-4 dark:border-gray-700">

                <div x-data="{
                    receiver: @entangle('editAddress.receiver'),
                    receiver_info: @entangle('editAddress.receiver_info')
                
                }" x-init="$watch('receiver', value => {
                    if (value == 1) {
                        receiver_info.name = '{{ auth()->user()->name }}';
                        receiver_info.last_name = '{{ auth()->user()->last_name }}';
                        receiver_info.document_type = '{{ auth()->user()->document_type }}';
                        receiver_info.document_number = '{{ auth()->user()->document_number }}';
                        receiver_info.phone = '{{ auth()->user()->phone }}';
                
                    } else {
                        receiver_info.name = '';
                        receiver_info.last_name = '';
                        receiver_info.document_number = '';
                        receiver_info.phone = '';
                
                    }
                })">

                    <p class="font-semibold mb-2 dark:text-gray-300">
                        ¿Quién recibirá el pedido?
                    </p>

                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mb-4">
                        <label class="flex items-center dark:text-gray-300">
                            <input x-model="receiver" type="radio" value="1" class="mr-1">
                            Seré yo
                        </label>

                        <label x-model="receiver" class="flex items-center dark:text-gray-300">
                            <input x-model="receiver" type="radio" value="2" class="mr-1">
                            Otra persona
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                placeholder="Nombres" />
                        </div>
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full"
                                placeholder="Apellidos" />
                        </div>

                        <div>
                            <div class="md:flex md:space-x-2">

                                <x-select class="w-full dark:bg-gray-700 dark:text-gray-200">

                                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                        <option value="{{ $item->value }}">{{ $item->name }}</option>
                                    @endforeach

                                </x-select>
                                <x-input x-model="receiver_info.document_number" class="w-full mt-2 md:mt-0 dark:bg-gray-700 dark:text-gray-200" placeholder="N° de documento" />
                            </div>
                        </div>
                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full dark:bg-gray-700 dark:text-gray-200" placeholder="Teléfono" />
                        </div>
                        <div>
                            <button wire:click="$set('editAddress.id', null)" class="btn btn-outline-gray w-full dark:text-gray-200 dark:border-gray-700">
                                Cancelar
                            </button>
                        </div>
                        <div>
                            <button wire:click="update()" class="btn btn-verde w-full">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
                @else                
                
                            
                    @if ($addresses->count())
                        <ul class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            @foreach ($addresses as $address)
                                <li class="{{ $address->default ? 'bg-[#92f4ff]' : 'bg-white' }} rounded-lg shadow"
                                    wire:key="addresses-{{ $address->id }}">

                                    <div class="p-4 flex items-center">
                                        <div>
                                            <i class="fa-solid fa-location-dot text-[#00a1b4]"></i>
                                        </div>
                                        <div class="flex-1 mx-4 text-xs">

                                            <p class="text-[#00a1b4]">
                                                {{ $address->type == 1 ? 'Domicilio' : 'Oficina' }}
                                            </p>
                                            <p class="text-gray-700 font-semibold">
                                                {{ $address->district }}
                                            </p>
                                            <p class="text-gray-700 font-semibold">
                                                {{ $address->description }}
                                            </p>
                                            <p class="text-gray-700 font-semibold">
                                                {{ $address->receiver_info['name'] . ' ' . $address->receiver_info['last_name'] }}
                                            </p>

                                        </div>
                                        <div class="text-xs text-gray-800 flex flex-col">
                                            <button wire:click="setDefaultAddress({{ $address->id }})"><i
                                                    class="fa-solid fa-star text-xs"></i></button>

                                            <button
                                                wire:click="edit({{ $address->id }})"><i class="fa-solid fa-pencil text-xs"></i></button>

                                            <button wire:click="deleteAddress({{ $address->id }})"><i
                                                    class="fa-solid fa-trash-can text-xs"></i></button>

                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">
                            No se ha encontrado ninguna dirección de envío
                        </p>
                    @endif

                    <button class="btn btn-outline-gray w-full flex items-center justify-center mt-4 dark:text-white"
                        wire:click="$set('newAddress', true)">
                        Agregar
                        <i class="fa-solid fa-plus ml-2"></i>
                    </button>                
                @endif
            @endif
        </div>
    </section>

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
                
        <a href="{{ route('checkout.index') }}" class="btn bg-[#00a1b4] text-white block w-full mt-4 py-2 text-center text-base md:text-lg hover:bg-[#008c95] transition">
            Siguiente
        </a>
        @else

        <p class="text-center">Para continuar con la compra agrege la dirección de envío</p>

        @endif
        
    </div>
</div>
