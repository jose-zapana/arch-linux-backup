<div class="card">

  <div class="grid grid-cols-1 gap-6">

      {{-- Clientes --}}
      <div class="mt-2 mb-2" wire:ignore>
          <x-label class="mb-1">Clientes</x-label>

          <x-select name="customer_id" id="customer_id" class="select2 w-full" style="width: 100%" wire:model="customer_id"
              required>
              <option value="">Seleccione un cliente</option>
              @foreach ($users as $user)
                  <option wire:key="user-{{ $user->id }}" value="{{ $user->id }}">
                      {{ $user->name . ' ' . $user->last_name }}
                  </option>
              @endforeach
          </x-select>
      </div>

      <div>
          <x-label class="mb-1">Fecha emisión</x-label>
          <x-input type="date" class="w-full" name="start_at" wire:model="start_at"
              value="{{ old('start_at', now()->format('Y-m-d')) }}" />
      </div>

      <div class="grid grid-cols-2 mt-4">
          <div>
              <x-label class="mb-1">Opcionales</x-label>
              <ul>
                  <li>
                      <label>
                          <x-checkbox name="is_discount" wire:model="is_discount" />
                          Cliente Nuevo
                      </label>
                  </li>
              </ul>
          </div>
          <div>
              <div>
                  <x-label class="mb-1">Expiración</x-label>
                  <x-select name="end_date" class="w-full" style="width: 100%" wire:model="end_at" label="Expiración">
                      <option value="">Sin expiración</option>
                      <option value="{{ old('end_date', now()->addDays(7)->format('Y-m-d')) }}">7 Días</option>
                      <option value="{{ old('end_date', now()->addDays(15)->format('Y-m-d')) }}">15 Días</option>
                      <option value="{{ old('end_date', now()->addDays(30)->format('Y-m-d')) }}">30 Días</option>
                  </x-select>
              </div>
          </div>
      </div>

  </div>

  <div class="mt-4">
      <x-label class="mb-1">Notas</x-label>
      <x-textarea class="w-full" name="notes" wire:model="notes" label="Notas" placeholder="Escriba las notas" />
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      $('.select2').select2();
      $('.select2').on('change', function(e) {
          @this.set('customer_id', this.value);
      });
  });
</script>