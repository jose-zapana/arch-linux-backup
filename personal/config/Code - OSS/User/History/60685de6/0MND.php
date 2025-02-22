<?php

namespace App\Livewire\Admin\Posts;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Tag;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class TagTable extends DataTableComponent
{
    protected $model = Tag::class;

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
            Column::make("Color", "color")
                ->sortable(),

            LinkColumn::make('Action')
                ->title(fn($row) => 'Edit')
                ->location(fn($row) => route('admin.tags.edit', $row)),

        ];
    }
}
