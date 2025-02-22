<x-app-layout>

  <x-container>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">

      <h1 class="text-3xl text-center uppercase font-bold text-gray-600 dark:text-gray-300">
        Categoría: {{ $blogcategory->name }}
      </h1>

      @foreach ($posts as $post)
        <article class="mb-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
          <img class="w-full h-72 object-cover object-center" src="{{ Storage::url($post->image->url) }}" alt="">

          <div class="px-6 py-4">
            <h1 class="font-bold text-xl text-gray-700 dark:text-gray-300 mb-2">
              <a href="{{ route('posts.show', $post) }}">
                {{ $post->name }}
              </a>
            </h1>

            <div class="text-gray-700 dark:text-gray-300 text-base">
              {{ $post->extract }}
            </div>

            <div>
              @foreach ($post->tags as $tag)

                    <a href="/" class="inline-block px-3 h-6 bg-{{ $tag->color }}-600 text-white rounded-full">
                      {{ $tag->name }}
                    </a>  
                
              @endforeach
            </div>

          </div>


        </article>
      @endforeach


    </div>

  </x-container>

</x-app-layout>