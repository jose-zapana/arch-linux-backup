<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PostEdit extends Component
{
    use WithFileUploads;

    public $postEdit;
    public $file;

    public $categories;
    public $tags;
    public $selectedTags = [];

    public function mount($slug) // Cambiamos el parámetro a slug
    {
        // Buscamos el post por su slug, en lugar de su ID
        $this->postEdit = Post::where('slug', $slug)->firstOrFail()->only('id', 'name', 'slug', 'extract', 'body', 'blogcategory_id', 'status');
        
        // Asignamos las etiquetas seleccionadas
        $this->selectedTags = $this->postEdit->tags->pluck('id')->toArray();

        // Cargar categorías y etiquetas
        $this->categories = BlogCategory::all();
        $this->tags = Tag::all();
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => 'El formulario contiene errores.'
                ]);
            }
        });
    }

    public function updatedPostEditName()
    {
        $this->postEdit['slug'] = Str::slug($this->postEdit['name']);
    }

    #[On('tag-update')]
    public function updatePost()
    {
        $this->post = $this->post->fresh();
    }

    // Propiedad Computada para mostrar categorías
    #[Computed()]
    public function computedCategories()
    {
        return BlogCategory::all();
    }

    #[Computed()]
    public function computedTags()
    {
        return Tag::all();
    }

    public function store()
    {
        $this->validate([
            'file' => 'nullable|image|max:1024',
            'postEdit.name' => 'required|string|max:255',
            'postEdit.slug' => 'required|string|max:255|unique:posts,slug,' . $this->postEdit['id'],
            'postEdit.blogcategory_id' => 'required|exists:blog_categories,id',
            'postEdit.status' => 'required|in:1,2',
            'postEdit.extract' => 'nullable|string',
            'postEdit.body' => 'required|string',
        ], [], [
            'file' => 'imagen',
            'postEdit.name' => 'nombre',
            'postEdit.slug' => 'slug',
            'postEdit.blogcategory_id' => 'categoría',
            'postEdit.status' => 'estado',
            'postEdit.extract' => 'extracto',
            'postEdit.body' => 'contenido',
        ]);

        if ($this->file) {
            Storage::delete($this->postEdit['image_path']);
            $this->postEdit['image_path'] = $this->file->store('posts');
        }

        // Actualizamos el post con los datos editados
        Post::where('slug', $this->postEdit['slug'])->update($this->postEdit);
        
        // Actualizamos las etiquetas seleccionadas
        $post = Post::where('slug', $this->postEdit['slug'])->first();
        $post->tags()->sync($this->selectedTags);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Post actualizado!',
            'text' => 'El post se actualizó correctamente.'
        ]);

        return redirect()->route('admin.blogs.edit', ['blog' => $this->postEdit['slug']]);
    }

    public function render()
    {
        return view('livewire.admin.posts.post-edit');
    }
}
