<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cover extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'title', 'is_active', 'start_at', 'end_at'];

    protected $casts = [

        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->image_path),
        );
    }
}
