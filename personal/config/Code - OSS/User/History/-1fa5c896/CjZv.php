<div>

    <form wire:submit="store">

        @csrf

        <div class="card">

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="userEdit.name" class="w-full" placeholder="Por favor ingrese el nombre" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Apellidos
                </x-label>
                <x-input wire:model="userEdit.last_name" class="w-full" placeholder="Por favor ingrese los apellidos" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Email
                </x-label>
                <x-input wire:model="userEdit.email" class="w-full" placeholder="Por favor ingrese el email" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Rol
                </x-label>
                <x-select name="role_id" class="w-full" wire:model="userEdit.role_id">
                    <option value="" disabled>
                        Seleccione un rol
                    </option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>

    </form>

</div>