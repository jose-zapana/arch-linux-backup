<div>
    <h1 class="text-xl text-gray-700 dark:text-gray-300 font-semibold">
        {{ $product->name }}
    </h1>

    <div class="flex items-center space-x-2 mb-4">
        <ul class="flex space-x-1 text-sm">
            <li>
                <i class="fa-solid fa-star text-yellow-500"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-500"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-500"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-500"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-500"></i>
            </li>
        </ul>
        <p class="text-gray-700 dark:text-gray-300 text-sm">4.8 (57)</p>
    </div>

    <div class="flex justify-between items-center">
        <p class="text-gray-600 dark:text-gray-400 text-2xl font-semibold">
            {{ $product->price }} USD
        </p>
        <p>
            Stock: {{ $variant->stock }}
        </p>
    </div>

    <div class="flex items-center space-x-6 mb-6" x-data="{ 
        qty: @entangle('qty'),
        stock: @entangle('stock'), 
    }">
        <button class="btn btn-gray dark:btn-gray-dark" @click="qty > 1 ? qty-- : qty = 1">
            -
        </button>
        <span x-text="qty" class="inline-block w-2 text-center"></span>

        <button class="btn btn-gray dark:btn-gray-dark disabled:text-gray-400 disabled:bg-gray-300 " @click="qty++"
        :disabled="qty >= stock"
        >
            +
        </button>
    </div>

    <div class="flex flex-wrap">
        @foreach ($product->options as $option)
            <div class="mr-4 mb-4">
                <p class="font-semibold text-lg mb-2 dark:text-gray-100">
                    {{ $option->name }}
                </p>
                <ul class="flex items-center space-x-4">
                    @foreach ($option->pivot->features as $feature)
                        <li>
                            @switch($option->type)
                                @case(1)
                                    <button
                                        class="w-20 h-8 font-semibold uppercase text-sm rounded-lg {{ $selectedFeatures[$option->id] == $feature['id'] ? 'bg-[#00a1b4] text-white' : 'bg-gray-200 text-gray-700' }} border"
                                        wire:click="$set('selectedFeatures.{{ $option->id }}',  {{ $feature['id'] }})">
                                        {{ $feature['value'] }}
                                    </button>
                                @break
                                @case(2)
                                    <div class="p-0.5 rounded-lg border-2 flex items-center -mt-1.5 {{ $selectedFeatures[$option->id] == $feature['id'] ? 'border-[#00a1b4]' : 'border-transparent' }}"
                                        wire:click="$set('selectedFeatures.{{ $option->id }}',  {{ $feature['id'] }})">
                                        <button class="w-20 h-8 rounded-lg border border-gray-200"
                                            style="background-color: {{ $feature['value'] }}">
                                        </button>
                                    </div>
                                @break
                                @default
                            @endswitch
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div x-data="{ 
        qty: @entangle('qty'),
        stock: @entangle('stock'), 
    }">
        <button 
            class="btn bg-indigo-500 text-white hover:bg-indigo-600 dark:bg-indigo-400 dark:hover:bg-indigo-500 disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-400 rounded-lg shadow-lg transition-all w-full mb-6" 
            wire:click="add_to_cart" 
            :disabled="stock === 0">
            Agregar al carrito
        </button>

        <button 
        class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-semibold text-sm rounded-lg shadow-lg transition-all hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-100 dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-300 w-full mb-6" 
        onclick="window.open('https://api.whatsapp.com/send?phone=51957686487&text=Necesito saber más sobre: {{ $product->name }}', '_blank', 'noopener,noreferrer')"
        type="button">
        <svg class="w-6 h-6 mr-2 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path d="M16 2.5C8.82 2.5 2.5 8.82 2.5 16c0 2.56.69 5.03 1.99 7.21l-2.01 6.24c-.16.52.33.99.84.84l6.24-2.01A13.43 13.43 0 0016 29.5c7.18 0 13.5-6.32 13.5-13.5S23.18 2.5 16 2.5zm0 24.5c-2.1 0-4.17-.56-5.97-1.62l-.36-.21-4.59 1.48 1.48-4.59-.21-.36A11.43 11.43 0 014.5 16C4.5 9.37 9.37 4.5 16 4.5S27.5 9.37 27.5 16 22.63 27.5 16 27.5zm6.43-7.68l-1.87-.53c-.25-.07-.5.01-.67.2-.3.33-.63.63-1.01.88-.17.11-.39.14-.6.08a10.55 10.55 0 01-3.61-2.25 10.55 10.55 0 01-2.25-3.61c-.06-.21-.03-.43.08-.6.25-.38.55-.71.88-1.01.19-.17.27-.42.2-.67l-.53-1.87c-.12-.43-.56-.68-.99-.59-.74.17-1.42.53-1.95 1.06-1.52 1.52-1.73 3.9-.52 5.91a12.73 12.73 0 005.68 5.68c.82.42 1.7.63 2.6.63.95 0 1.89-.31 2.69-.91.53-.53.9-1.2 1.06-1.95.09-.43-.16-.87-.59-.99z"/>
        </svg>
        Solicítalo
        </button>
    
      

        <div class="text-gray-700 dark:text-gray-300 flex items-center space-x-4">
            <i class="fa-solid fa-truck-fast text-2xl"></i>
            <p>Envío a domicilio</p>
        </div>
    </div>
</div>
