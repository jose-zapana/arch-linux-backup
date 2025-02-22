<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <link rel="stylesheet" href="{{ asset('intranet/assets/css/invoice/style.css') }}" type="text/css" media="all" />
</head>

<body>
    <div>
        <div class="py-4">
            <div class="px-14 py-6">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-full align-top">
                                <div>
                                    <img src="{{ asset('img/logo2.png') }}" class="h-12" />
                                </div>
                            </td>

                            <td class="align-top">
                                <div class="text-sm">
                                    <table class="border-collapse border-spacing-0">
                                        <tbody>
                                            <tr>
                                                <td class="border-r pr-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">Fecha</p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">

                                                            <?php echo date('d/m/Y', strtotime($data->start_at)); ?>

                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-4">
                                                    <div>
                                                        <p class="whitespace-nowrap text-slate-400 text-right">
                                                            Cotización #
                                                        </p>
                                                        <p class="whitespace-nowrap font-bold text-main text-right">
                                                            COT- {{ $data->id }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-100 px-14 py-6 text-sm">
                <table class="w-full border-collapse border-spacing-0">
                    <tbody>
                        <tr>
                            <td class="w-1/2 align-top">
                                <div class="text-sm text-neutral-600">
                                    <p class="font-bold">PCHARD S.A.C</p>
                                    <p>RUC: 2061001513</p>
                                    <p>CEL: 957686487</p>
                                    <p>Av. Victor Malasquez</p>
                                    <p>Mz B1 Lt 06 - Huertos de Manchay</p>
                                    <p>Sector B</p>
                                </div>
                            </td>

                            @foreach ($data->issued_tos as $item)
                                <td class="w-1/2 align-top text-right">
                                    <div class="text-sm text-neutral-600">
                                        <p class="font-bold">{{ $item->user->name }} {{ $item->user->last_name }} </p>
                                        <p>{{ $item->user->document_number }}</p>
                                        <p>{{ $item->user->email }}</p>
                                        <p>{{ $item->user->phone }}</p>

                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-14 py-3 text-xs text-neutral-700">
                <table class="w-full border-collapse border-spacing-0">
                    <thead>
                        <tr>
                            <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
                            <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Descripción</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Precio</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Qty.</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Igv.</td>
                            <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Subtotal</td>

                        </tr>
                    </thead>
                    <tbody>

                        @if ($data->quotation_details->count())
                            @foreach ($data->quotation_details as $detail)
                                <tr>
                                    <td class="border-b py-3 pl-3">{{ $loop->index + 1 }}.</td>
                                    <td class="border-b py-3 pl-2">{{ $detail->product->name }}</td>
                                    <td class="border-b py-3 pl-2 text-right">{{ $detail->price }}</td>
                                    <td class="border-b py-3 pl-2 text-center">{{ $detail->quantity }}</td>
                                    <td class="border-b py-3 pl-2 text-center">
                                        {{ $igv = number_format($detail->price * $detail->quantity * 0.18, 2) }}</td>
                                    <td class="border-b py-3 pl-2 pr-3 text-right">
                                        {{ $subt = number_format($detail->price * $detail->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No se encontraron detalles de cotización.</td>
                            </tr>
                        @endif




                        <tr>
                            <td colspan="7">
                                <table class="w-full border-collapse border-spacing-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-full"></td>
                                            <td>
                                                <table class="w-full border-collapse border-spacing-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-b p-3">
                                                                <div class="whitespace-nowrap text-slate-400">Net
                                                                    total:
                                                                </div>
                                                            </td>
                                                            <td class="border-b p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-main">
                                                                    S/. {{ $data->subtotal }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-3">
                                                                <div class="whitespace-nowrap text-slate-400">IGV:
                                                                </div>
                                                            </td>
                                                            <td class="p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-main">
                                                                    S/. {{ $data->tax }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-main p-3">
                                                                <div class="whitespace-nowrap font-bold text-white">
                                                                    Total:</div>
                                                            </td>
                                                            <td class="bg-main p-3 text-right">
                                                                <div class="whitespace-nowrap font-bold text-white">
                                                                    S/. {{ $data->total }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-14 text-sm text-neutral-700">
                <p class="text-main font-bold">DETALLES DE PAGO</p>
                <p>Cuentas bancarias "INTERBANK"</p>
                <p>En Soles: 200-3004484086 | 003-200-003004484086-33</p>
                <p>En Dolares: 200-3004484093 | 003-200-003004484093-39</p>
            </div>

            <div class="px-14 py-10 text-sm text-neutral-700">
                <p class="text-main font-bold">Notas</p>
                <p class="italic">{{ $data->notes }}</p>
                </dvi>

                <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
                    Pc-Hard Technology
                    <span class="text-slate-300 px-2">|</span>
                    ventas@pc-hard.com
                    <span class="text-slate-300 px-2">|</span>
                    +51 957 686 487
                </footer>
            </div>
        </div>
</body>

</html>
