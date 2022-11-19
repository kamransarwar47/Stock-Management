<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_stock'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
