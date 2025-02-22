<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;

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
        $this->addMediaConversion('small_900x600')
            ->width(900)
            ->height(600)
            ->format('webp')
            ->quality(90)
            ->nonQueued();

    }

}