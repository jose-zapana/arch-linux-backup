<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Filter extends Component
{
    use WithPagination;

    public $family_id;
    public $category_id;
    public $subcategory_id;
    public $options;
    public $selected_features = [];
    public $orderBy = 1;
    public $search;

    public function mount()
    {
        $this->options = Option::verifyFamily($this->family_id)
            ->VerifyCategory($this->category_id)
            ->VerifySubcategory($this->subcategory_id)
            ->get()->toArray();
    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        // Obtener productos relacionados con la familia a través de la subcategoría y categoría asociada
        $products = Product::verifyFamily($this->family_id)
            ->VerifyCategory($this->category_id)
            ->VerifySubcategory($this->subcategory_id)
            ->CustomOrder($this->orderBy)
            ->SelectFeatures($this->selected_features)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(12);
        // Pasar los productos a la vista
        return view('livewire.filter', compact('products'));
    }
}
