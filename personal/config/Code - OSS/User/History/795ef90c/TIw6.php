<x-app-layout>
    
    @push('head')
    <script type="text/javascript"
        src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
        kr-public-key="{{ config('services.izipay.public_key') }}"
        kr-post-url-success="{{ route('checkout.izipay') }}";
        kr-language="en-EN">
    </script>

    <!--  theme CLASSIC should be loaded in the HEAD section   -->
    <link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.min.css">
    <script src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js"></script>
    @endpush

    <div class="-mb-32 text-gray-700 dark:text-gray-300" x-data="{ pago: '1' }">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="col-span-1 bg-white dark:bg-gray-900">

                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">

                    <h1 class="text-2xl font-semibold mb-2 dark:text-gray-100">
                        Pago
                    </h1>

                    <div class="shadow rounded-lg overflow-hidden border border-gray-400 dark:border-gray-700">

                        <ul class="divide-y divide-gray-400 dark:divide-gray-700">
                            <li>
                                <label class="p-4 flex items-center dark:text-gray-300">
                                    <input type="radio" value="1" name="pago" x-model="pago" class="text-blue-500">


                                    <span class="ml-2">
                                        Tarjeta de debito/credito
                                    </span>
                                    <img class="h-6 ml-auto" src="{{ asset('img/payments/credit-cards.png') }}"
                                        alt="">
                                </label>

                                <div class="p-4 bg-gray-100 dark:bg-gray-800 text-center border-t border-gray-400 dark:border-gray-700" x-show="pago == 1">

                                    <i class="fa-regular fa-credit-card text-9xl dark:text-gray-300"></i>
                                    <p class="mt-2 dark:text-gray-400">
                                        Luego de hacer click al "Pagar Ahora", se abrira el checkoun de Niubiz para
                                        completar tu compra de forma segura.
                                    </p>

                                </div>
                            </li>

                            <li>
                                <label class="p-4 flex items-center dark:text-gray-300">
                                    <input type="radio" value="2" name="pago" x-model="pago" class="text-blue-500">
                                    <span class="ml-2">
                                        Deposito Bancario o Yape
                                    </span>
                                </label>

                                <div class="border-t border-gray-400 dark:border-gray-700 p-4 bg-gray-100 dark:bg-gray-800 flex justify-center" x-cloak x-show="pago == 2">

                                    <div class="dark:text-gray-300">
                                        <p>1. Pago por depósito o transferencia bancaria:</p>
                                        <p>- Interbank Soles: 200-3004484086</p>
                                        <p>- CCI: 003-200-003004484086-33</p>
                                        <p>- Razón Social: PCHARD S.A.C</p>
                                        <p>- RUC: 20610015213</p>
                                        <p>- Pago por Yape (Proximamente)</p>
                                        <p>- Enviar comprobante de pago al whatsapp</p>
                                    </div>
                                    
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-span-1" x-cloak x-show="pago == 1">
                <div class="lg:max-w-[40rem] py-12 px-4 sm:pr-6 lg:pl-8 lg:pr-8 mr-auto">
                    <ul class="space-y-4 mb-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
                            <li class="flex items-center space-x-4 dark:text-gray-300">

                                <div class="flex-shrink-0 relative">

                                    <img class="h-16 aspect-square" src="{{ $item->options->image }}" alt="">
                                    <div
                                        class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="text-white font-semibold">
                                            {{ $item->qty }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p>
                                        {{ $item->name }}
                                    </p>
                                </div>

                            </li>
                        @endforeach

                    </ul>

                    <div class="flex justify-between dark:text-gray-300">
                        <p>
                            Subtotal
                        </p>
                        <p>
                            {{ $subtotal }} USD
                        </p>
                    </div>

                    <div class="flex justify-between dark:text-gray-300">
                        <p>
                            Pago con Tarjeta (+5%)
                        </p>
                        <p>
                            {{ $tax }} USD
                        </p>
                    </div>
                    <div class="flex justify-between dark:text-gray-300">
                        <p>
                            Precios de envio
                            <i class="fas fa-info-circle" title="El precio de envío es de S/. 20.00"></i>
                        </p>
                        <p>
                            {{ $delivery }} USD
                        </p>
                    </div> 
                    <hr class="my-3 dark:border-gray-700">
                    <div class="flex justify-between dark:text-gray-300">
                        <p class="text-lg font-semibold">
                            Total
                        </p>
                        <p>
                            {{ $total }} USD
                        </p>

                    </div>

                    <div>
                        <p class="mb-4 dark:text-gray-300">Seleccione una método de pago</p>

                        <ul class="space-y-4">

                            <li x-data="{open: false}">
                                <button class="w-full flex justify-center bg-[#FF4240] py-2 rounded-lg shadow"
                                    x-on:click="open = !open">
                                    <img class="h-8" src="{{ asset('img/izipay.png') }}" alt="">
                                </button>

                                <div class="pt-6 pb-4 flex justify-center" x-show="open" style="display: none">
                                    <div class="kr-embedded" kr-form-token="{{$formToken}}">

                                        <div class="kr-pan"></div>

                                        <div class="kr-expiry"></div>
                                        <div class="kr-security-code"></div>

                                        <button class="kr-payment-button"></button>

                                        <div class="kr-form-error">
                                        </div>                           
                                    </div>

                                </div>

                            </li>

                            <li>
                                <button class="w-full flex justify-center bg-gray-100 py-2 rounded-lg shadow" onclick="VisanetCheckout.open()">
                                    <img class="h-8" src="{{ asset('img/niubiz.png') }}" alt="">
                                </button>
                            </li>

                            {{-- <li>
                                <button class="w-full flex justify-center bg-gray-100 py-2 rounded-lg shadow">
                                    <img class="h-8" src="{{ asset('img/paypal.png') }}" alt="">
                                </button>
                            </li>

                            <li>
                                <button class="w-full flex justify-center bg-gray-100 py-2 rounded-lg shadow">
                                    <img class="h-8" src="{{ asset('img/mercadopago.png') }}" alt="">
                                </button>
                            </li> --}}

                        </ul>                  

                    </div>


                    @if (session('niubiz'))
                    
                        @php
                            $niubiz = session('niubiz');
                            $response = $niubiz['response'];
                            $purchasenumber = $niubiz['purchasenumber'];
                        @endphp

                        @isset($response['data'])

                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 mt-8" role="alert">

                            <p class="mb-4">{{ $response['data']['ACTION_DESCRIPTION'] }}</p>

                            <p>
                                <b>Número de pedido</b>
                                {{$purchasenumber}}
                            </p>

                            <p>
                                <b>Fecha y hora del pedido</b>
                                {{ now()->createFromFormat('ymdHis', $response['data']['TRANSACTION_DATE'])->format('d/m/Y H:i:s') }}
                            </p>

                            @isset($response['data']['CARD'])
                            <p>
                                <b>Tarjeta:</b>
                                {{ $response['data']['CARD'] }} ({{ $response['data']['BRAND'] }})
                            </p>
                            @endisset

                        </div>
                            
                        @endisset

                    @endif

                </div>
            </div>

            <div class="col-span-1" x-cloak x-show="pago == 2">
                <div class="lg:max-w-[40rem] py-12 px-4 sm:pr-6 lg:pl-8 lg:pr-8 mr-auto">
                    <ul class="space-y-4 mb-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
                            <li class="flex items-center space-x-4 dark:text-gray-300">

                                <div class="flex-shrink-0 relative">

                                    <img class="h-16 aspect-square" src="{{ $item->options->image }}" alt="">
                                    <div
                                        class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="text-white font-semibold">
                                            {{ $item->qty }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p>
                                        {{ $item->name }}
                                    </p>
                                </div>

                            </li>
                        @endforeach

                    </ul>

                    <div class="flex justify-between dark:text-gray-300">
                        <p>
                            Subtotal
                        </p>
                        <p>
                            {{ $subtotal }} USD
                        </p>
                    </div>


                    <hr class="my-3 dark:border-gray-700">
                    <div class="flex justify-between dark:text-gray-300">
                        <p class="text-lg font-semibold">
                            Total
                        </p>
                        <p>
                            {{ $total }} USD
                        </p>

                    </div>
                </div>
            </div>


        </div>

        @push('js')
        <script type="text/javascript" src="{{config('services.niubiz.url_js')}}"></script>

        <script type="text/javascript">

            document.addEventListener('DOMContentLoaded', function() {
                let purchasenumber = Math.floor(Math.random() * 1000000000);
                let amount = {{ Cart::instance('shopping')->subtotal() }};
                VisanetCheckout.configure({
                sessiontoken:'{{$sessionToken}}',
                channel:'web',
                merchantid:"{{config('services.niubiz.merchant_id')}}",
                purchasenumber:purchasenumber,
                amount:amount,
                expirationminutes:'20',
                timeouturl:"{{route('checkout.index')}}",
                merchantlogo:'img/comercio.png',
                formbuttoncolor:'#000000',
                action: "{{ route('checkout.niubiz') }}" + '?purchaseNumber=' + purchasenumber + '&amount=' + amount,
                complete: function(params) {
                  alert(JSON.stringify(params));
                }
              });
            });
        </script>           
        @endpush
</x-app-layout>
