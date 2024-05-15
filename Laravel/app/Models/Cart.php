<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Cart extends Model
{
    use HasFactory;
    protected $table='cart';
    protected $fillable = [
       'id',
       'user_id',
       'product_id',
        'quantity',
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
