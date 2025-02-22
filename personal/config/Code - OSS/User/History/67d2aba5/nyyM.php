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

    public function generatePdf($id)
    {
        // Buscar la cotización con las relaciones necesarias
        $data = Quotation::where('id', $id)
            ->with(['issued_tos', 'quotation_details'])
            ->first();
    
        if (!$data) {
            abort(404, 'Cotización no encontrada.');
        }
    
        // Generar un nombre de archivo simple basado en el ID
        $fileName = "N°{$data->id}.pdf";
    
        // Generar el PDF
        $pdf = Pdf::loadView('admin.pdf.quotation', compact('data'))
            ->setPaper('a4');
    
        // Guardar el PDF en el almacenamiento
        $pdf->save(storage_path("app/public/quotations/{$fileName}"));
    
        // Actualizar la ruta del PDF en la base de datos
        $data->pdf_path = "quotations/{$fileName}";
        $data->save();
    
        // Retornar el PDF para visualización
        return $pdf->stream($fileName);
    }
}
