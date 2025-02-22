<x-admin-layout :breadcrumbs="[
    [
           'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
]">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />

                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold dark:text-gray-100">
                        Bienvenido,
                    </h2>
                    <p class="dark:text-gray-300">
                        {{ auth()->user()->name }} {{ auth()->user()->last_name }}
                    </p>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-sm hover:text-blue-500 dark:hover:text-blue-400  dark:text-gray-100">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 grid items-center justify-center grid-cols-1">
            <div class="flex justify-center p-2">
                <img class="aspect-[1/1] w-32 h-32" src="{{ asset('img/logo.png') }}" alt="Logo Pc-Hard" />
            </div>
            <div class="flex justify-center">
                <h2 class="text-lg font-bold text-gray-600 dark:text-gray-100">
                    PCHARD S.A.C | 20610015213
                </h2>
            </div>
        </div>

    </div>

</x-admin-layout>
