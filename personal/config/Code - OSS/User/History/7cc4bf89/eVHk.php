<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function edit()
    {
        return view('admin.roles.edit');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }
}
