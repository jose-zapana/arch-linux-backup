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
    
        // Crear el Post
        $post = Post::create($data);
    
        // Reasociar imágenes temporales al nuevo Post
        $temporaryMedia = Media::where('model_type', Post::class)
                               ->where('model_id', 0) // Imágenes temporales
                               ->where('custom_properties->temp', true) // Asegurarse de que son temporales
                               ->get();
    
        foreach ($temporaryMedia as $media) {
            $media->model_id = $post->id; // Reasociar al Post real
            $media->setCustomProperty('temp', false); // Marcar como no temporal
            $media->save();
        }
    
        // Si hay un archivo directo en el formulario, también subirlo
        if ($request->hasFile('file')) {
            $post->addMediaFromRequest('file')->toMediaCollection('posts');
            $post->refresh();
        }
    
        // Manejo de etiquetas
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }
    
        // Limpiar caché
        Cache::flush();
    
        // Notificación de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Post creado correctamente',
        ]);
    
        // Redirección al editor
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
        $blog->update($request->all()); // Asegúrate de guardar primero el blog.
    
        // Verificar si se ha subido un nuevo archivo de imagen.
        if ($request->hasFile('file')) {
            // Crear instancia del administrador de imágenes
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()) . '.webp';
    
            // Leer la imagen desde la ruta temporal
            $image = $manager->read($request->file('file')->getRealPath());
    
            // Redimensionar la imagen manteniendo la relación de aspecto
            $image = $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio(); // Mantener la proporción
                $constraint->upsize(); // Evitar que se agrande la imagen si es más pequeña que el tamaño objetivo
            });
    
            // Convertir la imagen a WebP y guardarla
            $image->toWebp(90)->save(storage_path('app/public/posts/' . $imageName));
    
            // Si el post ya tiene una imagen, eliminarla y actualizar la URL.
            if ($blog->image) {
                Storage::delete('public/' . $blog->image->url); // Eliminar la imagen anterior
                $blog->image->update(['url' => 'posts/' . $imageName]); // Actualizar la imagen existente
            } else {
                // Crear una nueva imagen solo después de guardar el blog
                $blog->image()->create(['url' => 'posts/' . $imageName]);
            }
        }
    
        // Sincronizar las etiquetas
        if ($request->tags) {
            $blog->tags()->sync($request->tags);
        } else {
            // Si no se seleccionaron etiquetas, eliminar todas las etiquetas asociadas
            $blog->tags()->detach();
        }
    
        // Limpiar la caché
        Cache::flush();
    
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Post actualizado correctamente',
        ]);
        
        // Cambiar redirección para usar el slug en lugar del id
        return redirect()->route('admin.blogs.edit', ['blog' => $blog->slug])->with('info', 'Post actualizado con éxito');
    }
    
    public function upload(Request $request)
    {
        // // Validar la imagen
        // $request->validate([
        //     'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
    
        // // Crear un modelo temporal con un identificador especial
        // $post = new Post();
        // $post->id = 0; 
        // $post->exists = true;
    
        // // Subir la imagen a la colección con un "indicador de temporalidad"
        // $media = $post->addMediaFromRequest('upload')
        //               ->withCustomProperties(['temp' => true]) // Propiedad para indicar que es temporal
        //               ->toMediaCollection('posts');
    
        // // Retornar la URL de la imagen para CKEditor
        // return response()->json([
        //     'url' => $media->getUrl(),
        // ]);
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
