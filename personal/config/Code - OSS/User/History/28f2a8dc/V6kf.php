<div>
    <form action="{{ route('admin.users.store') }}" method="POST" id="customer-form">
        @csrf

        <div class="card bg-white dark:bg-gray-800">
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label for="document_type" value="{{ __('Tipo de documento') }}" class="dark:text-gray-300" />
                <x-select class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                          id="document_type" 
                          name="document_type" 
                          wire:model="document_type">
                    <option value="" disabled class="dark:bg-gray-700 dark:text-gray-200">
                        Seleccione un tipo de documento
                    </option>
                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                        <option value="{{ $item->value }}" class="dark:bg-gray-700 dark:text-gray-200">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="flex mb-4 md:flex-row justify-between items-center space-x-4">
                <div class="w-full flex-1">
                    <x-label class="mb-2 dark:text-gray-300">
                        Número de documento
                    </x-label>
                    <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                             id="numero" 
                             name="document_number" 
                             autocomplete="off"
                             wire:model="document_number" />
                </div>
                <div class="flex mt-6">
                    <a class="btn btn-blue" id="buscar" wire:click="searchCustomer"
                        @if ($document_type != '1' && $document_type != '3') disabled @endif>
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="">
                    <x-label class="mb-2 dark:text-gray-300">
                        Nombres
                    </x-label>
                    <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                             id="name" 
                             name="name" 
                             wire:model="name" 
                             autocomplete="off" 
                             :disabled="!$document_number" /> <!-- Deshabilitar si hay documento -->
                </div>
                <div class="">
                    <x-label class="mb-2 dark:text-gray-300">
                        Apellidos
                    </x-label>
                    <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                             id="last_name" 
                             name="last_name" 
                             wire:model="last_name" 
                             autocomplete="off" 
                             :disabled="!$document_number" /> <!-- Deshabilitar si hay documento -->
                </div>
            </div>

            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Email
                </x-label>
                <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                         id="email" 
                         name="email" 
                         wire:model="email" 
                         autocomplete="off" />
            </div>
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Teléfono
                </x-label>
                <x-input class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-400" 
                         id="phone" 
                         name="phone" 
                         wire:model="phone" 
                         autocomplete="off" />
            </div>

            <div class="flex justify-end">
                <x-button class="dark:bg-blue-700 dark:hover:bg-blue-800">
                    Guardar
                </x-button>
            </div>
        </div>
    </form>
</div>
