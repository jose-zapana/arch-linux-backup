<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

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

    protected $listeners = ['setExtract', 'setBody'];

    public function mount($post = null)
    {
        if ($post) {
            $this->post = $post->toArray();
            $this->selectedTags = $post->tags->pluck('id')->toArray();
        } else {
            $this->post['user_id'] = auth()->id();
        }

        $this->categories = BlogCategory::all();
        $this->tags = Tag::all();
    }

    // Genera el slug cada vez que el título cambia
    public function updatedPostTitle()
    {
        $this->post['slug'] = Str::slug($this->post['title']);
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
    
        $post = Post::create([
            'title' => $this->post['title'],
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
            'categories' => BlogCategory::all(),
            'tags' => Tag::all(),
        ]);
    }
}
