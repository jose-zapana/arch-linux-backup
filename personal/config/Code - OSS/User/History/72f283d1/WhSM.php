<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'route' => route('admin.roles.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

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

</x-admin-layout>
