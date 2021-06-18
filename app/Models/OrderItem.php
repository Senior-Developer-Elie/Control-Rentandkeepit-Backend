<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItemMeta;
use App\Models\OrderProduct;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = '8sfz_woocommerce_order_items';

    public function order_item_metas()
    {
        return $this->hasMany(OrderItemMeta::class, 'order_item_id', 'order_item_id');
    }

    public function order_item_product()
    {
        return $this->hasOne(OrderProduct::class, 'order_item_id', 'order_item_id')->with('product');
    }
}
