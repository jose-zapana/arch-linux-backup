<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;

class Post extends Model
{
    use HasFactory;

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
        $this->addMediaConversion('mobile_small')
             ->width(400)               // Ajustar el tamaño según la necesidad
             ->height(400)              // Mantener la relación de aspecto
             ->format('webp')           // WebP para menor tamaño de archivo
             ->quality(80)              // Comprimir con un 80% de calidad
             ->nonQueued();             // Procesar inmediatamente
    }

}