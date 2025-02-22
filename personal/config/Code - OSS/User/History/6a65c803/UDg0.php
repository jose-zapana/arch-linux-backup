<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_at',
        'end_at',
        'payment_terms',
        'status',
        'reference',
        'notes',
        'discount',
        'subtotal',
        'tax',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function issued_tos()
    {
        return $this->hasMany(IssuedTo::class);
    }

    public function quotation_details()
    {
        return $this->hasMany(QuotationDetail::class);
    }
}