<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PostMeta;

class Order extends Model
{
    use HasFactory;
    protected $table = 'wp_wc_order_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'parent_id',
        'date_created',
        'date_created_gmt',
        'num_items_sold',
        'total_sales',
        'tax_total',
        'shipping_total',
        'net_total',
        'returning_customer',
        'status',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    public function order_items() 
    {
        return $this->hasMany(OrderItem::class,  'order_id', 'order_id')->with('order_item_product', 'order_item_metas');
    }

    public function post_meta()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'order_id');
    }
}
