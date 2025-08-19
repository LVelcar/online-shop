<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'car_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
