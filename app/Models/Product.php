<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'title', 'description', 'price', 'quantity_in_stock', 'average_rating', 'reviews_count'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }
}
