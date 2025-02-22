<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogcategory) // Corregido
    {
        return view('admin.posts.categories.show', compact('blogcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogcategory) // Corregido
    {
        return view('admin.posts.categories.edit', compact('blogcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogcategory) // Corregido
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogcategory) // Corregido
    {
        //
    }


}
