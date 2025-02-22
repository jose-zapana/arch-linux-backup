<x-app-layout>
    @push('css')
        <!-- Precarga de imágenes críticas -->
        @isset($covers)
            @foreach ($covers as $cover)
                <link rel="preload" href="{{ $cover->image }}" as="image" type="image/webp">
            @endforeach
        @endisset

        @isset($lastProducts)
            @foreach ($lastProducts as $product)
                <link rel="preload" href="{{ $product->getFirstMediaUrl('images', 'product') }}" as="image" type="image/webp">
            @endforeach
        @endisset

        <!-- Preconexión a orígenes importantes -->
        <link rel="preconnect" href="https://pc-hard.com">
        <link rel="preconnect" href="https://cdn.jsdelivr.net">

        <!-- CSS de Swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

        <!-- Estilos para evitar CLS -->
        <style>
            .swiper-slide img {
                aspect-ratio: 3 / 1; /* Relación de aspecto del slider */
            }
            .product-img img {
                aspect-ratio: 4 / 3; /* Relación de aspecto de las imágenes de productos */
            }
        </style>
    @endpush

    <!-- Slider principal -->
    <div class="swiper mb-12">
        <div class="swiper-wrapper">
            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img fetchpriority="high" 
                        src="{{ $cover->image }}" 
                        srcset="{{ $cover->image }} 1200w, 
                                {{ $cover->image }} 800w, 
                                {{ $cover->image }} 480w" 
                        sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                        alt="Imagen del slider: {{ $cover->title ?? 'Sin título' }}" 
                        class="w-full object-cover object-center" 
                        width="1200" height="400">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- Últimos productos -->
    <x-container>
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-4 text-center uppercase">
            Últimos productos
        </h1>        

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($lastProducts as $product)
                <article class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg flex flex-col h-full">
                    <figure class="product-img">
                        <a href="{{ route('products.show', $product) }}" aria-label="Ver detalles del producto: {{ $product->name }}">
                            <img fetchpriority="high" src="{{ $product->getFirstMediaUrl('images', 'product') }}" 
                            alt="Imagen del producto: {{ $product->name }}" 
                            class="w-full object-cover object-center" 
                            width="400" height="400">
                       
                    </figure>
                    <div class="p-4">
                        <a href="{{ route('products.show', $product) }}" aria-label="Ver detalles del producto: {{ $product->name }}">
                            <h1 class="text-lg text-gray-700 dark:text-gray-300 font-semibold line-clamp-2 min-h-[56px]">
                                {{ $product->name }}
                            </h1>
                        </a>
                        <ul class="flex items-center space-x-1 text-xs mb-1">
                            <li><i class="fas fa-star text-yellow-400"></i></li>
                            <li><i class="fas fa-star text-yellow-400"></i></li>
                            <li><i class="fas fa-star text-yellow-400"></i></li>
                            <li><i class="fas fa-star text-yellow-400"></i></li>
                            <li><i class="fas fa-star text-yellow-400"></i></li>
                        </ul>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 font-bold">
                            {{ $product->price }} USD
                        </p>
                        <a href="{{ route('products.show', $product) }}" 
                        class="btn bg-indigo-600 text-white block w-full text-center hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition-all duration-300 ease-in-out" 
                        aria-label="Ver más detalles del producto: {{ $product->name }}">
                         Ver más
                     </a>
                    </div>
                </article>
            @endforeach
        </div>

        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-4 text-center uppercase mt-10">
            Últimas Entradas
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($posts as $post)
            <article class="w-full h-80 bg-cover bg-center @if($loop->first) md:col-span-2 @endif rounded-lg"
                     style="background-image: url(@if($post->hasMedia('posts')) {{ $post->getFirstMediaUrl('posts', 'thumb') }} @else https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg @endif)">
                <div class="w-full h-full px-8 flex flex-col justify-center">
                    <div>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('posts.tag', $tag) }}" class="inline-block px-3 h-6 bg-{{ $tag->color }}-600 text-white rounded-full" aria-label="Ver entradas etiquetadas con: {{ $tag->name }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                    <h1 class="text-2xl font-bold leading-8 mt-2 text-white bg-black bg-opacity-50 p-2 rounded-lg">
                        <a href="{{ route('posts.show', $post) }}" aria-label="Leer la entrada: {{ $post->name }}">
                            {{ $post->name }}
                        </a>
                    </h1>
                </div>
            </article>
        @endforeach

        </div>
    </x-container>

    @push('js')
    <!-- Swiper con defer -->
    <script type="module" defer>
        import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs';

        document.addEventListener('DOMContentLoaded', () => {
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 4000,
                },
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    @endpush
</x-app-layout>
