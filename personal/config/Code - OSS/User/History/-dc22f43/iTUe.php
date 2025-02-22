<x-app-layout>

  <x-container>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">

      <h1 class="text-3xl text-center uppercase font-bold text-gray-600 dark:text-gray-300">
        Categoría: {{ $blogcategory->name }}
      </h1>

      @foreach ($posts as $post)
        <article class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
          <img class="w-full h-72 object-cover object-center" src="{{ Storage::url($post->image->url) }}" alt="">

          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">
              <a href="{{ route('posts.show', $post) }}">
                {{ $post->name }}
              </a>
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
              {{ $post->extract }}
            </p>
          </div>
        </article>
      @endforeach


    </div>

  </x-container>

</x-app-layout>