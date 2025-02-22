<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Portadas',
    ],
]">

    <x-slot name="action">
        <a href="{{ route('admin.covers.create') }}" class="btn btn-blue">
            Nuevo
        </a>
    </x-slot>

    <ul class="space-y-4" id="covers">

        @foreach ($covers as $cover)
            <li class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden lg:flex cursor-move" data-id="{{ $cover->id }}">

                <img src="{{ $cover->image }}" alt=""
                    class="w-full lg:w-64 aspect-[3/1] object-cover object-center">

                <div class="p-4 lg:flex-1 lg:flex lg:justify-between lg:items-center space-y-2 lg:space-y-0">

                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $cover->title }}
                        </h1>

                        <p>
                            @if ($cover->is_active)
                                <span
                                    class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Activo</span>
                            @else
                                <span
                                    class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Inactivo</span>
                            @endif
                        </p>

                    </div>


                    <div>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                            Fecha de inicio
                        </p>

                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $cover->start_at->format('d/m/Y') }}
                        </p>

                    </div>

                    <div>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                            Fecha de Finalización
                        </p>

                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $cover->end_at ? $cover->end_at->format('d/m/Y') : 'Sin fecha de finalización' }}
                        </p>

                    </div>

                    <div class="flex space-x-2">

                        <div class="flex">
                            <form action="{{ route('admin.covers.destroy', $cover) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" class="btn btn-red dark:bg-red-700 dark:text-white">
                                    <i class="fas fa-trash"></i>
                                </x-danger-button>
                            </form>
                        </div>

                        <div class="flex">
                            <a href="{{ route('admin.covers.edit', $cover) }}">
                                <x-button class="btn btn-red dark:bg-blue-700 dark:text-gray-100">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                            </a>
                        </div>


                    </div>

                </div>
            </li>
        @endforeach

    </ul>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
        <script>
            new Sortable(covers, {
                animation: 150,
                ghostClass: 'bg-blue-100',
                store: {
                    set: (sortable) => {
                        const sorts = sortable.toArray()

                        axios.post("{{ route('api.sort.covers') }}", {
                            sorts: sorts
                        }).catch((error) => {
                            console.log(error)
                        })
                    }
                }
            });
        </script>
    @endpush

</x-admin-layout>
