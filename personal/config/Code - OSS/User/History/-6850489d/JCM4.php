<x-app-layout>

  <x-container>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">

      <h1 class="text-3xl text-center uppercase font-bold text-gray-600 dark:text-gray-300">
        Categoría: {{ $blogcategory->name }}
      </h1>

      @foreach ($posts as $post)
      
        <x-card-post :post="$post" />

      @endforeach
      
      <div class="mt-4">
        {{ $posts->links() }}
      </div>

    </div>

  </x-container>

</x-app-layout>