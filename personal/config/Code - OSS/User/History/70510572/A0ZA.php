<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{

    public $user, $roles;
    public $userEdit
        = [
            'name' => '',
            'last_name' => '',
            'document_type' => '',
            'document_number' => '',
            'email' => '',
            'phone' => '',
            'roles' => [],
        ];

    public function mount($user)
    {
        $this->roles = Role::all();
        $this->userEdit = [
            'name' => $user->name,
            'last_name' => $user->last_name,
            'document_type' => $user->document_type,
            'document_number' => $user->document_number,
            'email' => $user->email,
            'phone' => $user->phone,
            'roles' => [], // Aquí roles debe ser un array para el multi-select

        ];
    }

    public function store()
    {

        $this->validate([
            'userEdit.name' => 'required',
            'userEdit.last_name' => 'required',
            'userEdit.document_type' => 'required',
            'userEdit.document_number' => 'required',
            'userEdit.email' => 'required',
            'userEdit.phone' => 'required',
        ], [], [
            'userEdit.name' => 'nombre',
            'userEdit.last_name' => 'apellidos',
            'userEdit.document_type' => 'tipo de documento',
            'userEdit.document_number' => 'número de documento',
            'userEdit.email' => 'email',
            'userEdit.phone' => 'telefono',
        ]);

        $this->user->update($this->userEdit);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Usuario actualizado correctamente',
        ]);

        return redirect()->route('admin.users.edit', $this->user->id);
    }

    public function render()
    {
        return view('livewire.admin.users.user-edit');
    }
}
