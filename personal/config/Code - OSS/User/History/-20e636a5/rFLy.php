<x-app-layout>

  <x-container>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl text-center uppercase font-bold text-gray-700 dark:text-gray-300 mb-8">

        Blog
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