<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agreement;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    /**
    * @var
    */
    protected $model;

    /**
     * CompanyManagementController constructor.
     *
     * @param \App\Models\Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */

    public function index()
    {
        $orders =  $this->model->with('customer', 'order_items')->get();
        return response($orders->toArray());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'num_items_sold' => 'required',
            'total_sales' => 'required',
            'customer_id' => 'required',
        ]);

        date_default_timezone_set('Australia/Melbourne');
        $current_date = date('m/d/Y h:i:s a', time());

        $order_id = $this->model->max('order_id') + 1;
        
        $order_temp = [
            'order_id' =>  $order_id,
            'parent_id' => 0,
            'date_created' => $current_date,
            'date_created_gmt' => $request->start_date,
            'num_items_sold' => $request->num_items_sold,
            'total_sales' => $request->total_sales,
            'tax_total' => 0,
            'shipping_total' => 0,
            'net_total' => $request->total_sales,
            'returning_customer' => 1,
            'status' => 'wc-processing',
            'customer_id' => $request->customer_id,
        ];

        $order = $this->model->create($order_temp);

        return response(['status' => 'success']);
    }

    public function update(Request $request)
    {
        
    }


    public function saveAgreement(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'order_id' => 'required',
            'meta_key' => 'required',
        ]);

        $agreement = Agreement::where('customer_id', $request->customer_id)->
                                where('order_id', $request->order_id)->get()->first();

        if(!empty($agreement)) {
            $agreement->update($request->all());
        }
        else 
            Agreement::create($request->all());
        
        //Order::where('order_id', $request->order_id)->update(array('status' => 'wc-approved'));
        $order = DB::table('wp_wc_order_stats')
                    ->where('order_id', $request->order_id)
                    ->update(['status' => 'wc-approved']);

        return response(['status' => 'success']);
    }


    public function setOrderStatus(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required',
            'type' => 'required',
        ]);

        $status = "";

        switch ($request->type) {
            case 0:
                $status = 'wc-processing';
            break;
            
            case 1:
                $status = 'wc-approved';
            break;
            
            case 2:
                $status = 'wc-declined';
            break;
            
            case 3:
                $status = 'wc-finalised';
            break;
        }

        $order = DB::table('wp_wc_order_stats')
                    ->where('order_id', $request->order_id)
                    ->update(['status' => $status]);

        return response(['status' => 'success']);
    }
}
