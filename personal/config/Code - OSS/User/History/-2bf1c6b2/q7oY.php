<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostCreate extends Component
{
    use WithFileUploads;

    public $post = [
        'title' => '',
        'slug' => '',
        'blogcategory_id' => '',
        'status' => 1,
        'extract' => '',
        'body' => '',
        'user_id' => '',
    ];

    public $selectedTags = [];
    public $file;
    public $image;
    protected $categories = []; // Inicializamos como array vacío
    protected $tags = []; // Inicializamos como array vacío

    protected $listeners = ['setExtract', 'setBody', 'setSlug'];

    public function mount($post = null)
    {
        $this->categories = BlogCategory::all() ?? []; // Si es null, asigna array vacío
        $this->tags = Tag::all() ?? []; // Si es null, asigna array vacío

        if ($post) {
            $this->post = $post->toArray();
            $this->selectedTags = $post->tags->pluck('id')->toArray();
        } else {
            $this->post['user_id'] = Auth::id();
        }
    }

    public function setSlug($slug)
    {
        $this->post['slug'] = $slug;
    }

    public function setExtract($data)
    {
        $this->post['extract'] = $data;
    }

    public function setBody($data)
    {
        $this->post['body'] = $data;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'post.title' => 'required|string|max:255',
            'post.slug' => 'required|string|max:255|unique:posts,slug',
            'post.blogcategory_id' => 'required|exists:blog_categories,id',
            'post.status' => 'required|in:1,2',
            'post.extract' => 'nullable|string',
            'post.body' => 'required|string',
            'file' => 'nullable|image|max:1024',
        ]);

        $post = Post::create($validatedData['post']);

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
