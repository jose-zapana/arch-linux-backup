<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Rules\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $role->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Rol actualizado correctamente',
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Rol eliminado correctamente',
        ]);

        return redirect()->route('admin.roles.index');
    }
}
