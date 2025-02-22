<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuario',
        'route' => route('admin.users.index'),
    ],
    [
        'name' => $user->name . ' ' . $user->last_name,
    ],
]">

    @livewire('admin.users.user-edit', ['user' => $user, 'roles' => $roles], key('user-edit-' . $user->id))


    @push('js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar Select2
            $('#roles').select2({
                theme: 'classic', // Puedes cambiar el tema según tus preferencias
                placeholder: 'Seleccione uno o más roles',
            });
    
            // Escuchar cambios en Select2 y actualizar Livewire
            $('#roles').on('change', function () {
                @this.set('userEdit.roles', $(this).val());
            });
        });
    </script>
    
        
    @endpush

</x-admin-layout>
