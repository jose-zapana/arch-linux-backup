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

    public $post;
    public $categories;
    public $tags;
    public $selectedTags = [];
    public $file;
    public function mount($post = null)
    {
        $this->categories = BlogCategory::all();
        $this->tags = Tag::all();
        $this->post = $post ? $post->toArray() : [];
    }

    public function save()
    {
        $validatedData = $this->validate([
            'post.title' => 'required|string|max:255',
            'post.content' => 'required|string',
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
