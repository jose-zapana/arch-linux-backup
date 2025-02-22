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
    

</x-admin-layout>
