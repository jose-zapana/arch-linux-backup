<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías del blog',
        'route' => route('admin.posts.categories.index'),
    ],
    [
        'name' => $blogcategory->name,
    ],
]">




</x-admin-layout>