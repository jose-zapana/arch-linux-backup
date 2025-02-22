
<div class="dark:bg-gray-900 dark:text-white">
    <form wire:submit="store">
        {{-- <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-700 cursor-pointer text-gray-700 dark:text-gray-300">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            <img class="aspect-[16/9] object-cover object-center w-1/2 mx-auto"
            src="{{ $image ? $image->temporaryUrl() : Storage::url($postEdit['image_path']) }}" alt="">
        
        </figure> --}}

        <div class="card dark:bg-gray-800">
            <div class="mb-4">
                <x-label class="mb-1">
                    Código
                </x-label>
                <x-input wire:model="postEdit.sku" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el código del posto" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="postEdit.name" class="w-full dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Por favor ingrese el nombre del posto" />
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

    {{-- <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" id="delete-form">

        @csrf
        @method('DELETE')

    </form> --}}

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
