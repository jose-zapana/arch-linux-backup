<?php

namespace App\Livewire\Admin\Posts;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Post;

class PostTable extends DataTableComponent
{
    protected $model = Post::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Title", "name")
                ->sortable(),
            Column::make("Slug", "slug")
                ->sortable(),
            Column::make("Body", "body")
                ->sortable(),

            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Blogcategory id", "blogcategory_id")
                ->sortable(),

            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
