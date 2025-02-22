<x-app-layout>

    <div class="max-w-3xl mx-auto pt-12">

        <img class="w-full" src="https://d1ih8jugeo2m5m.cloudfront.net/2024/01/gracias-por-tu-compra-minimalista.jpg"
            alt="">


        @if (session('niubiz'))
            @php
                $response = session('niubiz')['response'];
            @endphp

            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <p>
                        {{ $response['dataMap']['ACTION_DESCRIPTION'] }}
                    </p>
                    <p>
                        <b>Número de pédido:</b>
                        {{ $response['order']['purchaseNumber'] }}
                    </p>
                    <p>
                        <b>Fecha y hora del pédido:</b>
                        {{ now()->createFromFormat('ymdHis', $response['dataMap']['TRANSACTION_DATE'])->format('d/m/Y H:i:s') }}
                    </p>
                    <p>
                        <b>Tarjeta:</b>
                        {{ $response['dataMap']['CARD'] }} ({{ $response['dataMap']['BRAND'] }})
                    </p>
                    <p>
                        <b>Importe:</b>
                        {{ $response['order']['amount'] }} {{ $response['order']['currency'] }}
                    </p>
                </div>
            </div>        

            @elseif (session('izipay'))
            @php
                $izipay = session('izipay');
                $transactionStatus = $izipay['transactionStatus'] ?? 'Estado no disponible';
                $orderId = $izipay['purchasenumber'] ?? 'N/A';
                $orderTotalAmount = $izipay['orderTotalAmount'] ?? 'Monto no disponible';
                $serverDate = $izipay['serverDate'] ?? 'Fecha no disponible';
            @endphp
        
            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <h1>¡Gracias por tu compra!</h1>
                    <p><strong>Estado del Pago:</strong> {{ $transactionStatus }}</p>
                    <p><strong>Número de Pedido:</strong> {{ $orderId }}</p>
                    <p><strong>Monto:</strong> {{ $orderTotalAmount }} USD</p>
                    <p><strong>Fecha de la Transacción:</strong> {{ $serverDate }}</p>
                </div>
            </div>
        
        @else
            <div class="p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">
                No se encontró información de la transacción.
            </div>
        @endif

    </div>



</x-app-layout>
