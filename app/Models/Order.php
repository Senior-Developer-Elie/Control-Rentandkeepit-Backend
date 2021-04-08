<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;
    protected $table = 'wp_wc_order_stats';

    public function order_items() 
    {
        return $this->hasMany(OrderItem::class,  'order_id', 'order_id')->with('order_item_product', 'order_item_metas');
    }


}
