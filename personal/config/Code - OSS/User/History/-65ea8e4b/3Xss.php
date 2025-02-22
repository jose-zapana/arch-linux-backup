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
        $data = $request->all();
        $data['user_id'] = Auth::id();
    
        // Crear el post
        $post = Post::create($data);
    
        // Regex para extraer las URLs de las imágenes del contenido del body
        $re_extractImages = '/src=["\']([^ ^"^\']*)["\']/ims';
        preg_match_all($re_extractImages, $data['body'], $matches);
        $images = $matches[1];
    
        // Array para reemplazar las URLs en el contenido del body
        $replacedUrls = [];
    
        foreach ($images as $image) {
            // Convertir la URL pública en la ruta absoluta del archivo
            $absolutePath = public_path(parse_url($image, PHP_URL_PATH));
    
            // Verificar si el archivo existe antes de procesarlo
            if (file_exists($absolutePath)) {
                // Agregar la imagen desde la ruta absoluta a Media Library
                $mediaItem = $post->addMedia($absolutePath)
                                  ->toMediaCollection('posts');
    
                // Obtener la URL de la conversión 'thumb' en formato WebP
                $webpUrl = $mediaItem->getUrl('thumb');
    
                // Reemplazar la URL temporal por la nueva URL de la conversión
                $replacedUrls[$image] = $webpUrl;
    
                // Eliminar la imagen temporal del directorio `posts`
                Storage::delete(str_replace(Storage::url(''), '', $image));
            }
        }
    
        // Reemplazar las URLs en el contenido del body
        foreach ($replacedUrls as $oldUrl => $newUrl) {
            $data['body'] = str_replace($oldUrl, $newUrl, $data['body']);
        }
    
        // Actualizar el body del post con las nuevas URLs
        $post->update(['body' => $data['body']]);
    
        // Si hay una imagen destacada, agregarla también a Media Library
        if ($request->hasFile('file')) {
            $post->addMediaFromRequest('file')
                 ->toMediaCollection('images');
        }
    
        // Adjuntar etiquetas si existen
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }
    
        // Limpiar la caché
        Cache::flush();
    
        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Post creado correctamente',
        ]);
    
        // Redirigir al formulario de edición
        return redirect()->route('admin.blogs.edit', ['blog' => $post->slug]);
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
     
         // Actualizar los datos del post
         $blog->update($request->validated());
     
         // Obtener imágenes existentes en Media Library (colección 'posts')
         $existingMedia = $blog->getMedia('posts');
     
         // Regex para extraer las URLs de imágenes del contenido actualizado
         $re_extractImages = '/src=["\']([^"\']+)["\']/ims';
         preg_match_all($re_extractImages, $request->body, $matches);
         $usedImages = $matches[1] ?? [];
     
         // Convertir las URLs usadas a nombres de archivo
         $usedMediaFiles = array_map(function ($url) {
             return basename(parse_url($url, PHP_URL_PATH));
         }, $usedImages);
     
         // Almacenar URLs convertidas (thumb)
         $replacedUrls = [];
     
         // Procesar las imágenes referenciadas en el body
         foreach ($usedImages as $imageUrl) {
             $absolutePath = public_path(parse_url($imageUrl, PHP_URL_PATH));
     
             if (file_exists($absolutePath) && !$existingMedia->pluck('file_name')->contains(basename($absolutePath))) {
                 $mediaItem = $blog->addMedia($absolutePath)->toMediaCollection('posts');
                 $thumbUrl = $mediaItem->getUrl('thumb');
                 $replacedUrls[$imageUrl] = $thumbUrl;
     
                 // Eliminar archivo temporal si fue cargado desde un directorio temporal
                 Storage::delete(str_replace(storage_path('app/public/'), '', $absolutePath));
             } else {
                 // Si la imagen ya existe en Media Library, obtener su versión thumb
                 $mediaItem = $existingMedia->firstWhere('file_name', basename($imageUrl));
                 if ($mediaItem) {
                     $thumbUrl = $mediaItem->getUrl('thumb');
                     $replacedUrls[$imageUrl] = $thumbUrl;
                 }
             }
         }
     
         // Reemplazar las URLs en el contenido del body con las URLs de las versiones 'thumb'
         foreach ($replacedUrls as $oldUrl => $newUrl) {
             $request->body = str_replace($oldUrl, $newUrl, $request->body);
         }
     
         // Actualizar el contenido del body con las nuevas URLs
         $blog->update(['body' => $request->body]);
     
         // Eliminar imágenes huérfanas en Media Library (no referenciadas en el contenido actualizado)
         foreach ($existingMedia as $mediaItem) {
             if (!in_array($mediaItem->file_name, $usedMediaFiles)) {
                 $mediaItem->delete(); // Eliminar de Media Library y Storage
             }
         }
     
         // Manejar la imagen destacada si se proporciona una nueva
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
     
         // Limpiar caché
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
