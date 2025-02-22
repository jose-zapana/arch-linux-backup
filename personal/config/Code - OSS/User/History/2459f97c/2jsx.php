<x-app-layout>
  <x-container>
    <div class="py-12">
      {{-- Título con mejor contraste y accesibilidad --}}
      <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100">{{ $post->name }}</h1>
      
      {{-- Extracto del post con colores mejorados --}}
      <div class="text-lg text-gray-700 dark:text-gray-200 mb-2">
        {!! $post->extract !!}
      </div>
      
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Contenido Principal --}}
        <div class="lg:col-span-2">
          @if ($post->getFirstMedia('posts'))
          <img 
            class="w-full h-80 object-cover object-center mb-6" 
            src="{{ $post->getFirstMediaUrl('images', 'thumb') }}" 
            alt="{{ $post->name ?? 'Imagen de artículo' }}">
          @else
          {{-- Imagen predeterminada con texto alternativo más descriptivo --}}
          <img 
            class="w-full h-80 object-cover object-center mb-6" 
            src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg" 
            alt="Imagen predeterminada del artículo">
          @endif

          {{-- Contenido del cuerpo con colores mejorados --}}
          <div class="text-base text-gray-700 dark:text-gray-200 mt-4 leading-7">
            {!! $post->body !!}
          </div>
        </div>

        {{-- Contenido Lateral --}}
        <aside>
          {{-- Título de sección lateral --}}
          <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            Más en {{ $post->blogcategory->name }}
          </h1>

          {{-- Lista de posts relacionados --}}
          <ul>
            @foreach ($similares as $similar)
            <li class="mb-4">
              <a class="flex" href="{{ route('posts.show', $similar) }}">
                @if ($similar->getFirstMedia('images'))
                <img 
                  class="w-16 h-16 object-cover object-center" 
                  src="{{ $similar->getFirstMediaUrl('images', 'thumb') }}" 
                  alt="{{ $similar->name }}">
                @else
                <img 
                  class="w-16 h-16 object-cover object-center" 
                  src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg" 
                  alt="Imagen predeterminada del artículo relacionado">
                @endif
                {{-- Texto del post relacionado --}}
                <span class="ml-2 text-gray-800 dark:text-gray-100">
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