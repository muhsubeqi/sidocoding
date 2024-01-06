<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}