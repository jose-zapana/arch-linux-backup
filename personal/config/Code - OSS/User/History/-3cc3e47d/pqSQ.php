<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        if($this->user_id == auth()->user()->id) {
            return true;
        }else{
            return false;
        }

    }

    public function rules()
    {   

        $post = $this->route()->parameter('post');

        // Reglas básicas
        $rules = [
            'name' => 'required|string|max:60',
            'slug' => 'required|string|max:255|unique:posts,slug', // Asegúrate de que el slug sea único
            'blogcategory_id' => 'required|exists:blog_categories,id',  // Validar que la categoría exista
        ];

        if ($this->status == '2') {
            $rules = array_merge($rules, [

                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id', // Validar que cada etiqueta exista
                'extract' => 'required|string',
                'body' => 'required|string',
                'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Permitir solo imágenes con tamaño máximo
                
            ]);
        }


        return $rules;
    }
}
