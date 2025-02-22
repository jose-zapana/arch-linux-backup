<?php

namespace App\Observers;

use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteObserver
{
    public function created(Quotation $data)
    {
        $pdf = Pdf::loadView('admin.pdf.quotation', compact('data'))->setPaper('A4');

        $pdf->save(storage_path('app/public/quotations/cotizacion-' . $data->id . '.pdf'));
    
        $data->pdf_path = 'quotations/cotizacion-' . $data->id . '.pdf';
    
        $data->save();
    }
}
