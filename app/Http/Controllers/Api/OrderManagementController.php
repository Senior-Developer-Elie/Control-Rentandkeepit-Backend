<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Agreement;
use App\Models\PostMeta;
use App\Models\PaymentHistory;

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
        $orders =  $this->model->with('customer', 'order_items', 'post_meta')->orderBy('order_id', 'DESC')->get();
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
            'term_length' => 'required',
            'start_date_day' => 'required',
            'start_date_year' => 'required',
            'start_date_month' => 'required',
            'start_date' => 'required',
            'instalment_amount' => 'required',
            'rental_amount_total' => 'required',
        ]);

        $agreement = Agreement::where('customer_id', $request->customer_id)->
                                where('order_id', $request->order_id)->get()->first();

        if(!empty($agreement)) {
            $agreement->update($request->all());
        }
        else {
            Agreement::create($request->all());
            
            date_default_timezone_set('Australia/Melbourne');
            $today = date('Y-m-d');

            $paymentHistory = [
                'date' => $today,
                'customer_id' => $request->customer_id,
                'order_id' => $request->order_id,
                'is_contract' => 1,
                
            ];

            PaymentHistory::create($paymentHistory);
        }   
            
        
        //Order::where('order_id', $request->order_id)->update(array('status' => 'wc-approved'));
        $order = DB::table('wp_wc_order_stats')
                    ->where('order_id', $request->order_id)
                    ->update(['status' => 'wc-processing_1']);

        return response(['status' => 'success']);
    }

    public function savePaymentHistory(Request $request) 
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'order_id' => 'required',
            'paid_amount' => 'required',         
            'refund' => 'required',
            'date' => 'required',              
            'payment_method' => 'required',      
        ]);

        //date_default_timezone_set('Australia/Melbourne');
        //$today = date('Y-m-d');
        //$request['date'] = $today;
        
        $request['is_contract'] = 0;
        PaymentHistory::create($request->all());
        
        return response(['status' => 'success']);
    }

    public function saveProfitAndRevenue(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'order_id' => 'required',
            'rental_amount_total' => 'required',
            'profit_total' => 'required',
            'profit_per_week' => 'required',
            'profit_per_fortnight' => 'required',
            'profit_per_month' => 'required',
            'revenue_per_month' => 'required',
        ]);
        
        $agreement = Agreement::where('customer_id', $request->customer_id)->
                                where('order_id', $request->order_id)->get()->first();
        $request['finalised'] = 1;
        $agreement->update($request->all());

        return response(['status' => 'success']);
    }

    public function getYearsForReport()
    {
        $years =  DB::select("SELECT start_date_year AS `year` FROM agreements GROUP BY start_date_year");
        return response($years);
    }

    public function getRevenueForReport()
    {
        $years =  DB::select("SELECT start_date_year AS `year` FROM agreements GROUP BY start_date_year");

        $reports = DB::select("SELECT start_date_year AS `year`, start_date_month AS `month`, SUM(rental_amount_total) AS total_revenue, SUM(profit_total) AS total_profit FROM agreements
                              GROUP BY start_date_year, start_date_month");
        
        $dataSets = array();
        foreach ($years as $year) {
            $dataSets['revenue'][strval($year->year)][0]['data'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $dataSets['revenue'][$year->year][0]['lable'] = 'Revenue';
            $dataSets['revenue'][$year->year][0]['fill'] = 'start';

            $dataSets['profit'][strval($year->year)][0]['data'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $dataSets['profit'][$year->year][0]['lable'] = 'Profit';
            $dataSets['profit'][$year->year][0]['fill'] = 'start';
            
            foreach ($reports as $report) {
                if($report->year === $year->year) {
                    $dataSets['revenue'][$year->year][0]['data'][$report->month - 1] = $report->total_revenue / 500;
                    $dataSets['profit'][$year->year][0]['data'][$report->month - 1] = $report->total_profit / 500;
                }
            }
        }
        date_default_timezone_set('Australia/Melbourne');
        $date = date('Y-m-d');
        
        ///////////
        $nextDate30_date = date_create($date);
        date_add($nextDate30_date, date_interval_create_from_date_string("30 days"));
        $nextDate30 = $nextDate30_date->format('Y-m-d');

        $next30RevenueAndProfit = DB::select("SELECT SUM(rental_amount_total) as total_revenue, SUM(profit_total) as total_profit FROM agreements
                                              WHERE start_date BETWEEN '". $date . "' AND '" . $nextDate30 . "'
                                              GROUP BY start_date_year");  
        if(count($next30RevenueAndProfit))
            $dataSets['next30'] = [$next30RevenueAndProfit[0]];
        else
            $dataSets['next30'][0] = [
                'total_revenue' => 0,
                'total_profit' => 0,
            ];
        
        ////////
        $nextDate60_date = date_create($date);
        date_add($nextDate60_date, date_interval_create_from_date_string("60 days"));
        $nextDate60 = $nextDate60_date->format('Y-m-d');

        $next60RevenueAndProfit = DB::select("SELECT SUM(rental_amount_total) as total_revenue, SUM(profit_total) as total_profit FROM agreements
                                              WHERE start_date BETWEEN '". $date . "' AND '" . $nextDate60 . "'
                                              GROUP BY start_date_year");
        
        if(count($next60RevenueAndProfit))
            $dataSets['next60'] = [$next60RevenueAndProfit[0]];
        else   
            $dataSets['next60'][0] = [
                'total_revenue' => 0,
                'total_profit' => 0,
            ];

        $nextDate90_date = date_create($date);
        date_add($nextDate90_date, date_interval_create_from_date_string("90 days"));
        $nextDate90 = $nextDate90_date->format('Y-m-d');

        $next90RevenueAndProfit = DB::select("SELECT SUM(rental_amount_total) as total_revenue, SUM(profit_total) as total_profit FROM agreements
                                              WHERE start_date BETWEEN '". $date . "' AND '" . $nextDate90 . "'
                                              GROUP BY start_date_year");
        if(count($next90RevenueAndProfit))
            $dataSets['next90'] = [$next90RevenueAndProfit[0]];
        else
            $dataSets['next90'][0] = [
                'total_revenue' => 0,
                'total_profit' => 0,
            ];
        
        $totalOutStanding = DB::select("SELECT SUM(paid_amount) AS total_amount FROM payment_histories 
                                        LEFT JOIN wp_wc_order_stats ON payment_histories.order_id = wp_wc_order_stats.order_id
                                        WHERE payment_histories.is_contract = '0' AND wp_wc_order_stats.status = 'wc-active' ");
        
        $dataSets['total_outstanding'] = [$totalOutStanding[0]];

        return response($dataSets);
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
                $status = 'wc-processing_1';
            break;
            
            case 2:
                $status = 'wc-declined';
            break;
            
            case 3:
                $status = 'wc-active';
            break;

            case 4:
                $status = 'wc-finished';
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
