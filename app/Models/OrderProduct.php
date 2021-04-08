<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
use App\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'wp_wc_order_product_lookup';
    
    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id', 'ID');
    }
    
}
