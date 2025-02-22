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
        return view('admin.posts.categories.index', compact('posts'));
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
        $request->validate([
            'name' => 'required|unique:blog_categories',
            'slug' => 'required|unique:blog_categories',
            
        ]);
        
        $category = BlogCategory::create($request->all());
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bienfeito!',
            'text' => 'Categoría creada correctamente',
        ]);
        return redirect()->route('admin.posts.categories.edit', $category);
        
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
    public function edit(BlogCategory $blogcategory)
    {
        return view('admin.posts.categories.edit', compact('blogcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $category)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name,' . $category->id,
            'slug' => 'required|unique:blog_categories,slug,' . $category->id,
        ]);
    
        $category->update($request->all());
    
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bienfeito!',
            'text' => 'Categoría actualizada correctamente',
        ]);
    
        return redirect()->route('admin.posts.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogcategory) // Corregido
    {
        //
    }


}
