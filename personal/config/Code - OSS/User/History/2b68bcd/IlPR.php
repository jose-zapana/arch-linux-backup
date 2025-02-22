<x-app-layout>
    <x-container class="px-4 my-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#00a1b4] dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
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
                        <a href="{{ route('families.show', $product->subcategory->category->family) }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-[#00a1b4] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $product->subcategory->category->family->name }}</a>
                    </div>
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
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Columna izquierda: Imagen del producto y detalles -->
                <div class="col-span-1">
                    <figure class="max-w-xs mx-auto">
                        <img 
                            fetchpriority="high" 
                            src="{{ $product->getFirstMediaUrl('images', 'mobile_small') ?: asset('img/no-image.png') }}" 
                            alt="Imagen representativa del producto: {{ $product->name }}" 
                            width="500" 
                            height="375" 
                            class="object-cover object-center w-full h-auto">
    
                    </figure>  
   

                </div>

                <a href="https://api.whatsapp.com/send?phone=51957686487&amp;text=Necesito saber mas sobre: {{ $product->name }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-100 transition ease-in-out duration-150"
                    target="_blank" 
                    rel="noopener noreferrer">
                     <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M21.74 15.63c-1.09 1.63-2.75 2.78-4.61 3.24a10.7 10.7 0 01-4.3.36 11 11 0 01-5.5-2.15l-4.07 1.07a.64.64 0 01-.79-.79l1.08-4.07A10.96 10.96 0 011.55 5.63 10.7 10.7 0 011.91 1.3a11 11 0 0117.82 11.1c.22.8.15 1.59-.09 2.3a10.7 10.7 0 01-.9 3.93z" />
                     </svg>
                     Solicítalo
                 </a>
    
                <!-- Columna derecha: Componente Livewire -->
                <div class="col-span-1">
                    @livewire('products.add-to-cart', ['product' => $product])
                </div>
                <div class="text-sm mt-4">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Descripción</h2>
                    <p class="dark:text-gray-400 leading-relaxed">{!! $product->description !!}</p>
                </div>
            </div>
        </div>
    </x-container>
    

</x-app-layout>
