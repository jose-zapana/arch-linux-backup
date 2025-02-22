@props(['post'])

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

    <div class="px-6 pt-4 pb-2">
      @foreach ($post->tags as $tag)

            <a href="{{ route('posts.tag', $tag) }}" class="inline-block bg-gray-200 text-sm rounded-full px-3 py-1 text-gray-700 dark:bg-gray-700 dark:text-gray-300 mr-2">
              {{ $tag->name }}
            </a>  
        
      @endforeach
    </div>
  </div>
</article>