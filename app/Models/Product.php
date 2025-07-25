<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function product_images() {
        return $this->hasMany(ProductGalleryImage::class)->limit(5);
    }
    public function product_ratings(){
        return $this->hasMany(ProductRating::class)->where('status',1);
    }
}
