
<div class="dark:bg-gray-900 dark:text-white">
    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-700 cursor-pointer text-gray-700 dark:text-gray-300">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            <img fetchpriority="high" class="aspect-[16/9] object-cover object-center w-1/2 mx-auto" src="{{ $product->getFirstMediaUrl('images') }}" 
            alt="Imagen del producto: {{ $product->name }}" 
            class="w-full object-cover object-center" 
            width="400" height="400">
        
        </figure>

        <div class="card dark:bg-gray-800">
            <div class="mb-4">
                <x-label class="mb-1">
                    Código
                </x-label>
                <x-input wire:model="productEdit.sku" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el código del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="productEdit.name" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el nombre del producto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción
                </x-label>
                <x-textarea wire:model="productEdit.description" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese la descripción del producto">
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Precio
                </x-label>
                <x-input type="number" step="0.01" wire:model="productEdit.price" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el precio del producto" />
            </div>

            @empty($product->variants->count() > 0)
                <div class="mb-4">
                    <x-label class="mb-1">
                        Stock
                    </x-label>
                    <x-input type="number" wire:model="productEdit.stock" class="w-full dark:bg-gray-700 dark:text-gray-300"
                        placeholder="Por favor ingrese el stock del producto" />
                </div>
            @endempty


            <div class="mb-4">
                <x-label class="mb-1">
                    Familias
                </x-label>
                <x-select name="family_id" class="w-full dark:bg-gray-700 dark:text-gray-300" wire:model.live="family_id">
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
                <x-label class="mb-2">
                    Categorìas
                </x-label>
                <x-select name="category_id" class="w-full dark:bg-gray-700 dark:text-gray-300" wire:model.live="category_id">
                    <option value="" disabled>
                        Seleccione una Categoria
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-2">
                    Subcategorìas
                </x-label>
                <x-select name="category_id" class="w-full dark:bg-gray-700 dark:text-gray-300" wire:model.live="productEdit.subcategory_id">
                    <option value="" disabled>
                        Seleccione una Subcategoria
                    </option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" @selected(old('category_id') == $subcategory->id)>
                            {{ $subcategory->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <x-validation-errors class="mb-4" />

            <div class="flex justify-end space-x-2">

                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>

                <x-button>
                    Actualizar
                </x-button>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

    </form>

    @push('js')
        <script>
            function confirmDelete() {
                // 
                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, elimínelo!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {

                        document.getElementById('delete-form').submit();
                    }
                });

            }
        </script>
    @endpush
</div>
