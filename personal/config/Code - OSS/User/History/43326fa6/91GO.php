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
    public $search = ''; // Variable de búsqueda
    public $products = []; // Lista de productos encontrados

    public function mount()
    {
        Cart::instance('quotation');
        $this->users = User::all();
        $this->start_at = now()->format('Y-m-d');
        $this->payment_terms = 1;
        $this->status = 1;

        $this->updateCartValues();
    }



    public function updateCartValues()
    {
        Cart::instance('quotation');
        $this->subtotal = Cart::subtotal();
        $this->tax = Cart::tax();
        $this->total = Cart::total();
    }

    public function render()
    {
        return view('livewire.admin.quotes.quotation-create', [
            'cart' => Cart::content()->sortBy('name'),
            
        ]);
    }
}
