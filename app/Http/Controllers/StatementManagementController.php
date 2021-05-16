<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PaymentHistory;

use PDF;

class StatementManagementController extends Controller
{
    public function generatePDF($id)
    {
        date_default_timezone_set('Australia/Melbourne');
        $today = date('d/m/Y');
        
        $data['customerId'] = $id;
        $data['today'] = $today;

        $customer = Customer::find($id);
        $orderList = array();
        foreach ($customer->orders as $order) {
            if($order->status == 'wc-approved' || $order->status == 'wc-finalised') {
                $temp['id'] = $order->agreement->meta_key;
                $temp['start_date'] =  date("d/m/Y", strtotime($order->agreement->start_date));
                $temp['term_length'] = $order->agreement->term_length == 1 ? '12 months' : '24 months';
                $temp['status'] = $order->status == 'wc-approved' ? 'open' : 'finished';
                

                foreach ($order->post_meta as $post_meta) {
                    if($post_meta->meta_key == 'id_expiry_date') {
                        $temp['expiry_date'] =  date("d/m/Y", strtotime($post_meta->meta_value));
                        break;
                    }
                }

                $payments = PaymentHistory::where('order_id', $order->order_id)->where('is_contract', 0)->get();
                
                $temp['no_payment'] = count($payments);
                $temp['total_recived'] = 0;

                foreach($payments as $payment) {
                    $temp['total_recived'] += $payment->paid_amount;
                }

                $temp['total_outstanding'] = $order->agreement->rental_amount_total - $temp['total_recived'];

                $temp['product_name'] = '';
                foreach ($order->order_items as $order_item) {
                    $temp['product_name'] .= ($order_item->order_item_name . ', ');
                }
                array_push($orderList, $temp);
            }
        }
        
        $paymentList = array();
        $datesDividedHistory = PaymentHistory::where('customer_id', $id)->groupBy('date', 'is_contract')->orderBy('id')->get();
        $paymentHistories = PaymentHistory::where('customer_id', $id)->orderBy('date', 'DESC')->get();
        
        foreach ($datesDividedHistory as $dateHistory) {
            $total = 0;
            $temp['date'] = date("d/m/Y", strtotime($dateHistory->date));
            $temp['is_contract'] = $dateHistory->is_contract;
            foreach ($paymentHistories as $paymentHistory) {
                
                if($paymentHistory->date == $dateHistory->date && $paymentHistory->is_contract == $dateHistory->is_contract) {
                    $temp['paid_' . $paymentHistory->order->agreement->meta_key] = $paymentHistory->paid_amount;
                    $total += $paymentHistory->paid_amount;
                    //$temp['total _' . $paymentHistory->order->agreement->meta_key] = 0; 
                }
            }
            if($dateHistory->is_contract == 0)
                $temp['description'] = 'payment : $' . $total;
            else {
                $temp['description'] = 'contract started : ';
                foreach ($dateHistory->order->order_items as $order_item) {
                    $temp['description'] .= ($order_item->order_item_name . ', ');
                }
            }
            
            array_push($paymentList, $temp);
        }
        
        $data['paymentList'] = $paymentList;
        $data['orderList'] = $orderList;
        $data['orderLength'] = count($orderList);

        $pdf = PDF::loadView('statement', $data);
        return $pdf->download('statement.pdf');
    }
}