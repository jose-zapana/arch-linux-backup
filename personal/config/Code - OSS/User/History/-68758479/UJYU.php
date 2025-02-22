<?php

namespace App\Livewire\Products;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddToCart extends Component
{

    public $product;

    public $qty = 1;

    public function add_to_cart()
    {
        Cart::instance('shopping');
        Cart::add(
            [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'qty' => $this->qty,
                'price' => $this->product->price,
                'options' => [
                    'image' => $this->product->image,
                    'barcode' => $this->product->barcode,
                    'features' => []
                ]
            ]
        );

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->dispatch('cartUpdated', Cart::count());


        return redirect('/cart');
    }

    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
