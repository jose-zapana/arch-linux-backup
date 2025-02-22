<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubcategoryEdit extends Component
{
    public $subcategory;
    public $families;
    public $subcategoryEdit;

    //mount the component
    public function mount($subcategory)
    {
        $this->families = Family::all();
        $this->subcategoryEdit = [
            'family_id' => $subcategory->category->family_id,
            'category_id' => $subcategory->category_id,
            'name' => $subcategory->name
        ];
    }

    //actualizar el family_id cuando se cambie el category_id
    public function updatedSubcategoryEditFamilyId()
    {
        $this->subcategoryEdit['category_id'] = '';
    }

    //Computar las categories
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->subcategoryEdit['family_id'])->get();
    }

    //actualizar el category_id cuando se cambie el family_id
    public function save()
    {
        $this->validate([
            'subcategoryEdit.family_id' => 'required|exists:families,id',
            'subcategoryEdit.category_id' => 'required|exists:categories,id',
            'subcategoryEdit.name' => 'required',
        ], [], [
            'subcategoryEdit.family_id' => 'familia',
            'subcategoryEdit.category_id' => 'categoría',
            'subcategoryEdit.name' => 'nombre'
        ]);
        $this->subcategory->update($this->subcategoryEdit);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Subcategoría actualizada correctamente',
        ]);

        return redirect()->route('admin.subcategories.edit', $this->subcategory->id);
    }

    //render the component
    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }
}
