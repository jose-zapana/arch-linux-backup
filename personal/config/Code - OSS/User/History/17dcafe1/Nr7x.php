<div>
    <form wire:submit="save">
        <div class="card dark:bg-gray-800 dark:text-white">
    
            <x-validation-errors class="mb-4" />
    
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Familias
                </x-label>
    
                <x-select class="select w-full dark:bg-gray-700 dark:text-white" wire:model.live="subcategory.family_id">
                    <option value="" disabled>
                        Seleccione una familia
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">
                            {{ $family->name }}</option>
                    @endforeach
    
                </x-select>
            </div>
    
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Categorías
                </x-label>
                <x-select name="category_id" class="w-full dark:bg-gray-700 dark:text-white" wire:model.live="subcategory.category_id">
                    <option value="" disabled>
                        Seleccione una Categoría
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>
    
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Nombres
                </x-label>
                <x-input class="w-full dark:bg-gray-700 dark:text-white" placeholder="Ingrese el nombre de la subcategoría"
                    wire:model="subcategory.name" />
            </div>
    
            <div class="flex justify-end">
                <x-button class="dark:bg-gray-700 dark:text-gray-300">
                    Guardar
                </x-button>
            </div>
        </div>
    </form>

</div>
