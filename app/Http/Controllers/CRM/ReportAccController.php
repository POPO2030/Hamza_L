<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\CRM\Customer;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Place;
use App\Models\CRM\Stage;



class ReportAccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::select('name','id')->get();
        $places = Place::select('name','id')->get();
        $stages = Stage::select('name','id')->get();
        $work_orders = WorkOrder::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->get();
        $services = ServiceItem::select('name','id')->get();

        return view('acc_crm_views.acc_reports')->with([
            'customers'=>$customers,
            'places'=>$places,
            'stages'=>$stages,
            'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'services'=>$services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function work_order_report(Request $request)
    {
            $result=WorkOrder::
            with([
                'get_customer:name,id',
                'get_products:name,id',
                'get_work_order_stage.get_service_item',
                'get_places:name,id',
                'get_ReceiveReceipt:id,id',
                'get_activity.get_owner'
            ]);
            if($request->workorder_id !=='all'){
                $result=$result->where('id',$request->workorder_id);
            }
            if($request->customer_id !=='all'){
                $result=$result->where('customer_id',$request->customer_id);
            }
            if($request->recepit_id !=='all'){
                $result=$result->where('receive_receipt_id',$request->recepit_id);
            }
            if($request->place_id !=='all'){
                $result=$result->where('place_id',$request->place_id);
            }
            if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }
            if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }
            
            $result=$result->where('status',$request->status)->get();

            if($request->stage_id !=='all'){
                $final_stage=[];
                for ($i=0; $i < count($result); $i++) { 
                    for ($x=0; $x < count($result[$i]->get_activity); $x++) { 
                        if($result[$i]->get_activity[$x]->get_owner->id == $request->stage_id && $result[$i]->get_activity[$x]->status == 'open'){
                            array_push($final_stage , $result[$i]);
                        }
                    }
                }
                $result=$final_stage;
            }

            if($request->service_id !=='all'){
                $final_service=[];
                for ($i=0; $i < count($result); $i++) { 
                    for ($x=0; $x < count($result[$i]->get_work_order_stage); $x++){
                        if($result[$i]->get_work_order_stage[$x]->get_service_item->id == $request->service_id){
                            if(in_array($result[$i],$final_service)){
                                continue;
                                };
                                array_push($final_service , $result[$i]);
                            
                        }
                    }
                }
                $result=$final_service;
            }

        return view('acc_crm_views.acc_reports_result')->with(['result'=>$result]); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
