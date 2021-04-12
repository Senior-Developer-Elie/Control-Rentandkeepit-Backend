<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductManagementController extends Controller
{
    /**
    * @var
    */
    protected $model;

    /**
     * CompanyManagementController constructor.
     *
     * @param \App\Models\Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index() 
    {
        $products = $this->model->with('product_meta')->where('post_type', 'product')->get();
        return response($products->toArray());
    }
}
