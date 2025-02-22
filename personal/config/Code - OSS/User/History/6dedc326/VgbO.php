<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index'),
    ],
    [
        'name' => $blogcategory->name,
    ],
]">




</x-admin-layout>