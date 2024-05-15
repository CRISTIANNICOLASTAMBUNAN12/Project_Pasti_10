<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'stock',
        'description',
        'price',
        'weight_unit',
        'category_id',
        'image'
    ];
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    
}
