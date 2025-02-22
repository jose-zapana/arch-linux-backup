<?php

namespace App\Livewire\Admin\Posts;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Post;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

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
                ->sortable()
                ->searchable(),

            Column::make("Title", "name")
                ->sortable()
                ->searchable(),

            Column::make("status", "status")
                ->sortable(),
            Column::make("Acciones", "slug")
                ->format(fn ($value) => view('admin.products.action', ['slug' => $value]))
                ->collapseOnTablet(),

        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Todos',
                    1 => 'No Publicado',
                    2 => 'Publicado',
                ])->filter(function ($query, $value) {
                    $query->where('status', $value);
                }),
        ];
    }
}
