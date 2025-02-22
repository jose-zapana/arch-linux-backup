<div>
    <form wire:submit="addFeature" class="flex space-x-4">
        <div class="flex-1">
            <x-label class="mb-1 dark:text-gray-300">
                Valor
            </x-label>

            @switch($option->type)
                @case(1)
                    <x-input class="w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Ingrese el valor de la opción" wire:model="newFeature.value" />
                @break

                @case(2)
                    <div class="border border-gray-300 dark:border-gray-700 h-[42px] rounded-md flex items-center justify-between px-3 dark:bg-gray-800 dark:text-gray-300">
                        {{ $newFeature['value'] ?: 'Seleccione un color' }}
                        <input type="color" wire:model.live="newFeature.value">
                    </div>
                @break

                @default
            @endswitch
        </div>

        <div class="flex-1">
            <x-label class="mb-1 dark:text-gray-300">
                Descripción
            </x-label>
            <x-input class="w-full dark:bg-gray-700 dark:text-gray-300" placeholder="Ingrese la descripción de la opción"
                wire:model.live="newFeature.description" />
        </div>

        <div class="pt-7">
            <x-button class="dark:bg-gray-700 dark:text-white">
                Agregar
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mb-4 dark:text-gray-300" />
</div>
