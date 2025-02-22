<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color'
    ];
    //Relacion muchos a muchos
    //Un tag puede estar en muchos posts
    //Un post puede tener muchos tags
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
