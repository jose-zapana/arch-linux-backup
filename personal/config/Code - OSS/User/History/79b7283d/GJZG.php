<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRouteKeyName()
    {
        // Verifica si el parámetro es un número (id) o un slug
        if (is_numeric(request()->route('post'))) {
            return 'id'; // Usa el 'id' si la ruta contiene un número
        }
        
        return 'slug'; // Usa el 'slug' por defecto
    }
        
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
