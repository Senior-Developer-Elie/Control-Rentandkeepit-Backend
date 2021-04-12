<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductMeta;

class Product extends Model
{
    use HasFactory;

    protected $table = 'wp_posts';
    
    public function product_meta()
    {
        return $this->hasOne(ProductMeta::class, 'product_id', 'ID');
    }
}
