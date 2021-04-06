<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

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


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

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
        $customer = $this->model->find($id);

        $this->validate($request, [
            'company_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $customer->update($request->all());

        $result = $this->model->find($customer->id)->toArray();
        return response($result);   
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
}
