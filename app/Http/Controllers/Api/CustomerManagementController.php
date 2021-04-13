<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Agreement;

class CustomerManagementController extends Controller
{
    /**
    * @var
    */
    protected $model;

    /**
     * CompanyManagementController constructor.
     *
     * @param \App\Models\Customer $model
     */
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */

    public function index()
    {
        $customers =  $this->model->all();
        return response($customers->toArray());
    }

    public function show($id)
    {
        $customer = $this->model->find($id)->toArray();
        return response($customer);
    }

    public function getOrders($id) 
    {
        //$orders = Order::where('customer_id', $id)->get();
        //return response($orders[0]->order_items);

        $orders = $this->model->where('customer_id', $id)->first()->orders;

        $responseArray = array();
        foreach ($orders as $order) {
            $data = $order;
            $order_items = $order->order_items->toArray();

            array_push($responseArray, $data);
        }
        return response($responseArray);
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'company_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);*/

        $customer = $this->model->create($request->all());
        
        $result = $this->model->find($customer->id)->toArray();
        return response($result); 
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $customer = $this->model->where('customer_id', $id)->first();
       
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'city'    => 'required',
        ]);

        $customer->update($request->all());        
        return response(['state' => 'success']);   
    }

     /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $customer = $this->model->find($id);
        $customer->delete();

        return response([
            'message' => 'success',
        ]);
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
    }

    public function downLoad()
    {
        $headers = array(

            "Content-type"=>"text/html",
            "Content-Disposition"=>"attachment;Filename=myGeneratefile.doc"    
        );

        $content = '<html>
                        <head><meta charset="utf-8"></head>
                        <body>
                            <p>My Blog Laravel 7 generate word document from html Example - Nicesnippets.com</p>
                            <ul><li>Php</li><li>Laravel</li><li>Html</li></ul>
                        </body>
                    </html>';
    
        return \Response::make($content, 200, $headers);
    }

}
