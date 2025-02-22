<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

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

    //Propiedad Computada 
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store()
    {
        $this->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id,
            'productEdit.name' => 'required|max:255',
            'productEdit.description' => 'nullable',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        ], [], [
            'image' => 'imagen',
            'productEdit.sku' => 'sku',
            'productEdit.name' => 'nombre',
            'productEdit.price' => 'precio',
            'productEdit.subcategory_id' => 'subcategoría',
        ]);
    
        if ($this->image) {
            // Eliminar la imagen anterior si existe
            if (!empty($this->productEdit['image_path']) && Storage::exists($this->productEdit['image_path'])) {
                Storage::delete($this->productEdit['image_path']);
            }
    
            // Crear la instancia del administrador de imágenes
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $imageName = hexdec(uniqid()) . '.webp';
    
            // Leer, redimensionar y convertir la imagen
            $image = $manager->read($this->image->getRealPath());
            $image = $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
    
            $image->toWebp(90)->save(storage_path('app/public/products/' . $imageName));
    
            // Asignar la nueva ruta de la imagen al array de datos
            $this->productEdit['image_path'] = 'products/' . $imageName;
        }
    
        // Actualizar los datos del producto
        $this->product->update($this->productEdit);
    
        // Limpiar la caché
        Cache::flush();
    
        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Producto actualizado!',
            'text' => 'El producto se actualizó correctamente.',
        ]);
    
        return redirect()->route('admin.products.edit', $this->product->id);
    }
    

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
