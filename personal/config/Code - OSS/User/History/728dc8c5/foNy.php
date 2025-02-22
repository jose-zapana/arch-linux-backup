<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],
]">

    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.roles.create') }}">
            Nuevo
        </a>
    </x-slot>


    <a id="newRole" class="btn btn-success">
        <i class="icon-2x fa fa-plus"></i> Nuevo Role
    </a>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Slug</th>
            <th scope="col">Descripción</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $roles as $role )
        <tr>
            <th scope="row">{{ $role->id }}</th>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td>

                <a data-edit="{{ $role->id }}" data-url="{{ route('role.permissions', $role->name) }}" data-description="{{ $role->description }}" data-name="{{ $role->name }}"  class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                <a data-delete="{{ $role->id }}" data-description="{{ $role->description }}" data-name="{{ $role->name }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div id="modalCreate" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo Rol</h4>
                </div>
                <form id="formCreate" class="form-horizontal" data-url="{{ route('role.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="name"> Role </label>

                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="col-xs-10 col-sm-10" placeholder="Ejm: editor" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="description"> Descripción </label>

                            <div class="col-sm-9">
                                <input type="text" id="description" name="description" class="col-xs-10 col-sm-10" placeholder="Ejm: Responsable de hacer modificaciones" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="permissions"> Permisos </label>

                            <div class="col-sm-9">
                                <select multiple="" name="permissions[]" class="select2 col-xs-10 col-sm-10" id="permissions" >
                                    @foreach( $permissions as $permission )
                                    <option value="{{$permission->name}}">{{ $permission->description }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modificar role</h4>
                </div>
                <form id="formEdit" class="form-horizontal" data-url="{{ route('role.update') }}" >
                    @csrf
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="nameE"> Role </label>

                            <div class="col-sm-9">
                                <input type="text" id="nameE" name="name" class="col-xs-10 col-sm-10" placeholder="Ejm: Editor" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="descriptionE"> Descripción </label>

                            <div class="col-sm-9">
                                <input type="text" id="descriptionE" name="description" class="col-xs-10 col-sm-10" placeholder="Ejm: Listar productos" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="permissionsE"> Permisos </label>

                            <div class="col-sm-9">
                                <select multiple="" name="permissions[]" class="select2 col-xs-10 col-sm-10" id="permissionsE" >

                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="modalDelete" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar eliminación</h4>
                </div>
                <form id="formDelete" data-url="{{ route('role.destroy') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="role_id" name="role_id">
                        <p id="nameDelete"></p>
                        <p id="descriptionDelete"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>
