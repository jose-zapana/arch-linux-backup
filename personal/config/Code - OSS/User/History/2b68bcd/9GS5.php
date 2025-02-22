<x-app-layout>
    <x-container class="px-4 my-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#00a1b4] dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Inicio
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('categories.show', $product->subcategory->category) }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-[#00a1b4] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $product->subcategory->category->name }}</a>
                    </div>
                </li>

                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('subcategories.show', $product->subcategory) }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-[#00a1b4] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $product->subcategory->name }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-container>

    <x-container>
        <div class="card bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna izquierda: Imagen del producto y detalles -->
                <div class="col-span-1">
                    <figure class="max-w-xs mx-auto">
                        <img 
                            fetchpriority="high" 
                            src="{{ $product->getFirstMediaUrl('images', 'product') ?: asset('img/no-image.png') }}" 
                            alt="Imagen representativa del producto: {{ $product->name }}" 
                            width="500" 
                            height="375" 
                            class="object-cover object-center w-full h-auto">
                    </figure>
                </div>
                
                <!-- Columna derecha: Componente Livewire -->
                <div class="col-span-1">
                    @livewire('products.add-to-cart', ['product' => $product])
                </div>
                
                

                <!-- Contenido del cuerpo con colores mejorados -->
                <div class="post-body text-base text-gray-700 dark:text-gray-200 mt-4 leading-7">
                        <h2>Descripción</h2>
                        {!! $product->description !!}                    
                </div>            
                               
            </div>
        </div>
    </x-container>
</x-app-layout>
