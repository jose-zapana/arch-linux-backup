<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuotationStatus;

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

    /**
     * Relaciones
     */

    // Relación con User (creador de la cotización)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Product (si aplica a un producto específico)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con IssuedTo (entidades a las que se emitió la cotización)
    public function issued_tos()
    {
        return $this->hasMany(IssuedTo::class);
    }

    // Relación con QuotationDetail (detalles de productos o servicios cotizados)
    public function quotation_details()
    {
        return $this->hasMany(QuotationDetail::class);
    }

    /**
     * Accesores y Mutadores
     */

    // Accesor para formato de estado
    public function getStatusNameAttribute(): string
    {
        return QuotationStatus::tryFrom($this->status)?->name ?? 'Desconocido';
    }

    // Accesor para formato de total
    public function getFormattedTotalAttribute(): string
    {
        return 'S/ ' . number_format($this->total, 2);
    }

    /**
     * Métodos adicionales
     */

    // Verificar si la cotización está activa
    public function isActive(): bool
    {
        return $this->status === QuotationStatus::Pending->value;
    }

    // Verificar si la cotización está expirada
    public function isExpired(): bool
    {
        return now()->greaterThan($this->end_at);
    }
}
