<div>
    <!-- Primera sección: Datos del Cliente -->
    <div class="card p-6 bg-white shadow-md rounded-lg">
        <div class="grid grid-cols-1 gap-6">
            <div class="mt-2 mb-2" wire:ignore>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Clientes</label>
                <select name="customer_id" id="customer_id" class="select2 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" wire:model="customer_id" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($users as $user)
                        <option wire:key="user-{{ $user->id }}" value="{{ $user->id }}">
                            {{ $user->name . ' ' . $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="fecha_emision" class="block text-sm font-medium text-gray-700">Fecha emisión</label>
                    <input type="date" id="fecha_emision" name="fecha_emision" wire:model="fecha_emision"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="expiracion" class="block text-sm font-medium text-gray-700">Expiración</label>
                    <select id="expiracion" name="expiracion" wire:model="expiracion"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Sin expiración</option>
                        <option value="7">7 días</option>
                        <option value="30">30 días</option>
                        <option value="60">60 días</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
            <textarea name="notes" id="notes" wire:model="notes" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Escriba las observaciones"></textarea>
        </div>
    </div>

    <!-- Segunda sección: Artículos -->
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mt-6">
        <div class="lg:col-span-5">
            <div class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-7 gap-4 items-center font-semibold text-sm border-b border-gray-300 pb-2 mb-4">
                    <p></p>
                    <p>Descripción</p>
                    <p>Precio</p>
                    <p>Cantidad</p>
                    <p>Descuento</p>
                    <p>Total</p>
                    <p>Acciones</p>                    
                </div>

                <div class="add_input_fields space-y-4">
                    <div class="grid grid-cols-6 gap-4 items-center">
                        <input type="text" name="descripcion[]" placeholder="Descripción" class="col-span-2 px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <input type="text" name="precio[]" placeholder="Precio" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <input type="text" name="cantidad[]" placeholder="Cantidad" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <input type="text" name="total[]" placeholder="Total" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" class="text-white bg-indigo-500 hover:bg-indigo-600 px-3 py-2 rounded-md add_field_button">+</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            @include('livewire.admin.quotes.partials.total')
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Select2
    $('.select2').select2();
    $('.select2').on('change', function () {
        @this.set('customer_id', this.value);
    });
});

$(document).ready(function () {
    var max_fields = 10; // máximo de campos permitidos
    var wrapper = $(".add_input_fields"); // contenedor de campos
    var add_button = $(".add_field_button"); // botón para agregar

    var x = 1; // contador de campos inicial
    $(add_button).click(function (e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(
                '<div class="grid grid-cols-6 gap-4 items-center mt-4">' +
                '<input type="text" name="descripcion[]" placeholder="Descripción" class="col-span-2 px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">' +
                '<input type="text" name="precio[]" placeholder="Precio" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">' +
                '<input type="text" name="cantidad[]" placeholder="Cantidad" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">' +
                '<input type="text" name="total[]" placeholder="Total" class="px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">' +
                '<button type="button" class="text-white bg-red-500 hover:bg-red-600 px-3 py-2 rounded-md remove_field">-</button>' +
                '</div>'
            );
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});
</script>
