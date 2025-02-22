<?php

namespace App\Livewire\Admin\Posts;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BlogCategory;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;


class CategoryTable extends DataTableComponent
{
    protected $model = BlogCategory::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Slug", "slug")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Image", "image")
                ->sortable(),

            LinkColumn::make('Action')
                ->title(fn($row) => 'Edit')
                ->location(fn($row) => route('admin.posts.categories.edit', $row)),
        ];
    }
}
