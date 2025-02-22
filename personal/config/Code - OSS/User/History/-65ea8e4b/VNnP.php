<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return view('admin.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = BlogCategory::all();
        $tags = Tag::all();

        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // Crear el post con los datos validados
        $blog = Post::create($request->validated());
    
        // Regex para extraer las URLs de imágenes del contenido del body
        $re_extractImages = '/src=["\']([^"\']+)["\']/ims';
        preg_match_all($re_extractImages, $request->body, $matches);
        $usedImages = $matches[1] ?? [];
    
        // Convertir las URLs usadas a nombres de archivo
        $usedMediaFiles = array_map(function ($url) {
            return basename(parse_url($url, PHP_URL_PATH));
        }, $usedImages);
    
        // Procesar las imágenes referenciadas en el body
        $replacedUrls = [];
        foreach ($usedImages as $imageUrl) {
            $absolutePath = public_path(parse_url($imageUrl, PHP_URL_PATH));
    
            if (file_exists($absolutePath)) {
                $mediaItem = $blog->addMedia($absolutePath)->toMediaCollection('posts');
                $convertedUrl = $mediaItem->getUrl('posts');
                $replacedUrls[$imageUrl] = $convertedUrl;
    
                Storage::delete(str_replace(storage_path('app/public/'), '', $absolutePath));
            }
        }
    
        // Reemplazar las URLs en el contenido del body con las URLs de la conversión 'posts'
        foreach ($replacedUrls as $oldUrl => $newUrl) {
            $request->body = str_replace($oldUrl, $newUrl, $request->body);
        }
    
        // Actualizar el body del post con las URLs procesadas
        $blog->update(['body' => $request->body]);
    
        // Manejar la imagen destacada
        if ($request->hasFile('file')) {
            $blog->addMediaFromRequest('file')->toMediaCollection('images');
        }
    
        // Sincronizar etiquetas
        if ($request->filled('tags')) {
            $blog->tags()->sync($request->tags);
        }
    
        // Actualizar el campo `status` si está presente
        if ($request->has('status')) {
            $blog->update(['status' => $request->status]);
        }
    
        Cache::flush();
    
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Post creado correctamente',
        ]);
    
        return redirect()->route('admin.blogs.edit', ['blog' => $blog->slug])
                         ->with('info', 'Post creado con éxito');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {   

        return view('admin.blogs.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $blog)
    {   
        $this->authorize('author', $blog);
        // return dd($blog);
        $categories = BlogCategory::all();
        $tags = Tag::all();

        Cache::flush();
        
        return view('admin.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(PostRequest $request, Post $blog)
     {
         $this->authorize('author', $blog);
     
         // Actualizar los datos generales del post
         $blog->update($request->validated());
     
         // Obtener imágenes existentes en Media Library
         $existingMedia = $blog->getMedia('posts');
     
         // Regex para extraer las URLs de imágenes del contenido actualizado
         $re_extractImages = '/src=["\']([^"\']+)["\']/ims';
         preg_match_all($re_extractImages, $request->body, $matches);
         $usedImages = $matches[1] ?? [];
     
         // Convertir las URLs usadas a nombres de archivo
         $usedMediaFiles = array_map(function ($url) {
             return basename(parse_url($url, PHP_URL_PATH));
         }, $usedImages);
     
         // Procesar las imágenes referenciadas en el body
         $replacedUrls = [];
         foreach ($usedImages as $imageUrl) {
             $absolutePath = public_path(parse_url($imageUrl, PHP_URL_PATH));
     
             if (file_exists($absolutePath) && !$existingMedia->pluck('file_name')->contains(basename($absolutePath))) {
                 $mediaItem = $blog->addMedia($absolutePath)->toMediaCollection('posts');
                 $convertedUrl = $mediaItem->getUrl('posts');
                 $replacedUrls[$imageUrl] = $convertedUrl;
     
                 Storage::delete(str_replace(storage_path('app/public/'), '', $absolutePath));
             } else {
                 $mediaItem = $existingMedia->firstWhere('file_name', basename($imageUrl));
                 if ($mediaItem) {
                     $convertedUrl = $mediaItem->getUrl('posts');
                     $replacedUrls[$imageUrl] = $convertedUrl;
                 }
             }
         }
     
         // Reemplazar las URLs en el contenido del body con las URLs de la conversión 'posts'
         foreach ($replacedUrls as $oldUrl => $newUrl) {
             $request->body = str_replace($oldUrl, $newUrl, $request->body);
         }
     
         $blog->update(['body' => $request->body]);
     
         // Eliminar imágenes huérfanas
         foreach ($existingMedia as $mediaItem) {
             if (!in_array($mediaItem->file_name, $usedMediaFiles)) {
                 $mediaItem->delete();
             }
         }
     
         // Manejar la imagen destacada
         if ($request->hasFile('file')) {
             if ($blog->getFirstMedia('images')) {
                 $blog->getFirstMedia('images')->delete();
             }
     
             $blog->addMediaFromRequest('file')->toMediaCollection('images');
         }
     
         // Sincronizar etiquetas
         if ($request->filled('tags')) {
             $blog->tags()->sync($request->tags);
         } else {
             $blog->tags()->detach();
         }
     
         // Actualizar el campo `status` si está presente
         if ($request->has('status')) {
             $blog->update(['status' => $request->status]);
         }
     
         Cache::flush();
     
         session()->flash('swal', [
             'icon' => 'success',
             'title' => '¡Bien hecho!',
             'text' => 'Post actualizado correctamente',
         ]);
     
         return redirect()->route('admin.blogs.edit', ['blog' => $blog->slug])
                          ->with('info', 'Post actualizado con éxito');
     }
     
     
     
     
    
    public function upload(Request $request)
    {
        $path = Storage::put('posts', $request->file('upload'));
        return [
            'url' => Storage::url($path)
        ];
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $blog)
    {
        $this->authorize('author', $blog);
        // Eliminar imagen si existe
        if ($blog->image) {
            Storage::delete($blog->image->url);
            $blog->image()->delete();
        }

        $blog->delete();

        Cache::flush();

        return redirect()->route('admin.blogs.index');
    }
}
