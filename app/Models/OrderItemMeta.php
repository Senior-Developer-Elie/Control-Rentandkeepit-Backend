<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Customer;

class OrderItemMeta extends Model
{
    use HasFactory;
    protected $table = '8sfz_woocommerce_order_itemmeta';
    public $primaryKey  = 'meta_id';

    public function order_item_metas()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'order_item_id');
    }
    
}
