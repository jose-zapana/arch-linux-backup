<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;  // Asegúrate de importar la enumeración

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
        $this->addMediaConversion('small_820x320')
            ->fit('crop', 820, 320)    // Ajustar y recortar la imagen para que encaje exactamente en 820x320
            ->format('webp')           // WebP para menor tamaño de archivo
            ->quality(90)              // Comprimir con un 90% de calidad
            ->nonQueued();             // Procesar inmediatamente
    }

}