<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddProductModal extends Component
{
    public $search, $products = [];
    public $openModal = false;
    public $selectedProduct = null;

    public function liveSearch()
    {
        if (strlen($this->search) > 0) {
            $this->products = Product::join('subcategories as sub', 'sub.id', 'products.subcategory_id')
                ->join('categories as cat', 'cat.id', 'sub.category_id')
                ->select('products.*', 'sub.name as subname', 'cat.name as catname')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('sub.name', 'like', '%' . $this->search . '%')
                ->orWhere('cat.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.id', 'asc')
                ->get()->take(6);
        } else {
            return $this->products = [];
        }
    }

    public function render()
    {
        $this->liveSearch();
        return view('livewire.admin.quotes.add-product-modal');
    }

    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->dispatch('Product-Selected', $productId);
    }

    public function hideModal()
    {
        $openModal = false;
        $this->reset(); // Clear modal properties
    }
}