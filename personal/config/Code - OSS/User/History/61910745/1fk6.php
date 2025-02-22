<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['status'];

    protected $casts = [

        'content' => 'array',
        'address' => 'array',
        'status' => OrderStatus::class
    ];

    //Relacion de uno a muchos inversa
    public function Department()
    {
        return $this->belongsTo(Department::class);
    }
    public function District()
    {
        return $this->belongsTo(District::class);
    }
    public function City()
    {
        return $this->belongsTo(City::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Shipment()
    {
        return $this->hasMany(Shipment::class);
    }
}
