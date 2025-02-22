<div class="bg-white dark:bg-gray-900 text-black dark:text-white">
    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800 cursor-pointer text-gray-700 dark:text-gray-300">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            <img class="aspect-[16/9] object-cover object-center w-1/2 mx-auto" src="{{ $image ? $image->temporaryUrl() : asset('img/no-image.png') }}" alt="">

        </figure>

        <div class="card bg-white dark:bg-gray-800">
            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Código
                </x-label>
                <x-input wire:model="product.sku" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el código del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Nombre
                </x-label>
                <x-input wire:model="product.name" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el nombre del producto" />
            </div>



            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Precio
                </x-label>
                <x-input type="number" step="0.01" wire:model="product.price" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el precio del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Familias
                </x-label>
                <x-select name="family_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="family_id">
                    <option value="" disabled>
                        Seleccione una Familia
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                            {{ $family->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-2 text-gray-700 dark:text-gray-300">
                    Categorías
                </x-label>
                <x-select name="category_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="category_id">
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
                <x-label class="mb-2 text-gray-700 dark:text-gray-300">
                    Subcategorías
                </x-label>
                <x-select name="category_id" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" wire:model.live="product.subcategory_id">
                    <option value="" disabled>
                        Seleccione una Subcategoría
                    </option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" @selected(old('category_id') == $subcategory->id)>
                            {{ $subcategory->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-1 text-gray-700 dark:text-gray-300">
                    Descripción
                </x-label>
                <div wire:ignore>
                    <textarea id="description-editor" class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                        placeholder="Por favor ingrese la descripción del producto">{{ $product['description'] }}</textarea>
                </div>
                @error('product.description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <x-validation-errors class="mb-4 text-red-500 dark:text-red-400" />

            <div class="flex justify-end">
                <x-button class="bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-600">
                    Crear Producto
                </x-button>
            </div>
        </div>
    </form>
</div>
