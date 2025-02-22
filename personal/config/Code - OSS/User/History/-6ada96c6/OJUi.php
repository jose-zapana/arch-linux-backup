<?php

namespace App\Livewire\Admin\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        
        // Ordenar por id en orden descendente por defecto
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("id", "id")
                ->sortable()
                ->label('ID'),  // Cambiar el nombre a mayúsculas
            Column::make("name", "name")
                ->sortable()
                ->searchable()
                ->label('NAME'),  // Cambiar el nombre a mayúsculas
            Column::make("last_name", "last_name")
                ->sortable()
                ->searchable()
                ->label('LAST NAME'),  // Cambiar el nombre a mayúsculas
            Column::make("email", "email")
                ->sortable()
                ->searchable()
                ->label('EMAIL'),  // Cambiar el nombre a mayúsculas
            
            LinkColumn::make('Action')
                ->title(fn($row) => 'Edit')
                ->location(fn($row) => route('admin.users.edit', $row)),
        ];
    }
}
