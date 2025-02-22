<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Product;
use App\Models\User;
use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class QuotationCreate extends Component
{
    public $start_at, $end_at, $payment_terms, $status, $reference, $notes, $discount, $subtotal, $tax, $total;
    public $users;
    public $qty = 1;
    public $customer_id;
    public $rowId;
    public $search, $products = [];

    public function mount()
    {
        Cart::instance('quotation');
        $this->users = User::all();
        $this->start_at = now()->format('Y-m-d');
        $this->payment_terms = 1;
        $this->status = 1;
        $this->updateCartValues();
        $this->products = []; // Inicializamos productos vacíos
    }

    public function updatedSearch()
    {
        // Buscar productos coincidentes con el término ingresado
        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%') // Cambiar barcode a sku
            ->limit(10) // Limitar la cantidad de resultados para no sobrecargar la vista
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.quotes.quotation-create', [
            'cart' => Cart::content()->sortBy('name'),
            'users' => $this->users,
        ]);
    }

    #[On('Product-Selected')]
    public function selectProduct($productId, $qty = 1)
    {
        $product = Product::findOrFail($productId);

        Cart::instance('quotation');
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'options' => [
                'image' => $product->image,
                'sku' => $product->sku, // Cambiar barcode a sku
                'features' => [],
            ],
        ]);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function updateCartValues()
    {
        // Actualiza los valores totales del carrito
        Cart::instance('quotation');
        $this->subtotal = Cart::subtotal();
        $this->tax = Cart::tax();
        $this->total = Cart::total();
    }
}
