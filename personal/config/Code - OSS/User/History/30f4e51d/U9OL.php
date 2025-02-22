<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Conversions\Manipulations as ConversionsManipulations;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

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

    public function registerMediaConversions(?Media $media = null): void
    {
        // Versión optimizada para móviles, sin exceso de tamaño
        $this->addMediaConversion('thumb')
             ->width(900)               // Ajustar el tamaño según la necesidad
             ->height(600)              // Mantener la relación de aspecto
             ->format('webp')           // WebP para menor tamaño de archivo
             ->quality(80)              // Comprimir con un 80% de calidad
             ->nonQueued();             // Procesar inmediatamente
    }
   
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($post) {
            $post->clearMediaCollection('posts');
        });
    }

}