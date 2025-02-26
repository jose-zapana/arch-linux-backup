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
                <div class="grid grid-cols-6 gap-4 items-center font-semibold text-sm border-b border-gray-300 pb-2 mb-4">
                    <p class="col-span-2 text-center">Descripción</p>
                    <p class="text-center">Cantidad</p>
                    <p class="text-center">Precio</p>
                    <p class="text-center">Total</p>
                    <p class="text-left">Acciones</p>
                </div>
        
                <div class="add_input_fields space-y-4">
                    <div class="grid grid-cols-6 gap-4 items-center">
                        <input type="text" name="descripcion[]" placeholder="Descripción"
                            class="col-span-2 px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full">
                        <input type="number" name="cantidad[]" placeholder="Cant"
                            class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 cantidad">
                        <input type="number" name="precio[]" placeholder="Precio"
                            class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 precio">
                        <input type="number" name="total[]" placeholder="Total" readonly
                            class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 total-item">
                        <button type="button"
                            class="text-white bg-indigo-500 hover:bg-indigo-600 px-2 py-1 rounded-md add_field_button text-sm w-10 h-8 flex justify-center items-center">
                            +
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Resumen</h3>
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium">Subtotal:</p>
                    <p class="text-sm font-medium" id="subtotal">0.00</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium">Impuesto (18%):</p>
                    <p class="text-sm font-medium" id="tax">0.00</p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-lg font-semibold">Total:</p>
                    <p class="text-lg font-semibold" id="grand-total">0.00</p>
                </div>
            </div>
            <x-button class="w-full" wire:click="store">
                Crear Cotización
            </x-button>
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

    // Variables para calcular el total
    const calculateTotals = () => {
        let subtotal = 0;
        document.querySelectorAll('.add_input_fields .grid').forEach(row => {
            const cantidad = parseFloat(row.querySelector('.cantidad')?.value || 0);
            const precio = parseFloat(row.querySelector('.precio')?.value || 0);
            const totalField = row.querySelector('.total-item');
            const total = cantidad * precio;
            totalField.value = total.toFixed(2);
            subtotal += total;
        });

        const tax = subtotal * 0.18;
        const grandTotal = subtotal + tax;

        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('tax').innerText = tax.toFixed(2);
        document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
    };

    // Evento para recalcular cuando cambian los valores
    document.addEventListener('input', (event) => {
        if (event.target.classList.contains('cantidad') || event.target.classList.contains('precio')) {
            calculateTotals();
        }
    });

    // Añadir campos dinámicamente
    const wrapper = document.querySelector('.add_input_fields');
    document.querySelector('.add_field_button').addEventListener('click', function (e) {
        e.preventDefault();
        const newRow = document.createElement('div');
        newRow.classList.add('grid', 'grid-cols-6', 'gap-4', 'items-center', 'mt-4');
        newRow.innerHTML = `
            <input type="text" name="descripcion[]" placeholder="Descripción"
                class="col-span-2 px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full">
            <input type="number" name="cantidad[]" placeholder="Cant"
                class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 cantidad">
            <input type="number" name="precio[]" placeholder="Precio"
                class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 precio">
            <input type="number" name="total[]" placeholder="Total" readonly
                class="text-center px-2 py-1 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-30 total-item">
            <button type="button" class="text-white bg-red-500 hover:bg-red-600 px-2 py-1 rounded-md text-sm w-10 h-8 flex justify-center items-center remove_field">-</button>
        `;
        wrapper.appendChild(newRow);
        calculateTotals();
    });

    // Eliminar campos dinámicamente
    wrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove_field')) {
            e.preventDefault();
            e.target.parentNode.remove();
            calculateTotals();
        }
    });
});
</script>
