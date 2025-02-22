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
    <button class="btn bg-green-500 text-white hover:bg-green-600 dark:bg-green-700 dark:text-white dark:hover:bg-green-600 disabled:text-gray-400 disabled:bg-gray-300 w-full mb-6" 
    wire:click="add_to_cart" 
    :disabled="stock === 0">
Agregar al carrito
</button>


        <div class="text-sm mb-4 dark:text-gray-400">
            {{ $product->description }}
        </div>

        <div class="text-gray-700 dark:text-gray-300 flex items-center space-x-4">
            <i class="fa-solid fa-truck-fast text-2xl"></i>
            <p>Envío a domicilio</p>
        </div>
    </div>
</div>
