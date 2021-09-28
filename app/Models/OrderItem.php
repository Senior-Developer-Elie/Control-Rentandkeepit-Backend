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
    public $primaryKey  = 'order_item_id';


    public function order_item_metas()
    {
        return $this->hasMany(OrderItemMeta::class, 'order_item_id', 'order_item_id');
    }

    public function order_item_product()
    {
        return $this->hasOne(OrderProduct::class, 'order_item_id', 'order_item_id')->with('product');
    }

    public function delete()
    {
        if($this->order_item_metas != null)
        foreach ($this->order_item_metas as $order_item_meta) {
            if($order_item_meta != null)
                $order_item_meta->delete();
        } 
            
        if($this->order_item_product != null)
            $this->order_item_product->delete();

        return parent::delete();

    }
}
