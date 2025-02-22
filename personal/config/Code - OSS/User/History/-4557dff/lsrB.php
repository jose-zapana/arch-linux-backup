<?php

namespace App\Observers;

class VariantObserver
{
    public function created(Variant $variant)
    {
        $variant->update([
            'price' => $variant->product->price
        ]);
    }
}
