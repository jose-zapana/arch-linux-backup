<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\IssuedTo;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\User;
use CodersFree\Shoppingcart\Facades\Cart;
use DragonCode\Contracts\Cashier\Http\Request;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class QuotationCreate extends Component
{
    public $start_at, $end_at, $payment_terms, $status, $reference, $notes, $discount, $subtotal, $tax, $total;
    public $users;
    public $qty = 1;
    public $customer_id, $pais;
    public $rowId;



    public function mount()
    {
        Cart::instance('quotation');
        $this->users = User::all();
        $this->start_at = now()->format('Y-m-d');
        $this->payment_terms = 1;
        $this->status = 1;
        $this->qty = Cart::count();
        $this->discount = 0;
        $this->subtotal = Cart::subtotal();
        $this->tax = Cart::tax();
        $this->total = Cart::total();
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
        $products = Product::where('id', $productId)->first();

        Cart::instance('quotation');
        Cart::add(
            [
                'id' => $products->id,
                'name' => $products->name,
                'qty' => $qty,
                'price' => $products->price,
                'options' => [
                    'image' => $products->image,
                    'barcode' => $products->barcode,
                    'features' => []
                ]
            ]
        );

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }

    public function increase($rowId)
    {

        Cart::instance('quotation');
        Cart::update($rowId, Cart::get($rowId)->qty + 1);

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }

    public function decrease($rowId)
    {
        Cart::instance('quotation');
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

        Cart::instance('quotation');
        Cart::remove($rowId);

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
    }
    public function destroy()
    {
        Cart::instance('quotation');
        Cart::destroy();

        $this->dispatch('cartUpdated', Cart::count());

        if (auth()->check()) {
            Cart::store(auth()->id());
        }
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
                'qty' => $this->qty = Cart::count(),
                'subtotal' => $this->subtotal = Cart::subtotal(),
                'tax' => $this->tax = Cart::tax(),
                'total' => $this->total = Cart::total(),
            ]);

            if ($quotation) {
                Cart::instance('quotation');
                $items = Cart::content();
                foreach ($items as $item) {
                    QuotationDetail::create([
                        'quotation_id' => $quotation->id,
                        'product_id' => $item->id,
                        'price' => $item->price,
                        'quantity' => $item->qty,
                    ]);
                }

                IssuedTo::create([
                    'quotation_id' => $quotation->id,
                    'user_id' => $this->customer_id,
                ]);
            }

            Cart::instance('quotation');
            Cart::destroy();
            $this->customer_id = '';
            $this->end_at = '';

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cotización creada correctamente!',
            'text' => 'La cotización se creó correctamente.'
        ]);

        return redirect()->route('admin.quotes.create');
    }
}