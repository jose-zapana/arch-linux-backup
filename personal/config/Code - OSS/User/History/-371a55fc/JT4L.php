<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $product;
    public $productEdit;
    public $image;

    public $families;
    public $family_id = '';
    public $category_id = '';

    public function mount($product)
    {
        // Cargar el producto y omitir el campo 'stock' en la edición
        $this->productEdit = $product->only('sku', 'name', 'description', 'image_path', 'price', 'subcategory_id');
        $this->families = Family::all();
        $this->category_id = $product->subcategory->category->id;
        $this->family_id = $product->subcategory->category->family_id;
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => 'El formulario contiene errores.'
                ]);
            }
        });
    }

    public function updatedFamilyId($value)
    {
        $this->category_id = '';
        $this->productEdit['subcategory_id'] = '';
    }

    public function updatedCategoryId($value)
    {
        $this->productEdit['subcategory_id'] = '';
    }

    #[On('variant-generate')]
    public function updateProduct()
    {
        $this->product = $this->product->fresh();
    }

    // Propiedad Computada para obtener categorías
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }

    // Propiedad Computada para obtener subcategorías
    #[Computed()]
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store()
    {
        // Validación sin el campo 'stock', ya que no debe ser editado
        $this->validate([
            'image' => 'nullable|image|max:1024',
            'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id,
            'productEdit.name' => 'required|max:255',
            'productEdit.description' => 'nullable',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        ], [], [
            'image' => 'imagen',
            'product.sku' => 'sku',
            'product.name' => 'nombre',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoría',
        ]);

        // Si se sube una nueva imagen, eliminar la antigua y almacenar la nueva
        if ($this->image) {
            Storage::delete($this->productEdit['image_path']);
            $this->productEdit['image_path'] = $this->image->store('products');
        }

        // Eliminar el campo 'stock' de la actualización
        $this->productEdit = array_except($this->productEdit, ['stock']);

        // Actualizar el producto sin afectar el stock
        $this->product->update($this->productEdit);

        // Mostrar un mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Producto actualizado!',
            'text' => 'El producto se actualizó correctamente.'
        ]);

        // Redirigir a la página de edición del producto
        return redirect()->route('admin.products.edit', $this->product->id);
    }

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
