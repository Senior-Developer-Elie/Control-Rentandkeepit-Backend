<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PostMeta;
use App\Models\Agreement;
use App\Models\Post;

class Order extends Model
{
    use HasFactory;
    protected $table = '8sfz_wc_order_stats';
    public $primaryKey  = 'order_id';

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

    public function agreement()
    {
        return $this->hasOne(Agreement::class, 'order_id', 'order_id');
    }

    public function post() 
    {
        return $this->belongsTo(Post::class, 'order_id', 'ID');
    }

    public function post_meta()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'order_id');
    }

    public function delete()
    {
        if($this->order_items != null)
            foreach ($this->order_items as $order_item) {
                if($order_item != null)
                $order_item->delete();
            }
            
        if($this->post != null)
            $this->post->delete();
        
        if($this->agreement != null)
            $this->agreement->delete();
        
        foreach ($this->post_meta as $meta)
            $meta->delete();
        
        return parent::delete();
    }
}
