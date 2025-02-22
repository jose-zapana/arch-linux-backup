<x-app-layout>
  <x-container>
    <div class="py-12">
      <!-- Título del post -->
      <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100">{{ $post->name }}</h1>
      <!-- Extracto del post -->
      <div class="text-lg text-gray-700 dark:text-gray-300 mb-4">
        {!! $post->extract !!}
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Contenido Principal --}}
        <div class="lg:col-span-2">

          @if ($post->hasMedia('posts'))
            <img 
              class="w-full h-80 object-cover object-center mb-6 rounded-lg" 
              src="{{ $post->getFirstMediaUrl('posts', 'small_820x320') }}" 
              alt="Imagen destacada de {{ $post->name }}">
          @else
            <img 
              class="w-full h-80 object-cover object-center mb-6 rounded-lg" 
              src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg" 
              alt="Imagen predeterminada para el post {{ $post->name }}">
          @endif

          <!-- Cuerpo del post -->
          <div class="text-base text-gray-700 dark:text-gray-300 mt-4 leading-relaxed">
            {!! $post->body !!}             
          </div>

        </div>

        {{-- Contenido Lateral --}}
        <aside>
          <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            Más en {{ $post->blogcategory->name }}
          </h1>

          <ul>
            @foreach ($similares as $similar)
              <li class="mb-4">
                <a class="flex items-center hover:bg-gray-200 dark:hover:bg-gray-700 p-2 rounded-lg transition" 
                   href="{{ route('posts.show', $similar) }}">
                  @if ($similar->hasMedia('posts'))
                    <img 
                      class="w-16 h-16 object-cover object-center rounded-lg" 
                      src="{{ $similar->getFirstMediaUrl('posts', 'large') }}" 
                      alt="Imagen destacada del post {{ $similar->name }}">
                  @else
                    <img 
                      class="w-16 h-16 object-cover object-center rounded-lg" 
                      src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg" 
                      alt="Imagen predeterminada para el post {{ $similar->name }}">
                  @endif
                  <span class="ml-4 text-gray-700 dark:text-gray-300">
                    {{ $similar->name }}
                  </span>
                </a>
              </li>
            @endforeach
          </ul>
          
        </aside>
      </div>

    </div>

  </x-container>

</x-app-layout>
