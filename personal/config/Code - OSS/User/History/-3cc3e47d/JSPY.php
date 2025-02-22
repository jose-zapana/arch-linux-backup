<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        // if($this->user_id == auth()->user()->id) {
        //     return true;
        // }else{
        //     return false;
        // }

        return true;
    }

    public function rules()
    {
        $slug = $this->route()->parameter('blog'); // Obtener el slug de la ruta
    
        // Buscar el modelo Blog usando el slug
        $blog = Post::where('slug', $slug)->first();
    
        // Verificar si el blog fue encontrado
        if (!$blog) {
            // Lógica en caso de que no se encuentre el blog, como lanzar una excepción
            abort(404, 'Blog no encontrado');
        }
    
        $rules = [
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($blog ? $blog->id : ''),
            'blogcategory_id' => 'required|exists:blog_categories,id',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ];
    
        if ($this->status == '2') {
            $rules = array_merge($rules, [
                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id',
                'extract' => 'required|string',
                'body' => 'required|string',
            ]);
        }
    
        return $rules;
    }
    
}
