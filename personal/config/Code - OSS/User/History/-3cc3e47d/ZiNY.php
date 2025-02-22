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
        $blog = $this->route()->parameter('blog');
    
        $rules = [
            'name' => 'required|string|max:60',
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($blog ? $blog->id : ''),
            'blogcategory_id' => 'required|exists:blog_categories,id',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación del archivo
        ];
    
        // Si el estado es '2' (publicado), se requiere más información
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
