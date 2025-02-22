<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'subcategory_id',
    ];
     public function scopeVerifyFamily($query, $family_id)
    {
        $query->when($family_id, function ($query, $family_id) {
            $query->whereHas('subcategory.category', function ($query) use ($family_id) {
                $query->where('family_id', $family_id);
            });
        });
    }

    public function scopeVerifyCategory($query, $category_id)
    {
        $query->when($category_id, function ($query, $category_id) {
            $query->whereHas('subcategory', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        });
    }

    public function scopeVerifySubcategory($query, $subcategory_id)
    {
        $query->when($subcategory_id, function ($query, $subcategory_id) {
            $query->where('subcategory_id', $subcategory_id);
        });
    }

    public function scopeCustomOrder($query, $orderBy)
    {
        $query->when($orderBy == 1, function ($query) {
            $query->orderBy('created_at', 'desc');
        })
            ->when($orderBy == 2, function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($orderBy == 3, function ($query) {
                $query->orderBy('price', 'asc');
            });
    }

    public function scopeSelectFeatures($query, $features)
    {
        $query->when($features, function ($query, $features) {
            $query->whereHas('variants.features', function ($query) use ($features) {
                $query->whereIn('features.id', $features);
            });
        });
    }

    //Relación uno a muchos inversa
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    //Relación uno a muchos
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    //Relación muchos a muchos
    public function options()
    {
        return $this->belongsToMany(Option::class)
            ->using(OptionProduct::class)
            ->withPivot('features')
            ->withTimestamps();
    }
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->image_path),
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function registerMediaCollections(Media $media = null): void
    {
        $this
            ->addMediaCollection('thumb')
            ->withResponsiveImages();
    }
}
