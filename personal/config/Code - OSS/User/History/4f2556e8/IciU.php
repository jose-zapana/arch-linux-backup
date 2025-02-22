<?php

namespace App\Livewire\Admin\Products;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Código", "sku")
                ->sortable()
                ->searchable()
                ->collapseOnTablet(),

            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),

            Column::make("Precio S/.", "price")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Acciones", "id")
                ->format(fn ($value) => view('admin.products.action', ['id' => $value]))
                ->collapseOnTablet(),
        ];
    }
}
