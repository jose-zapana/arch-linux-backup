<div>
    <form action="{{ route('admin.users.store') }}" method="POST" id="customer-form">
        @csrf

        <div class="card">
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label for="document_type" value="{{ __('Tipo de documento') }}" />
                <x-select class="w-full" id="document_type" name="document_type" wire:model="document_type">
                    <option value="" disabled>
                        Seleccione un tipo de documento
                    </option>
                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                        <option value="{{ $item->value }}">{{ $item->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="flex mb-4 md:flex-row justify-between items-center space-x-4">
                <div class="w-full flex-1">
                    <x-label class="mb-2">
                        Numero de documento
                    </x-label>
                    <x-input class="w-full" id="numero" name="document_number" wire:model="document_number" />
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
                    <x-label class="mb-2">
                        Nombres
                    </x-label>
                    <x-input class="w-full" id="name" name="name" wire:model="name" autocomplete="off" />
                </div>
                <div class="">
                    <x-label class="mb-2">
                        Apellidos
                    </x-label>
                    <x-input class="w-full" id="last_name" name="last_name" wire:model="last_name" autocomplete="off" />
                </div>
            </div>

            <div class="mb-4">
                <x-label class="mb-2">
                    Email
                </x-label>
                <x-input class="w-full" id="email" name="email" wire:model="email" autocomplete="off" />
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Teléfono
                </x-label>
                <x-input class="w-full" id="phone" name="phone" wire:model="phone" autocomplete="off" />
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </div>
    </form>

</div>