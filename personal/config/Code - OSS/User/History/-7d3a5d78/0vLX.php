<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use App\Models\Variant;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductVariants extends Component
{
    public $product;
    public $openModal = false;

    //Resetear los features
    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ],
        ]
    ];

    //Resetear los features
    public function updatedVariantOptionId()
    {
        $this->variant['features'] = [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ],
        ];
    }

    //Computar las features
    #[Computed()]
    public function features()
    {
        return Feature::where('option_id', $this->variant['option_id'])->get();
    }

    public function getFeatures($option_id)
    {
        return Feature::where('option_id', $option_id)->get();
    }
    //Agregar un feature resetea el valor
    public function addFeature()
    {
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => '',
        ];
    }

    #[Computed()]
    public function options()
    {
        return Option::whereDoesntHave('products', function ($query) {
           $query->where('product_id', $this->product->id);
        })->get();
    }

    public $variantEdit = [
        'open' => false,
        'id' => null,
        'stock' => null,
        'sku' => null,
    ];

    public $new_feature = [
 
    ];
    //Cambia el feature
    public function feature_Change($index)
    {
        $feature = Feature::find($this->variant['features'][$index]['id']);

        if ($feature) {
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }

    //Eliminar un feature
    public function removeFeature($index)
    {
        unset($this->variant['features'][$index]);
        $this->variant['features'] = array_values($this->variant['features']);
    }
    //Eliminar un feature por id
    public function deleteFeature($option_id, $feature_id)
    {
        $this->product->options()->updateExistingPivot($option_id, [
            'features' => array_filter($this->product->options->find($option_id)->pivot->features, function ($feature) use ($feature_id) {
                return $feature['id'] != $feature_id;
            })
        ]);
 
        Variant::where('product_id', $this->product->id)
        ->whereHas('features', function ($query) use ($feature_id) {
            $query->where('features.id', $feature_id);
        })->delete();

        $this->product = $this->product->fresh();

    }

    //Eliminar opciones por id
    public function deleteOption($option_id)
    {
        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();

        $this->product->variants()->delete();        
        $this->generarVariantes();
    }
    //Guardar la variante
    public function save()
    {
        $this->validate([
            'variant.option_id' => 'required',
            'variant.features.*.id' => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        $features = collect($this->variant['features']);
        $features = $features->unique('id')->values()->all();


        $this->product->options()->attach($this->variant['option_id'], [
            'features' => $features
        ]);

        //$this->product = $this->product->fresh();

        $this->product->variants()->delete();

        $this->generarVariantes();

        $this->reset('variant', 'openModal');
    }

    public function generarVariantes()
    {
        $features = $this->product->options->pluck('pivot.features');
        $combinaciones = $this->generarCombinaciones($features);
        
        foreach ($combinaciones as $combinacion) {

            $variant = Variant::create([
                'product_id' => $this->product->id,
            ]);
            $variant->features()->attach($combinacion);
        }

        $this->dispatch('variant-generate');
    }
    function  generarCombinaciones($arrays, $indice = 0, $combinacion = [])
    {

        if ($indice == count($arrays)) {
            return [$combinacion];
        }

        $resultado = [];
        foreach ($arrays[$indice] as $item) {
            $combinacionesTemporal = $combinacion;
            $combinacionesTemporal[] = $item['id'];
            $resultado = array_merge($resultado, $this->generarCombinaciones($arrays, $indice + 1, $combinacionesTemporal));
        }
        return  $resultado;
    }

    public function editVariant(Variant $variant)
    {        
        $this->variantEdit = [
            'open' => true,
            'id' => $variant->id,
            'stock' => $variant->stock,
            'sku' => $variant->sku,
        ];
    }

    public function updateVariant()
    {   
        $this->validate([
            'variantEdit.stock' => 'required|numeric',
            'variantEdit.sku' => 'required',
        ]);

        $variant = Variant::find($this->variantEdit['id']);

        $variant->update([
            'stock' => $this->variantEdit['stock'],
            'sku' => $this->variantEdit['sku'],
        ]);

        $this->reset('variantEdit');

        $this->product = $this->product->fresh();

    }

    //Renderizar
    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
