<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\IssuedTo;
use App\Models\Quotation;
use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

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
                    return view('admin.quotes.generate', ['data' => $row]);
                }),
    


            Column::make("F. EMISION", "created_at")
                ->format(fn($value) => $value->format('d/m/Y'))
                ->sortable(),

            Column::make("Estado", "status")
                ->format(function ($value) {
                    return $value->name;
                })                
                ->sortable(),

            Column::make("Total", "total")
                ->format(fn($value) => 'S/ ' . number_format($value, 2))
                ->sortable(),

            Column::make("Actions")
                ->label(function ($row) {
                    return view('admin.quotes.actions', ['data' => $row]);
                }),
            Column::make("Acciones", "id")
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
                        ->mapWithKeys(fn($status) => [$status->value => $status->name])
                        ->toArray()
                ))
                ->filter(function ($query, $value) {
                    if (QuotationStatus::tryFrom($value)) {
                        $query->where('status', $value);
                    }
                }),
        ];
    }

    public function downloadPdf(Quotation $data)
    {
        dd($data);
    }

    public function builder(): Builder
    {
        return Quotation::query()
            ->with('issued_tos.user')
            ->orderBy('id', 'desc');
    }
}
