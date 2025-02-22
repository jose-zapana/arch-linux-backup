<?php

namespace App\Http\Requests;

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
        // Cambia 'post' por 'blog' para obtener el parámetro correcto de la ruta
        $blog = $this->route()->parameter('blog');

        $rules = [
            'name' => 'required|string|max:60',
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($blog ? $blog->id : ''), // Asegura que $blog no sea null
            'blogcategory_id' => 'required|exists:blog_categories,id',
        ];

        if ($this->status == '2') {
            $rules = array_merge($rules, [
                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id',
                'extract' => 'required|string',
                'body' => 'required|string',
                'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        return $rules;
    }
    
}
