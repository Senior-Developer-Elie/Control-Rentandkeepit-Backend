<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class PostMeta extends Model
{
    use HasFactory;

    protected $table = 'wp_postmeta';
    public $primaryKey  = 'meta_id';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'post_id');
    }

}
