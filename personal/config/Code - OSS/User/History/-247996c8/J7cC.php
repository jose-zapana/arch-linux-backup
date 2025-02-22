<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\IssuedTo;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

use function Laravel\Prompts\select;

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
                    return view('admin.orders.ticket', ['order' => $row]);
                }),
            Column::make("F. EMISION", "created_at")
                ->format(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),

            Column::make("Status", "quotation.status")
                ->sortable(),
            Column::make("Discount", "quotation.discount")
                ->sortable(),
            Column::make("Total", "quotation.total")
                ->sortable(),
            Column::make("Acciones", "quotation.id")
                ->format(fn ($value) => view('admin.quotes.action', ['quotaId' => $value]))
                ->collapseOnTablet(),
        ];
    }

    public function builder(): Builder
    {
        return IssuedTo::query()
            ->with('user')
            ->with('quotation')
            ->orderBy('issued_tos.id', 'desc');
    }

}
