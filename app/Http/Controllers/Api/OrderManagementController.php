<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Agreement;
use App\Models\PostMeta;

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
        $orders =  $this->model->with('customer', 'order_items', 'post_meta')->get();
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

            case 4:
                $status = 'wc-processing_1';
            break;

        }

        $order = DB::table('wp_wc_order_stats')
                    ->where('order_id', $request->order_id)
                    ->update(['status' => $status]);

        return response(['status' => 'success']);
    }

    public function updateMetaFirst(Request $request) 
    {
        $this->validate($request, [
            'order_id' => 'required',
            '_billing_first_name' => 'required',
            '_billing_last_name' => 'required',
            '_billing_email' => 'required',
            '_billing_address_1' => 'required',
            '_billing_state' => 'required', 
            '_billing_city' => 'required',
            '_billing_postcode' => 'required',
            '_billing_phone' => 'required',
        ]);

        $postMetas = PostMeta::where('post_id', $request->order_id)->get();


        foreach($postMetas as $postMeta) {
            $postMeta->timestamps = false;

            switch($postMeta->meta_key) {
                case '_billing_first_name':
                    $postMeta->meta_value = $request->_billing_first_name;
                    $postMeta->save();
                break;

                case '_billing_last_name':
                    $postMeta->meta_value = $request->_billing_last_name;
                    $postMeta->save();
                break;
                
                case '_billing_email':
                    $postMeta->meta_value = $request->_billing_email;
                    $postMeta->save();
                break;
                
                case '_billing_address_1':
                    $postMeta->meta_value = $request->_billing_address_1;
                    $postMeta->save();
                break;
                
                case '_billing_state':
                    $postMeta->meta_value = $request->_billing_state;
                    $postMeta->save();
                break;
                
                case '_billing_city':
                    $postMeta->meta_value = $request->_billing_city;
                    $postMeta->save();
                break;
                
                case '_billing_postcode':
                    $postMeta->meta_value = $request->_billing_postcode;
                    $postMeta->save();
                break;

                case '_billing_phone':
                    $postMeta->meta_value = $request->_billing_phone;
                    $postMeta->save();
                break;
            }    
        }
    }

    public function updateMetaSecond(Request $request) 
    {
        $this->validate($request, [
            'order_id' => 'required',
            'id_type' => 'required',
            'id_number' => 'required',
            'id_expiry_date' => 'required',
            'id_date_of_birth' => 'required',
            'id_existing_customer' => 'required',
        ]);

        $postMetas = PostMeta::where('post_id', $request->order_id)->get();

        foreach($postMetas as $postMeta) {

            $postMeta->timestamps = false;
            switch($postMeta->meta_key) {
                case 'id_type':
                    $postMeta->meta_value = $request->id_type;
                    $postMeta->save();
                break;

                case 'id_number':
                    $postMeta->meta_value = $request->id_number;
                    $postMeta->save();
                break;
                
                case 'id_expiry_date':
                    $postMeta->meta_value = $request->id_expiry_date;
                    $postMeta->save();
                break;
                
                case 'id_date_of_birth':
                    $postMeta->meta_value = $request->id_date_of_birth;
                    $postMeta->save();
                break;
                
                case 'id_existing_customer':
                    $postMeta->meta_value = $request->id_existing_customer;
                    $postMeta->save();
                break;
            }    
        }
    }

    public function updateMetaThird(Request $request) 
    {
        $this->validate($request, [
            'order_id' => 'required',
            'employment_status' => 'required',
            'employer_name' => 'required',
            'employer_phone' => 'required',
            'employer_time' => 'required',
            '_order_total' => 'required',
        
            'residential_status' => 'required',
            'residential_time' => 'required',
            'owner_mortgage' => 'required',

            'debt_list' => 'required',
            'debt_amount' => 'required',
            'debt_repayments' => 'required',
            'expenses_bills' => 'required',
            'expenses_household' => 'required',
        ]);

        $postMetas = PostMeta::where('post_id', $request->order_id)->get();

        foreach($postMetas as $postMeta) {
            
            $postMeta->timestamps = false;
            switch($postMeta->meta_key) {
                case 'employment_status':
                    $postMeta->meta_value = $request->employment_status;
                    $postMeta->save();
                break;

                case 'employer_name':
                    $postMeta->meta_value = $request->employer_name;
                    $postMeta->save();
                break;
                
                case 'employer_phone':
                    $postMeta->meta_value = $request->employer_phone;
                    $postMeta->save();
                break;

                case 'employer_time':
                    $postMeta->meta_value = $request->employer_time;
                    $postMeta->save();
                break;
                
                case '_order_total':
                    $postMeta->meta_value = $request->_order_total;
                    $postMeta->save();
                break;
                
                case 'residential_status':
                    $postMeta->meta_value = $request->residential_status;
                    $postMeta->save();
                break;

                case 'residential_time':
                    $postMeta->meta_value = $request->residential_time;
                    $postMeta->save();
                break;

                case 'owner_mortgage':
                    $postMeta->meta_value = $request->owner_mortgage;
                    $postMeta->save();
                break;
                
                case 'debt_list':
                    $postMeta->meta_value = $request->debt_list;
                    $postMeta->save();
                break;
                
                case 'debt_amount':
                    $postMeta->meta_value = $request->debt_amount;
                    $postMeta->save();
                break;
                
                case 'debt_repayments':
                    $postMeta->meta_value = $request->debt_repayments;
                    $postMeta->save();
                break;

                case 'expenses_bills':
                    $postMeta->meta_value = $request->expenses_bills;
                    $postMeta->save();
                break;

                case 'expenses_household':
                    $postMeta->meta_value = $request->expenses_household;
                    $postMeta->save();
                break;
            }    
        }
    }

    public function updateMetaForth(Request $request) 
    {
        $this->validate($request, [
            'order_id' => 'required',
            'referee_name' => 'required',
            'referee_address' => 'required',
            'referee_phone' => 'required',
            'referee_relationship' => 'required',
        ]);

        $postMetas = PostMeta::where('post_id', $request->order_id)->get();
            
        foreach($postMetas as $postMeta) {

            $postMeta->timestamps = false;
            switch($postMeta->meta_key) {
                case 'referee_name':
                    $postMeta->meta_value = $request->referee_name;
                    $postMeta->save();
                break;
                
                case 'referee_address':
                    $postMeta->meta_value = $request->referee_address;
                    $postMeta->save();
                break;
                
                case 'referee_phone':
                    $postMeta->meta_value = $request->referee_phone;
                    $postMeta->save();
                break;
                
                case 'referee_relationship':
                    $postMeta->meta_value = $request->referee_relationship;
                    $postMeta->save();
                break;
            }    
        }
    }
}
