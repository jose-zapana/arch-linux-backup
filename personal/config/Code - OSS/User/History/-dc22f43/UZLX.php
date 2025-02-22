<x-app-layout>

  <x-container>

    <div class="py-8">

      <h1 class="text-3xl text-center uppercase font-bold text-gray-600 dark:text-gray-300">
        Categoría: {{ $blogcategory->name }}
      </h1>

      @foreach ($posts as $post)
        <article class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
          <img class="w-full h-64 object-cover object-center" src="{{ Storage::url($post->image->url) }}" alt="">

          <div class="p-6">
            <h1 class="text-2xl">
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