<x-app-layout>
    <x-container class="px-4 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 dark:bg-gray-900 dark:text-white">
            <div class="col-span-2">
                @livewire('shipping-addresses')
            </div>

            <div class="col-span-1">
                
                @livewire('summary')
               
            </div>


        </div>
    </x-container>
</x-app-layout>
