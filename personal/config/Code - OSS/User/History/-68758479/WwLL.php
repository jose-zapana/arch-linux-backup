<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddToCart extends Component
{

    public $product;

    public $variant;

    public $stock;

    public $qty = 1;

    public $selectedFeatures = [];

    public function mount()
    {
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray();

        $this->getVariant();  
    }

    public function updatedSelectedFeatures()
    {
        $this->getVariant();
    }

    public function getVariant()
    {
        $this->variant = $this->product->variants->filter(function ($variant) {
            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures);
        })->first();

        $this->stock = $this->variant->stock;
        $this->qty = 1;
    }


    public function add_to_cart()
    {
        Cart::instance('shopping');

        //Existe algun producto con las caracteristicas seleccionadas
        $cart = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->options->sku === $this->variant->sku; 
        });

        if ($cart->isNotEmpty()) {
            $this->qty = $cart->first()->qty + $this->qty;
        }

        Cart::add(
            [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'qty' => $this->qty,
                'price' => $this->product->price,
                'options' => [
                    'image' => $this->product->image,
                    'sku' => $this->variant->sku,
                    'features' => Feature::whereIn('id', $this->selectedFeatures)
                        ->pluck('description', 'id')
                        ->toArray(),
                ],
                'tax' => 18,
            ])
            ->associate(Product::class);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->dispatch('cartUpdated', Cart::count());

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡bien!',
            'text' => 'Producto se ha añadido al carrito de compras.',
        ]);
    }
    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
