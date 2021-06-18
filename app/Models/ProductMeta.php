<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductMeta extends Model
{
    use HasFactory;
    protected $table = '8sfz_wc_product_meta_lookup';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'ID');
    }

}
