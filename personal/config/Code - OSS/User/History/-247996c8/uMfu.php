<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\IssuedTo;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quotation;
use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class QuotationTable extends DataTableComponent
{
    protected $model = Quotation::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("N°", "id")
                ->sortable(),

            Column::make("Visualizar")
                ->label(function ($row) {
                    return view('admin.quotes.generate', ['order' => $row]);
                }),

            Column::make("F. EMISION", "created_at")
                ->format(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),

            Column::make("Estado", "quotation.status")
                ->format(function ($value) {
                    // Asegurarse de que el valor sea un entero antes de usar tryFrom
                    $status = (int) $value; // Convertir el valor a entero
                    return QuotationStatus::tryFrom($status)?->name ?? 'Desconocido'; // Utilizar tryFrom con un valor de tipo entero
                })
                ->sortable(),
            

            Column::make("Total", "quotation.total")
                ->format(fn ($value) => 'S/ ' . number_format($value, 2))
                ->sortable(),

            Column::make("Actions")
                ->label(function ($row) {
                    return view('admin.orders.actions', ['order' => $row]);
                }),

            Column::make("Acciones", "quotation.id")
                ->format(fn ($value) => view('admin.quotes.action', ['quotaId' => $value]))
                ->collapseOnTablet(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Estado')
                ->options(array_merge(
                    ['' => 'Todos'],
                    collect(QuotationStatus::cases())
                        ->mapWithKeys(fn ($status) => [$status->value => $status->name])
                        ->toArray()
                ))
                ->filter(function ($query, $value) {
                    $query->where('status', $value);
                }),
        ];
    }

    public function downloadPdf(Quotation $order)
    {
        return Storage::download($order->pdf_path);
    }

    public function builder(): Builder
    {
        return IssuedTo::query()
            ->with('user')
            ->with('quotation')
            ->orderBy('issued_tos.id', 'desc');
    }
}
