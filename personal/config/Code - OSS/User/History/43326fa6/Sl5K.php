<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\User;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
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
    }

    public function render()
    {
        return view('livewire.admin.quotes.quotation-create', [
            'cart' => Cart::content()->sortBy('name'),
            'users' => User::all(),
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
                'barcode' => $product->barcode,
                'features' => [],
            ],
        ]);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function increase($rowId)
    {
        Cart::instance('quotation');
        Cart::update($rowId, Cart::get($rowId)->qty + 1);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function decrease($rowId)
    {
        Cart::instance('quotation');
        $item = Cart::get($rowId);

        if ($item->qty > 1) {
            Cart::update($rowId, $item->qty - 1);
        } else {
            Cart::remove($rowId);
        }

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function remove($rowId)
    {
        Cart::instance('quotation');
        Cart::remove($rowId);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function destroy()
    {
        Cart::instance('quotation');
        Cart::destroy();

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->updateCartValues();
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            Cart::instance('quotation');
            $quotation = Quotation::create([
                'start_at' => $this->start_at,
                'end_at' => $this->end_at,
                'payment_terms' => $this->payment_terms,
                'status' => $this->status,
                'notes' => $this->notes,
                'qty' => Cart::count(),
                'subtotal' => Cart::subtotal(),
                'tax' => Cart::tax(),
                'total' => Cart::total(),
            ]);

            foreach (Cart::content() as $item) {
                QuotationDetail::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                ]);
            }

            Cart::destroy();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return;
        }

        session()->flash('success', '¡Cotización creada correctamente!');
        return redirect()->route('admin.quotes.create');
    }

    private function updateCartValues()
    {
        Cart::instance('quotation');
        $this->subtotal = Cart::subtotal();
        $this->tax = Cart::tax();
        $this->total = Cart::total();
        $this->qty = Cart::count();
    }
}
