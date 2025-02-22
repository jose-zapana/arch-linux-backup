<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //Relacion uno a muchos
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function blogcategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

}