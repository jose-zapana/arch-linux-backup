<?php

namespace App\Services;

use App\Models\BlogCategory;
use App\Models\Tag;

class CategoryTagService
{
    public function getAllCategories()
    {
        return BlogCategory::all();
    }

    public function getAllTags()
    {
        return Tag::all();
    }
}
