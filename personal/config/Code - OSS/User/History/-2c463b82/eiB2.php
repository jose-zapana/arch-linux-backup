<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;
use PhpParser\Node\Stmt\If_;

class ShoppingCart extends Component
{
    public function mount()
    {
        Cart::instance('shopping');
    }

    #[Computed()]
    public function subTotal()

    {
        return Cart::content()->filter(function ($item) {
           return $item->qty <= $item->options['stock'];
        })->sum(function ($item) {
            return $item->subtotal;
        });
    }


    public function increase($rowId)
    {
        Cart::instance('shopping');
        Cart::update($rowId, Cart::get($rowId)->qty + 1);

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }

    public function decrease($rowId)
    {
        Cart::instance('shopping');
        $item = Cart::get($rowId);

        if ($item->qty > 1) {
            Cart::update($rowId, Cart::get($rowId)->qty - 1);
        } else {
            Cart::remove($rowId);
        }

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }

    public function remove($rowId)
    {
        Cart::instance('shopping');
        Cart::remove($rowId);

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }
    public function destroy()
    {
        Cart::instance('shopping');
        Cart::destroy();

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }



    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
