<?php

namespace App\Models;

use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;
    
    protected $table = 'products';

    protected $with = ['images'];
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status',
    ];

    protected static function booted() {
        static::addGlobalScope(new AvailableScope);
    }

    public function carts(){
    return $this->morphedByMany(Cart::class, 'productable', 'productables', 'product_id', 'productable_id')
                ->withPivot('quantity')
                ->withTimestamps();
    }

    public function orders(){
        return $this->morphedByMany(Order::class, 'productable', 'productables', 'product_id', 'productable_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function scopeAvailable($query) {
        $query->where('status', 'available');
    }

    public function getTotalAttribute() {
        return $this->price * $this->pivot->quantity;
    }
}
