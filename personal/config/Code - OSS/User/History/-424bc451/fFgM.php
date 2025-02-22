<div>
    <form wire:submit="save">
        <div class="card dark:bg-gray-800 dark:text-white">
    
            <x-validation-errors class="mb-4" />
    
            <div class="mb-4">
                <x-label class="mb-2 dark:text-gray-300">
                    Familias
                </x-label>
    
                <x-select class="w-full dark:bg-gray-700 dark:text-white" wire:model.live="subcategoryEdit.family_id">
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
                <x-select name="category_id" class="w-full dark:bg-gray-700 dark:text-white" wire:model.live="subcategoryEdit.category_id">
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
                    wire:model="subcategoryEdit.name" />
            </div>
    
            <div class="flex justify-end space-x-2">
                <x-danger-button onclick="confirmDelete()" class="dark:bg-red-700">
                    Eliminar
                </x-danger-button>
                <x-button class="dark:bg-blue-700">
                    Actualizar
                </x-button>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" id="delete-form">

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
