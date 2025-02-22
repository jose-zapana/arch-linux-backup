<?php

namespace App\Livewire\Admin\Drivers;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Driver;

class DriverTable extends DataTableComponent
{
    protected $model = Driver::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Type", "type")
                ->format(function ($value) {
                    return $value->name;
                })
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),

            Column::make("Plate number", "plate_number")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
