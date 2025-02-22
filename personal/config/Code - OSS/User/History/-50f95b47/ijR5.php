<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Variant;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class CheckoutController extends Controller
{
    public function index()
    {

        Cart::instance('shopping');
        $content = Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        });

        $subtotal = $content->sum(function ($item) {
            return $item->subtotal;
        });

        $delivery = number_format(5,2);

        $tax = number_format($subtotal * 0.05,2) ;

        $total = $subtotal + $delivery + $tax;

        $formToken = $this->generateFormToken($total);
        $sessionToken = $this->generateSessionToken($total);

        return view('checkout.index', compact('formToken', 'sessionToken', 'content', 'subtotal', 'delivery', 'total', 'tax'));
    }

    private function generateSessionToken($total)
    {   
        $merchant_id = config('services.niubiz.merchant_id');

        $auth = base64_encode(config('services.niubiz.user').':'. config('services.niubiz.password'));
        $accessToken = Http::withHeaders([
            'Authorization' => "Basic $auth",
            'Content-Type' => 'application/json',           
        ])->get(config('services.niubiz.url_api') . 'api.security/v1/security')
        ->body();

        $sessionToken = Http::withHeaders([
            'Authorization' => $accessToken,
            'Content-Type' => 'application/json',
        ])->post(config('services.niubiz.url_api') . 'api.ecommerce/v2/ecommerce/token/session/' . config('services.niubiz.merchant_id'), [
            'channel' => 'web',
            'amount' => $total,
            'antifraud' => [
                'client_ip' => request()->ip(),
                'merchantDefineData' => [
                    'MDD15' => 'value15',
                    'MDD20' => 'value20',
                    'MDD33' => 'value33',
                ],
            ],
        ])->json();

        return $sessionToken['sessionKey'];        
    }

    public function niubiz(Request $request)
    {
        $auth = base64_encode(config('services.niubiz.user').':'. config('services.niubiz.password'));
        $accessToken = Http::withHeaders([
            'Authorization' => "Basic $auth",
            'Content-Type' => 'application/json',           
        ])->get(config('services.niubiz.url_api') . 'api.security/v1/security')
        ->body();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $accessToken,
        ])->post(config('services.niubiz.url_api') . 'api.authorization/v3/authorization/ecommerce/' . config('services.niubiz.merchant_id'), [
            'channel' => 'web',
            'captureType' => 'manual',
            'countable' => true,
            'order' => [
                'tokenId' => $request->transactionToken,
                'purchaseNumber' => $request->purchaseNumber,
                'amount' => $request->amount,
                'currency' => config('services.niubiz.currency'),
            ],
        ])->json();

        session()->flash('niubiz', [
            'response' => $response,
            'purchasenumber' => $request->purchasenumber,
        ]);

        if (isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] == '000') {

            Cart::instance('shopping');
            $content = Cart::content()->filter(function ($item) {
                return $item->qty <= $item->options['stock'];
            });

            $address = Address::where('user_id', auth()->id())
            ->where('default', true)
            ->first();
                  
            $data = [
                'user_id' => auth()->id(),
                'content' => $content,
                'address' => $address,
                'payment_id' => $response['dataMap']['TRANSACTION_ID'],
                'total' => $response['dataMap']['AMOUNT'],
            ];

                // Reglas de validación
            $rules = [
                'user_id' => 'required|exists:users,id',
                'content' => 'required',
                'address' => 'required',
                'payment_id' => 'required',
                'total' => 'required|numeric|min:0',
            ];

            $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();       
            }

            // Crear la orden
            $order = Order::create($data);
            
            foreach ($content as $item) {
                Variant::where('sku', $item->options['sku'])->decrement('stock', $item->qty);

                Cart::remove($item->rowId);
            }

            
            
            return redirect()->route('gracias');
        }  

        return redirect()->route('checkout.index');       
        
    }   

    private function generateFormToken($total)
    {
        $auth = base64_encode(config('services.izipay.client_id') .':'. config('services.izipay.client_secret'));

        // Convertir el total a centavos (entero)
        $amount = intval(round($total * 100));

        $response = Http::withHeaders([
            'Authorization' => "Basic $auth",
            'Content-Type' => 'application/json',           
        ])->post(config('services.izipay.url'), [
            'amount' => $amount,
            'currency' => 'USD',
            'orderId' => Str::random(10),
            'customer' => [
                'email' => auth()->user()->email,
            ]
        ])->json();

        return $response['answer']['formToken'];
    }   
    


    public function izipay(Request $request)
    {

        return $request->all();

        if ($request->get('kr-hash-algorithm') !== 'sha256_hmac') {
            throw new \Exception('Invalid hash algorithm');
        }

        $krAnswer = str_replace('\/', '/', $request->get('kr-answer'));

        $calculateHash = hash_hmac('sha256', $krAnswer, config('services.izipay.hash_key'));

        if ($calculateHash !== $request->get('kr-hash')) {
            throw new \Exception('Invalid hash');
        }


        return redirect()->route('gracias');
    }
    

}