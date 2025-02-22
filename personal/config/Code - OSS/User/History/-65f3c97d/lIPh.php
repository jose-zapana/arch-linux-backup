<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedTo extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'user_id',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}