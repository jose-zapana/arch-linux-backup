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
        $post = $this->route()->parameter('post');  // Asegúrate de que 'blog' esté correcto
    
    
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'blogcategory_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:1,2',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
