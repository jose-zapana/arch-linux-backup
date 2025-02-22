<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Importa el modelo Role de Spatie

class RoleController extends Controller
{
    public function index()
    {   
        // Obtiene todos los roles desde la base de datos
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
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
        // Validación de los datos
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        // Actualiza el rol con los datos proporcionados
        $role->update($request->all());

        // Mensaje flash de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Rol actualizado correctamente',
        ]);

        // Redirige al listado de roles
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        // Elimina el rol
        $role->delete();

        // Mensaje flash de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Rol eliminado correctamente',
        ]);

        // Redirige al listado de roles
        return redirect()->route('admin.roles.index');
    }
}
