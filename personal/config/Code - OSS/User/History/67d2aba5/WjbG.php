<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\IssuedTo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        return view('admin.quotes.index');
    }

    public function create()
    {
        return view('admin.quotes.create');
    }
    public function edit($quotaId)
    {
        $quotation = Quotation::where('id', $quotaId)->with(['issued_tos', 'quotation_details'])->first();

        return view('admin.quotes.edit', compact('quotation'));
    }

    public function generatePdf($quotaId)
    {
        $data = Quotation::where('id', $quotaId)->with(['issued_tos', 'quotation_details'])->first();
        // dd($data);

        $pdf = Pdf::loadView('admin.pdf.quotation', compact('data'));
        return $pdf->stream('cotizacion.pdf');
    }
}
