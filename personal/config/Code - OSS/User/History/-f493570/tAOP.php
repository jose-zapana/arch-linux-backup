<?php

namespace App\Livewire\Admin\Posts;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Post;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PostTable extends DataTableComponent
{
    protected $model = Post::class;

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

            Column::make("Title", "name")
                ->sortable(),
            
            LinkColumn::make('Action')
                ->title(fn($row) => 'Edit')
                ->location(fn($row) => route('admin.blogs.edit', $row)),

        ];
    }
}
