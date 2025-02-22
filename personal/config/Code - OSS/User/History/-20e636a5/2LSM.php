<x-app-layout>

  <x-container>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <!-- Título del Blog -->
      <h1 class="text-4xl text-center uppercase font-bold text-gray-700 dark:text-gray-300 mb-8">
        Blog
      </h1>

      <!-- Contenedor de las publicaciones -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($posts as $post)
          <x-card-post :post="$post" />
        @endforeach
      </div>

      <!-- Paginación -->
      <div class="mt-8 flex justify-center">
        {{ $posts->links() }}
      </div>
    </div>

  </x-container>

</x-app-layout>
