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
        'name' => $blog_category->name,
    ],
]">




</x-admin-layout>