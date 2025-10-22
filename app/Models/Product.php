<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = []; 

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function brand() {
        return $this->belongsTo(Category::class);
    }

    public function productItems() {
        return $this->hasMany(OrderItem::class);
    }

    protected $casts = [
        'images' => 'array'
    ];
}
