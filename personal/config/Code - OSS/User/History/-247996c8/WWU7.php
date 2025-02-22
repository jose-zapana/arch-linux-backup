<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\IssuedTo;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Builder;
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
                    return view('admin.orders.ticket', ['order' => $row]);
                }),
            
            Column::make("F. EMISION", "created_at")
                ->format(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),

            Column::make("Estado", "quotation.status")
                ->format(function ($value) {
                    $statuses = [
                        1 => 'Pendiente',
                        2 => 'Enviada',
                        3 => 'Aceptada',
                        4 => 'Rechazada',
                        5 => 'Vencida',
                        6 => 'Cancelada',
                        7 => 'En Revisión',
                        8 => 'Convertida en Orden',
                        9 => 'Archivada',
                    ];

                    return $statuses[$value] ?? 'Desconocido';
                })
                ->sortable(),

            Column::make("Total", "quotation.total")
                ->format(fn ($value) => ' S/ ' . $value)
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
                ->options([
                    '' => 'Todos',
                    1 => 'Pendiente',
                    2 => 'Enviada',
                    3 => 'Aceptada',
                    4 => 'Rechazada',
                    5 => 'Vencida',
                    6 => 'Cancelada',
                    7 => 'En Revisión',
                    8 => 'Convertida en Orden',
                    9 => 'Archivada',
                ])->filter(function ($query, $value) {
                    $query->where('estado', $value); // Cambié 'status' por 'estado' para reflejar el campo correspondiente.
                }),
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
