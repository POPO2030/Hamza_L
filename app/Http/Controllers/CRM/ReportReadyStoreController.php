<?php

namespace App\Http\Controllers\CRM;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CRM\Customer;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\Deliver_order_details;

class ReportReadyStoreController extends Controller
{
    public function index()
    {
       
        $customers = Customer::select('name','id')->get();
        $work_orders = WorkOrder::select('id')->get();
        $deliver_orders = Deliver_order::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->get();
       

        return view('ready_store_crm_views.ready_store_reports')->with([
            'customers'=>$customers,
            'work_orders'=>$work_orders,
            'deliver_orders'=>$deliver_orders,
            'recepits'=>$recepits,
           
        ]);
    }


    public function ready_store_report(Request $request)
    {
                
      
            $workOrder = WorkOrder::find($request->work_order_id);   //done
            $deliver_order = Deliver_order::find($request->deliver_order_id);    // done
            // $deliver_order_ids = Deliver_order::where('work_order_id',$workOrder->id);
            // $totalDelivered = Deliver_order_details::whereIn('deliver_order_id', $deliver_order_ids)->sum('total');

            // $remaining = $product_count[0] - $totalDelivered;    
// return $deliver_order_ids;

            $result=Deliver_order::
            with([
                'get_customer:name,id',
                'get_products:name,id',
                'get_receivable:name,id',
                'get_details',
                'get_count_product:product_count,id',
              

                
            ]);
            if($request->work_order_id !=='all'){
                $result=$result->where('id',$request->work_order_id);
            }
            if($request->customer_id !=='all'){
                $result=$result->where('customer_id',$request->customer_id);
            }
            if($request->deliver_order_id !=='all'){
                $result=$result->where('deliver_order_id',$request->deliver_order_id);
            }
            if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }
            if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }
            
            $result=$result->where('status',$request->status)->get();


       
        // return $totalDelivered;

        return view('ready_store_crm_views.ready_store_reports_result')->with(['result'=>$result ]); 

    }
}
