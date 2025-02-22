<?php

namespace App\Observers;

use App\Models\Quotation;

class QuoteObserver
{
    public function created(Quotation $quotation)
    {
        $quotation->pdf_path = 'quotations/cotizacion-' . $quotation->id . '.pdf';
        $quotation->save();
    }
}
