<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Services\CategoryTagService;

class PostCreate extends Component
{
    use WithFileUploads;

    public $post = [
        'name' => '',
        'slug' => '',
        'blogcategory_id' => '',
        'status' => 1,
        'extract' => '',
        'body' => '',
        'user_id' => '',
    ];
    public $selectedTags = [];
    public $file;
    public $categories;
    public $tags;
    public function setBody($content)
    {
    $this->post['body'] = $content;
    }

    protected $listeners = ['setExtract', 'setBody'];

    public function mount(CategoryTagService $categoryTagService, $post = null)
    {
        if ($post) {
            $this->post = $post->toArray();
            $this->selectedTags = $post->tags->pluck('id')->toArray();
        } else {
            $this->post['user_id'] = auth()->id();
        }
    
        // Cargar categorías y etiquetas desde el servicio
        $this->categories = $categoryTagService->getCategories();
        $this->tags = $categoryTagService->getTags();
    
        // Emitir un evento para inicializar CKEditor
        $this->emitSelf('initializeCKEditor');
    }
    public function updatedPostname()
    {
        $this->post['slug'] = Str::slug($this->post['name']);
    }

    public function save()
    {
        $validatedData = $this->validate([
            'post.name' => 'required|string|max:60', // Título SEO-friendly
            'post.slug' => 'required|string|max:255|unique:posts,slug',
            'post.blogcategory_id' => 'required|exists:blog_categories,id',
            'post.status' => 'required|in:1,2',
            'post.extract' => 'nullable|string|max:160', // Descripción SEO-friendly
            'post.body' => 'required|string',
            'file' => 'nullable|image|max:1024', // Límite de tamaño de archivo en KB
        ]);

        $post = Post::create([
            'name' => $this->post['name'],
            'slug' => $this->post['slug'],
            'blogcategory_id' => $this->post['blogcategory_id'],
            'status' => $this->post['status'],
            'extract' => $this->post['extract'],
            'body' => $this->post['body'],
            'user_id' => $this->post['user_id'],
        ]);

        if ($this->file) {
            $url = $this->file->store('posts', 'public');
            $post->image()->create(['url' => $url]);
        }

        if ($this->selectedTags) {
            $post->tags()->attach($this->selectedTags);
        }

        session()->flash('message', 'La publicación se ha guardado exitosamente.');

        return redirect()->route('admin.blogs.edit', $post);
    }

    public function render()
    {
        return view('livewire.admin.posts.post-create', [
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }
}
