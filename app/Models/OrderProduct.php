<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
use App\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = '8sfz_wc_order_product_lookup';
    public $primaryKey  = 'order_item_id';

    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id', 'ID');
    }
    
}
