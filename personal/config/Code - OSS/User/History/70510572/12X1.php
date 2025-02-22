<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserEdit extends Component
{
    public $user, $roles;
    public $userEdit;

    public function mount(User $user)
    {
        // Cargar el usuario y sus roles
        $this->user = $user;
        $this->roles = Role::all();

        // Inicializar los datos del usuario y sus roles en userEdit
        $this->userEdit = [
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('id')->toArray(), // Obtener roles actuales
        ];
    }

    public function store()
    {
        // Validación de datos incluyendo los roles
        $this->validate([
            'userEdit.name' => 'required|string|max:255',
            'userEdit.last_name' => 'required|string|max:255',
            'userEdit.email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'userEdit.roles' => 'required|array|min:1', // Validar que al menos un rol sea seleccionado
            'userEdit.roles.*' => 'exists:roles,id', // Validar que cada rol exista en la base de datos
        ], [], [
            'userEdit.name' => 'nombre',
            'userEdit.last_name' => 'apellidos',
            'userEdit.email' => 'email',
            'userEdit.roles' => 'roles',
        ]);

        // Actualizar los datos del usuario
        $this->user->update([
            'name' => $this->userEdit['name'],
            'last_name' => $this->userEdit['last_name'],
            'email' => $this->userEdit['email'],
        ]);

        // Sincronizar roles seleccionados usando Spatie Laravel Permission
        $this->user->syncRoles($this->userEdit['roles']);

        // Mostrar mensaje de éxito con SweetAlert
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Usuario actualizado correctamente',
        ]);

        // Redirigir al formulario de edición del usuario actualizado
        return redirect()->route('admin.users.edit', $this->user->id);
    }

    public function render()
    {
        return view('livewire.admin.users.user-edit');
    }
}
