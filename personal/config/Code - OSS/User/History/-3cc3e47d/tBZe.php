<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->check(); // Permitir si el usuario está autenticado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // Reglas básicas
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug', // Asegúrate de que el slug sea único
            'status' => 'required|in:1,2',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Permitir solo imágenes con tamaño máximo
        ];

        // Reglas adicionales si el estado es borrador
        if ($this->status == 2) {
            $rules = array_merge($rules, [
                'blogcategory_id' => 'required|exists:blog_categories,id', // Validar que la categoría exista
                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id', // Validar que cada etiqueta exista
                'extract' => 'required|string',
                'body' => 'required|string',
            ]);
        }

        return $rules;
    }
}
