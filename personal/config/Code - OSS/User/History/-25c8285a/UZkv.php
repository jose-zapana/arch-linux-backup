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
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full dark:bg-gray-700 dark:text-gray-200" placeholder="Nombres" />
                        </div>
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full dark:bg-gray-700 dark:text-gray-200" placeholder="Apellidos" />
                        </div>

                        <div>
                            <div class="flex space-x-2">
                                <x-select class="w-full dark:bg-gray-700 dark:text-gray-200">
                                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                        <option value="{{ $item->value }}">{{ $item->name }}</option>
                                    @endforeach
                                </x-select>

                                <x-input x-model="receiver_info.document_number" class="w-full dark:bg-gray-700 dark:text-gray-200" placeholder="N° de documento" />
                            </div>
                        </div>
                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full dark:bg-gray-700 dark:text-gray-200" placeholder="Teléfono" />
                        </div>
                        <div>                            
                            <button wire:click="$set('newAddress', false)" class="btn bg-indigo-500 text-white hover:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-500 disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-400 rounded-lg shadow-lg transition-all w-full mb-6">
                                Cancelar
                            </button>
                        </div>
                        <div>
                            <button wire:click="store" class="btn bg-indigo-500 text-white hover:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-500 disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-400 rounded-lg shadow-lg transition-all w-full mb-6">
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
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full dark:bg-gray-700 dark:text-gray-200"
                                placeholder="Nombres" />
                        </div>
                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full dark:bg-gray-700 dark:text-gray-200"
                                placeholder="Apellidos" />
                        </div>

                        <div>
                            <div class="md:flex md:space-x-2">

                                <x-select class="w-full dark:bg-gray-700 dark:text-gray-200">
                                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                        <option value="{{ $item->value }}">{{ $item->name }}</option>
                                    @endforeach
                                </x-select>

                                <x-input x-model="receiver_info.document_number" class="w-full dark:bg-gray-700 dark:text-gray-200"
                                    placeholder="N° de documento" />
                            </div>
                        </div>
                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full dark:bg-gray-700 dark:text-gray-200"
                                placeholder="Teléfono" />
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button wire:click="$set('editAddress', null)"
                            class="bg-indigo-500 text-white px-4 py-2 rounded-lg transition-all w-full mb-6 hover:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-500">
                            Cancelar
                        </button>

                        <button wire:click="update" class="bg-indigo-500 text-white px-4 py-2 rounded-lg transition-all w-full mb-6 hover:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-500">
                            Guardar
                        </button>
                    </div>
                </div>

                @endif
            @endif
        </div>
    </section>
</div>
