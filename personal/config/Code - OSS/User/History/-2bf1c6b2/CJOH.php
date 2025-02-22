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

    public function render()
    {
        return view('livewire.admin.posts.post-create');
    }
}
