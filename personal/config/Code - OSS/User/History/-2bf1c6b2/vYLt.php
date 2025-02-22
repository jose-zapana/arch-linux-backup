<?php

namespace App\Livewire\Admin\Posts;
use Livewire\Component;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use App\Http\Requests\StorePostRequest;
use Livewire\WithFileUploads;

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

    public function mount($post = null)
    {
        if ($post) {
            $this->post = $post->toArray();
            $this->selectedTags = $post->tags->pluck('id')->toArray(); // Asignar etiquetas existentes
        } else {
            $this->post['user_id'] = auth()->id(); // Establecer el user_id
        }

        $this->categories = BlogCategory::all();
        $this->tags = Tag::all();
    }

    public function save()
    {
        $validatedData = $this->validate([
            'post.title' => 'required|string|max:255',
            'post.slug' => 'required|string|max:255',
            'post.blogcategory_id' => 'required|exists:blog_categories,id',
            'post.status' => 'required|in:1,2',
            'post.extract' => 'nullable|string',
            'post.body' => 'required|string',
            'file' => 'nullable|image|max:1024', // Max 1MB
        ]);

        $post = Post::create($validatedData['post']);

        if ($this->file) {
            $url = $this->file->store('posts');
            $post->image()->create(['url' => $url]);
        }

        if ($this->selectedTags) {
            $post->tags()->attach($this->selectedTags);
        }

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
