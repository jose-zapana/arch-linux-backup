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
    public $post = [
        'title' => '',
        'body' => '',
        'category_id' => '',
        'tags' => [],
        'file' => null        
    ];

    public $categories = [];
    public $tags = [];

    public function store()
    {
        $this->validate([
            'post.title' => 'required',
            'post.body' => 'required',
            'post.category_id' => 'required',
            'post.tags' => 'required',
            'post.file' => 'required'
        ]);
    }

    public function mount()
    {
        $this->post = [
            'title' => '',
            'body' => '',
            'category_id' => '',
            'tags' => [],
            'file' => null
        ];

        $this->post['tags'][] = '';

        $this->post['category_id'] = \App\Models\Category::first()->id;
        
    }

    public function addTag()
    {
        $this->post['tags'][] = '';
    }

    public function removeTag($index)
    {
        unset($this->post['tags'][$index]);
        $this->post['tags'] = array_values($this->post['tags']);
    }

    public function renderTags()
    {
        return view('livewire.admin.posts.post-create-tags', [
            'tags' => $this->post['tags']
        ]);
    }

    public function renderCategories()
    {
        return view('livewire.admin.posts.post-create-categories', [
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function renderTagsInput()
    {
        return view('livewire.admin.posts.post-create-tags-input', [
            'tags' => $this->post['tags']
        ]);
    }

    public function renderFileInput()
    {
        return view('livewire.admin.posts.post-create-file-input', [
            'file' => $this->post['file']
        ]);
    }



    public function render()
    {
        return view('livewire.admin.posts.post-create');
    }
}
