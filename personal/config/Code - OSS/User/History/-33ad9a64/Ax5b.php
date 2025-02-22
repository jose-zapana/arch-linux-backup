<?php

namespace App\Livewire\Admin\Shipments;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Shipment;

class ShipmentTable extends DataTableComponent
{
    protected $model = Shipment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("N°", "order_id")
                ->sortable(),
            Column::make("Conductor", "driver.user.name")
                ->sortable(),
            Column::make("Placa", "driver.plate_number")
                ->sortable(),
            Column::make("Status", "status")
                ->format(function ($value) {
                    return $value->name;
                })
                ->sortable(),
            Column::make("Actions")
                ->label(function ($row) {
                    return view('admin.shipments.actions', ['shipment' => $row]);
                })

        ];
    }

    public function markAsCompleted(Shipment $shipment)
    {
        $shipment->status = ShipmentStatus::Completed;
        $shipment->save();
    }

    public function markAsFailed(Shipment $shipment)
    {
        //
    }
}
