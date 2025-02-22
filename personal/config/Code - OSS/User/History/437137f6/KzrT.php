<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $families;
    public $family_id = '';
    public $category_id = '';
    public $image;

    public $product = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'image_path' => '',
        'price' => '',
        'subcategory_id' => '',
    ];

    public function mount()
    {
        $this->families = Family::all();
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
        $this->product['subcategory_id'] = '';
    }

    public function updatedCategoryId($value)
    {
        $this->product['subcategory_id'] = '';
    }

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
        // Validación de datos
        $this->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'product.sku' => 'required|unique:products,sku',
            'product.name' => 'required|max:255',
            'product.description' => 'nullable',
            'product.price' => 'required|numeric|min:0',
            'product.subcategory_id' => 'required|exists:subcategories,id',
        ], [], [
            'image' => 'imagen',
            'product.sku' => 'SKU',
            'product.name' => 'nombre',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoría',
        ]);

        // Crear el producto sin la imagen
        $product = Product::create($this->product);

        // Si la imagen fue cargada
        if ($this->image) {
            // Guarda la imagen original en la carpeta 'products' dentro de 'public'
            $path = $this->image->store('products', 'public'); 
            
            // Añade la imagen original al modelo y la guarda en la colección 'images'
            $media = $product->addMedia(storage_path('app/public/' . $path))
                            ->toMediaCollection('images', 'public');

            $product->refresh();  // Asegúrate de que el 
        }

        // Limpiar la caché
        Cache::flush();

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto creado correctamente.',
        ]);

        return redirect()->route('admin.products.edit', $product);
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
