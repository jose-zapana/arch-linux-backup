<?php

namespace App\Services;

use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class CategoryTagService
{
    public function getCategories()
    {
        return Cache::remember('categories', 60, function () {
            return BlogCategory::all();
        });
    }

    public function getTags()
    {
        return Cache::remember('tags', 60, function () {
            return Tag::all();
        });
    }
}
