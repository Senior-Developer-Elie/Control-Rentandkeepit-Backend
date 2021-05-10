<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'wp_wc_customer_lookup';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'data_last_active',
        'data_registered',
        'postcode',
        'address',
        'country',
        'city',
        'state',
    ];
    
    public $primaryKey  = 'customer_id';
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id')->with('order_items');
    }
}
