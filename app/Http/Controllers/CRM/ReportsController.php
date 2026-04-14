<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\CRM\Customer;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\Place;
use App\Models\CRM\Stage;
use App\Models\CRM\satge_category;
use App\Models\CRM\Receivable;
use App\Models\CRM\Activity;
use App\Models\CRM\Product;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\Deliver_order_details;
use App\Models\CRM\FinalDeliver;
use App\Models\User;
use Spatie\Activitylog\Models\Activity as ActivityLog;
use DB;

class ReportsController extends Controller
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
        $receivables = Receivable::select('name','id')->get();

        return view('crm_views.reports')->with([
            'customers'=>$customers,
            'places'=>$places,
            'stages'=>$stages,
            'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'services'=>$services,
            'receivables'=>$receivables,

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
                'get_ReceiveReceipt',
                'get_activity.get_owner',
                'get_receivables:name,id'

                
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
            if($request->receivable_id !=='all'){
                $result=$result->where('receivable_id',$request->receivable_id);
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

            if($request->service_id && in_array('all', $request->service_id)){
                $final_service = $result;
            } else {
                $final_service = [];
                foreach ($result as $item) {
                    foreach ($item->get_work_order_stage as $stage) {
                        if (in_array($stage->get_service_item->id, $request->service_id)) {
                            if (!in_array($item, $final_service)) {
                                $final_service[] = $item;
                            }
                            break;
                        }
                    }
                }
            }


            if($request->is_production !=='all'){
                $production_status = $request->is_production;

                $row_count =0;
                $product_sum =0;
                foreach($result as $item){
                    if($production_status == 'true'){
                        if($item->is_production==0){
                            continue;  
                        }
                            $row_count ++ ;
                            $product_sum+= $item->product_count;
                    }else{
                        if($item->is_production==1 || $item->product_count==0 ){
                            continue;
                        }
                        $row_count ++ ;
                        $product_sum+= $item->product_count;
                    }
                }
               $important=WorkOrder::where('priority',1)->count();
               return view('crm_views.reports_result')->with(['result'=>$result , 'production_status'=>$production_status,'important'=>$important , 'row_count'=>$row_count , 'product_sum'=>$product_sum]); 
            }
            
            $result = $final_service;
            $important=WorkOrder::where('priority',1)->count();

            $row_count =0;
            $product_sum =0;

            foreach($result as $item){
                $row_count ++ ;
                $product_sum+= $item->product_count;
            }
            //  return $result;
       

        return view('crm_views.reports_result')->with(['result'=>$result ,'important'=>$important , 'row_count'=>$row_count , 'product_sum'=>$product_sum ]); 

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
public function readyreports_view(){
    $customers = Customer::select('name','id')->get();
    $work_orders = WorkOrder::select('id')->get();
    // $deliver_orders = Deliver_order::select('id')->get();
    $final_deliver_orders = FinalDeliver::select('final_deliver_order_id')->distinct()->get();

    $recepits = ReceiveReceipt::select('id')->get();
    $receivables = Receivable::select('name','id')->get();

    return view('crm_views.ready_store_reports')->with([
        'customers'=>$customers,
        'work_orders'=>$work_orders,
        'final_deliver_orders'=>$final_deliver_orders,
        'recepits'=>$recepits,
        'receivables'=>$receivables,
       
    ]);
}



public function readyreports_result(Request $request){
//   return $request;

    
    $receive_ids = Deliver_order::where('customer_id', $request->customer_id)->where('status', 'open')
    // ->whereNotIn('id', function ($query) {
    //     $query->select('deliver_order_id')
    //         ->from('final_deliver_details');
    // })
    ->pluck('receive_id')->toArray();

        $receive_name = Receivable::whereIn('id', $receive_ids)->pluck('name', 'id');    

// return $receive_name;

    $result = Deliver_order::
    with(['get_customer:name,id','get_products:name,id','get_receivable:name,id','get_final_deliver','get_details','get_count_product','get_receive_receipt'])
    ->where('status',$request->status);
    if($request->workorder_id !=='all'){
        $result=$result->where('work_order_id',$request->workorder_id);
    }
    if($request->customer_id !=='all'){
        $result=$result->where('customer_id',$request->customer_id);
    }
    if($request->recepit_id !=='all'){
        $result=$result->where('receipt_id',$request->recepit_id);
    }
    if($request->receivable_id !=='all'){
        $result=$result->where('receive_id',$request->receivable_id);
    }
    if($request->final_deliver_order_id !=='all'){
        $final_deliver_id=FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id)->select('deliver_order_id')->first();
        if($final_deliver_id){
            $result=$result->where('id',$final_deliver_id->deliver_order_id);
        }
    }

    if (isset($request->from)) {
    $result=$result->where('created_at','>=',$request->from);
    }
    if (isset($request->to)) {
    $result=$result->where('created_at','<=',$request->to.' 23:59:59');
    }
    
    $result=$result->get();
    // return $result;
    $ids=[];
    $final_result=[];
    for ($i=0; $i<count($result) ; $i++) { 
        if($i==0){
            array_push($ids , $result[$i]->work_order_id);
            array_push($final_result , $result[$i]);
            continue;
        }
        if(in_array($result[$i]->work_order_id , $ids)){
            for ($x=0; $x <count($final_result) ; $x++) { 

                if($final_result[$x]->work_order_id == $result[$i]->work_order_id){

                    for ($z=0; $z <count($result[$i]->get_details) ; $z++) { 
                        $index= count($final_result[$x]->get_details);
                        $final_result[$x]->get_details[$index++] = $result[$i]->get_details[$z];
                    }

                    for ($a=0; $a <count($result[$i]->get_final_deliver) ; $a++) { 
                        $ind= count($final_result[$x]->get_final_deliver);
                        $final_result[$x]->get_final_deliver[$ind++] = $result[$i]->get_final_deliver[$a];
                    }
                }
            }
        }else{
            array_push($ids , $result[$i]->work_order_id);
            array_push($final_result , $result[$i]);
        }
    }

    // $row_count=0 ;
    // foreach($result as $item){
    //     $row_count ++ ;

    //     $total_package=0 ;
    //     foreach ($item->get_details as $count){
    //         $total_package += $count->total;
    //     }
    //         $total_ready=0 ;
    //     foreach ($item->get_final_deliver as $count){
    //          $total_ready += $count->total;
    //     } 
    // }
  


//  return $final_result;
    return view('crm_views.ready_store_reports_result')->with([
        'receive_name'=>$receive_name,
        'result'=>$final_result,
        'residual'=>$request->residual,
    ]);
}


public function reports_stages()
    {
        $customers = Customer::select('name','id')->get();
        // $places = Place::select('name','id')->get();
        $stage_category = satge_category::select('name','id')->get();
        // $work_orders = WorkOrder::where('status','open')->select('id')->get();
        // $recepits = ReceiveReceipt::where('status','open')->select('id')->get();
        // $services = ServiceItem::select('name','id')->get();
        $receivables = Receivable::select('name','id')->get();

        return view('crm_views.reports_stages')->with([
            'customers'=>$customers,
            // 'places'=>$places,
            'stage_category'=>$stage_category,
            // 'work_orders'=>$work_orders,
            // 'recepits'=>$recepits,
            // 'services'=>$services,
            'receivables'=>$receivables,

        ]);
    }


    public function reports_stages_result(Request $request)
    {
        // return $request;

            $stage_id=Stage::where('stage_category_id',$request->stage_id)->pluck('id');
            $service_item_stage = ServiceItemSatge::whereIn('satge_id',$stage_id)->pluck('id')->toArray();
            $work_order_ids = Work_order_stage::whereIn('service_item_satge_id',$service_item_stage)->where('status','open')->pluck('work_order_id')->toArray();

            $result=WorkOrder::
            with([
                'get_customer:name,id',
                'get_products:name,id',
                // 'get_stage_open.get_work_order_service:id,name,price',//
                'get_stage_open.get_sevice_item_stage.get_service_item:id,name,price',
                // 'get_stage_open.get_work_order_stage.get_category:name,id',
                'get_places:name,id',
                'get_ReceiveReceipt',
                'get_activity.get_owner',
                'get_receivables:name,id'
            ]);


            // if($request->workorder_id !=='all'){
            //     $result=$result->where('id',$request->workorder_id);
            // }
            if($request->customer_id !=='all'){
                $result=$result->where('customer_id',$request->customer_id);
            }
            // if($request->recepit_id !=='all'){
            //     $result=$result->where('receive_receipt_id',$request->recepit_id);
            // }

            if($request->receivable_id !=='all'){
                $result=$result->where('receivable_id',$request->receivable_id);
            }
            if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }
            if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }
            
            $result=$result->whereIn('id',$work_order_ids)->where('status','open')->get();

// -----------------------------------------
            $row_count =0;
            $product_sum =0;

            foreach($result as $item){
                $row_count ++ ;
                $product_sum+= $item->product_count;
            }
// -----------------------------------------------
// return $result;
       
        return view('crm_views.reports_stages_result')->with(['result'=>$result, 'row_count'=>$row_count, 'product_sum'=>$product_sum ]); 

    }

    public function receive_receipt_open(){
        $customers = Customer::select('name','id')->get();
        $work_orders = WorkOrder::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->where('status','open')->get();
        $receivables = Receivable::select('name','id')->get();
    
        return view('crm_views.receive_receipt_open')->with([
            'customers'=>$customers,
            'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'receivables'=>$receivables,
           
        ]);
    }

    public function receive_receipt_open_result(Request $request)
    {
        // return $request;

            $result=ReceiveReceipt::
            with([
                'get_work_order.get_stage.get_sevice_item_stage.get_service_item:id,name,price',
                'get_customer:name,id',
                'get_product:name,id',
                'get_receivables:name,id',
                'get_work_order.get_open_activity.get_owner',
                'get_work_order.get_closed_activity.get_owner'
                
            ]);


           
            if($request->customer_id !=='all'){
                $result=$result->where('customer_id',$request->customer_id);
            }
            if($request->recepit_id !=='all'){
                $result=$result->where('id',$request->recepit_id);
            }

            if($request->receivable_id !=='all'){
                $result=$result->where('receivable_id',$request->receivable_id);
            }
            if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }
            if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }
            
            $result=$result->where('status','open')->get();
// ------------------------
            $row_count =0;
            $product_sum =0;

            foreach($result as $item){
                foreach ($item->get_work_order as $work_order){
                $row_count ++ ;
                $product_sum+= $work_order->product_count;
                }
            }
// ---------------------------
// return $result;
        return view('crm_views.receive_receipt_open_result')->with(['result'=>$result, 'row_count'=>$row_count, 'product_sum'=>$product_sum ]); 

    }

    public function models_report(){
        // $customers = Customer::select('name','id')->get();
        // $work_orders = WorkOrder::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->get();
        $models = ReceiveReceipt::whereNotNULL('model')->select('model')->distinct()->get();
        // $receivables = Receivable::select('name','id')->get();
    
        return view('crm_views.models_report')->with([
            // 'customers'=>$customers,
            // 'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'models'=>$models,
            // 'receivables'=>$receivables,
           
        ]);
    }

    public function models_report_result(Request $request){
        
//   return $request;

        $result=WorkOrder::
                    with([
                        'get_customer:name,id',
                        'get_products:name,id',
                        'get_stage_open.get_sevice_item_stage.get_service_item:id,name,price',
                        // 'get_stage_open.get_work_order_stage.get_category:name,id',
                        'get_places:name,id',
                        'get_ReceiveReceipt',
                        'get_open_activity.get_owner',
                        'get_receivables:name,id',
                        'get_deliver_order.get_details',
                        'get_deliver_order.get_final_deliver',
                    ]);


        if($request->customer_id !=='all'){
            $result=$result->where('customer_id',$request->customer_id);
        }
        if($request->recepit_id !=='all'){
            $result=$result->where('receive_receipt_id',$request->recepit_id);
        }

        if($request->model !=='all'){
            $recepit_ids=ReceiveReceipt::where('model',$request->model)->pluck('id')->toArray();
            $result=$result->whereIn('receive_receipt_id',$recepit_ids);
        }
        
        // if($request->receivable_id !=='all'){
        //     $result=$result->where('receivable_id',$request->receivable_id);
        // }
        // if (isset($request->from)) {
        //     $result=$result->where('created_at','>=',$request->from);
        // }
        // if (isset($request->to)) {
        //     $result=$result->where('created_at','<=',$request->to.' 23:59:59');
        // }            

        $result=$result->get();

        // ------------------------
        $row_count =0;
        $product_sum =0;

        foreach($result as $item){
            $row_count ++ ;
            $product_sum+= $item->product_count;
            
        }
        // ---------------------------


// return $result;
        return view('crm_views.models_report_result')->with([
            'result'=>$result,
            'row_count'=>$row_count,
            'product_sum'=>$product_sum
        ]);
    }


    public function residual(){
        $customers = Customer::select('name','id')->get();
        $work_orders = WorkOrder::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->get();
        $receivables = Receivable::select('name','id')->get();
        $models = ReceiveReceipt::whereNotNULL('model')->select('model')->distinct()->get();

        return view('crm_views.residual')->with([
            'customers'=>$customers,
            'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'models'=>$models,
            'receivables'=>$receivables,
           
        ]);
    }

    public function residual_result(Request $request)
    {

        // return $request;

            $result=ReceiveReceipt::
            with([
                'get_work_orders_for_deliver_for_details',
                'get_customer:name,id',
                'get_product:name,id',
                'get_receivables:name,id',
                
            ]);


           
            if($request->customer_id !=='all'){
                $result=$result->where('customer_id',$request->customer_id);
            }
            if($request->recepit_id !=='all'){
                $result=$result->where('id',$request->recepit_id);
            }

            if($request->model !=='all'){
                $recepit_ids=ReceiveReceipt::where('model',$request->model)->pluck('id')->toArray();
                $result=$result->whereIn('id',$recepit_ids);
            }

            if($request->receivable_id !=='all'){
                $result=$result->where('receivable_id',$request->receivable_id);
            }
            if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }
            if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }
            
            $result=$result->select('id','model','final_weight','final_count','product_id','product_type','customer_id','receivable_id','created_at')->get();

            //  return $result;
    // ------------------------
    // if(count($result)>0){
        $row_count = 0;
        $resudial_sum = 0;

       foreach ($result as $item) {

            $total_qty_sum=0;
            foreach ($item->get_work_orders_for_deliver_for_details as $work_orders){
                if(isset($work_orders->total_sum)){
                    $total_qty_sum+=$work_orders->total_sum;
                }
            }
            $resudial_sum+=$item->final_count - $total_qty_sum;
            $row_count++;
        }


    //     return view('crm_views.residual_result')->with(['result'=>$result, 'row_count'=>$row_count, 'total_qty_sum'=>$total_qty_sum,'resudial'=>$resudial , 'resudial_sum'=>$resudial_sum ]); 
    // }else{
        return view('crm_views.residual_result')->with(['result'=>$result,'row_count'=>$row_count ,'resudial_sum'=>$resudial_sum]); 
    
    
    // ---------------------------
// return $result;

    }



    public function dashboard_report(){

    // ---------------------------------------------------------------------------------------------------------
        $currentDate = Carbon::now();
        $monthsInFuture = 12; // Change this to the number of months you want to include
        $monthsYears = [];

        for ($i = 0; $i < $monthsInFuture; $i++) {
            $date = $currentDate->copy()->subMonths($i);
            $monthsYears[$date->format('M-Y')] = $date->translatedFormat('F Y');
        }
    // ---------------------------------------------------------------------------------------------------------
      


    return view('crm_views.dashboard_report')->with(['monthsYears'=>$monthsYears,]); 

    }


    public function dashboard_report_result (Request $request){
        // return $request;
        ini_set('max_execution_time', 1800);
        ini_set('memory_limit', '1024M');

        $parsedDate = Carbon::createFromFormat('M-Y', $request->from_month_year);

        $startOfMonth = $parsedDate->copy()->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Format the dates
        $firstDayofMonth = $startOfMonth->format('Y-m-d');
        $lastDayofMonth = $endOfMonth->format('Y-m-d');

        $products_return= Product::whereIn('id',[5,12,19,26,33,40,47,54,61,68,75,82,89,96,103,110,117,124,131,138,145,152,156,162,189])->pluck('id');      //المنتجات المرتجعة
        // ===================================================================================================
        
        $work_order_ids = Activity::where('owner_stage_id', 48)->where('status', 'closed')->whereBetween('updated_at', [$firstDayofMonth, $lastDayofMonth])->pluck('work_order_id')->toArray();
        sort($work_order_ids);

        $filteredWorkOrders = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_ids)->pluck('id')->toArray();

        $created = Activity::whereIn('work_order_id',$filteredWorkOrders)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packings = Deliver_order::whereIn('work_order_id',$filteredWorkOrders)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();


        $count_hours = [];

        foreach ($packings as $packing) {
            // Find the corresponding item in $created based on work_order_id
            $create = $created->firstWhere('work_order_id', $packing->work_order_id);

            if ($create) {
                $difference = $packing->created_at->diff($create->updated_at);
                $difference_hours = $difference->days * 24 + $difference->h;
                $difference_minutes = $difference->i;
                // Store the difference hours and minutes with respect to work_order_id
                if($difference_hours >= 1){
                    $count_hours[$packing->work_order_id][] = ['hours' => $difference_hours, 'minutes' => $difference_minutes];
                }
            }
        }

        $slower = null;
        $faster = null;
        $maxDifference = 0;
        $minDifference = PHP_INT_MAX;

        foreach ($count_hours as $work_order_id => $differences) {
            foreach ($differences as $difference) {
                $totalDifference = $difference['hours'] * 60 + $difference['minutes'];
                if ($totalDifference > $maxDifference) {
                    $maxDifference = $totalDifference;
                    $slower = [
                        'work_order_id' => $work_order_id,
                        'days' => floor($totalDifference / (24 * 60)),
                        'hours' => floor(($totalDifference % (24 * 60)) / 60),
                        'minutes' => $totalDifference % 60,
                    ];
                }

                if ($totalDifference < $minDifference) {
                    $minDifference = $totalDifference;
                    $faster = [
                        'work_order_id' => $work_order_id,
                        'days' => floor($totalDifference / (24 * 60)),
                        'hours' => floor(($totalDifference % (24 * 60)) / 60),
                        'minutes' => $totalDifference % 60,
                    ];
                }
            }
        }

        
    // ==========================================================================
        $fashion = Activity::where('owner_stage_id', 48)
        ->where('status', 'closed')
        ->with([
            'get_work_order.get_work_order_stage.get_service_item' => function ($query) {
                $query->select('id', 'name', 'price');
                // ->where('price','>',0);
            }
        ])
        ->select('id', 'work_order_id', 'owner_stage_id')
        ->whereBetween('updated_at', [$firstDayofMonth, $lastDayofMonth])                    //filter to get data about month
        ->get();
// return $fashion;
        $totalPrice = $fashion->sum(function ($activity) {
        return $activity->get_work_order?->get_work_order_stage
            ? $activity->get_work_order->get_work_order_stage->sum(function ($stage) {
                return $stage->get_service_item ? $stage->get_service_item->price : 0;
            })
            : 0; // If get_work_order_stage is null, return 0.
        });

        // Add total price to each activity
        $fashion->transform(function ($activity) {
            $totalPrice = optional($activity->get_work_order)->get_work_order_stage
                ? $activity->get_work_order->get_work_order_stage->sum(function ($stage) {
                    return optional($stage->get_service_item)->price ?? 0;
                })
                : 0;
        
            $activity->total_price = $totalPrice;
            return $activity;
        });

        // $totalOfTotalPrice = $fashion->sum('total_price');
        $work_order_totalPrices = $fashion->map(function ($activity) {
            $totalPrice = optional($activity->get_work_order)->get_work_order_stage
                ? $activity->get_work_order->get_work_order_stage->sum(function ($stage) {
                    return optional($stage->get_service_item)->price ?? 0;
                })
                : 0;
        
            return [
                'work_order_id' => $activity->work_order_id,
                'total_price' => $totalPrice,
            ];
        });

        $work_order_fashion_1_3 =$work_order_totalPrices->whereBetween('total_price', [1, 3])->pluck('work_order_id')->toArray();
        $work_orders_1_3 = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_fashion_1_3)->pluck('id')->toArray();
        $work_orders_return_1_3 = WorkOrder::whereIn('product_id', $products_return)->whereIn('id', $work_order_fashion_1_3)->pluck('id')->toArray();

        $work_order_fashion_4_6 =$work_order_totalPrices->whereBetween('total_price', [4, 6])->pluck('work_order_id')->toArray();
        $work_orders_4_6 = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_fashion_4_6)->pluck('id')->toArray();
        $work_orders_return_4_6 = WorkOrder::whereIn('product_id', $products_return)->whereIn('id', $work_order_fashion_4_6)->pluck('id')->toArray();

        $work_order_fashion_6_10 =$work_order_totalPrices->where('total_price', '>', 6)->whereBetween('total_price', [6, 10])->pluck('work_order_id')->toArray();
        $work_orders_6_10 = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_fashion_6_10)->pluck('id')->toArray();
        $work_orders_return_6_10 = WorkOrder::whereIn('product_id', $products_return)->whereIn('id', $work_order_fashion_6_10)->pluck('id')->toArray();

        $work_order_fashion_10_15 =$work_order_totalPrices->where('total_price', '>', 10)->whereBetween('total_price', [10, 15])->pluck('work_order_id')->toArray();
        $work_orders_10_15 = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_fashion_10_15)->pluck('id')->toArray();
        $work_orders_return_10_15 = WorkOrder::whereIn('product_id', $products_return)->whereIn('id', $work_order_fashion_10_15)->pluck('id')->toArray();

        $work_order_fashion_15_00 =$work_order_totalPrices->where('total_price', '>', 15)->pluck('work_order_id')->toArray();
        $work_orders_15_00 = WorkOrder::whereNotIn('product_id', $products_return)->whereIn('id', $work_order_fashion_15_00)->pluck('id')->toArray();
        $work_orders_return_15_00 = WorkOrder::whereIn('product_id', $products_return)->whereIn('id', $work_order_fashion_15_00)->pluck('id')->toArray();

        
        $created_1_3 = Activity::whereIn('work_order_id',$work_orders_1_3)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_1_3 = Deliver_order::whereIn('work_order_id',$work_orders_1_3)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_4_6 = Activity::whereIn('work_order_id',$work_orders_4_6)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_4_6 = Deliver_order::whereIn('work_order_id',$work_orders_4_6)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_6_10 = Activity::whereIn('work_order_id',$work_orders_6_10)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_6_10 = Deliver_order::whereIn('work_order_id',$work_orders_6_10)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_10_15 = Activity::whereIn('work_order_id',$work_orders_10_15)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_10_15 = Deliver_order::whereIn('work_order_id',$work_orders_10_15)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_15_00 = Activity::whereIn('work_order_id',$work_orders_15_00)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_15_00 = Deliver_order::whereIn('work_order_id',$work_orders_15_00)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();


        $created_return_1_3 = Activity::whereIn('work_order_id',$work_orders_return_1_3)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_return_1_3 = Deliver_order::whereIn('work_order_id',$work_orders_return_1_3)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_return_4_6 = Activity::whereIn('work_order_id',$work_orders_4_6)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_return_4_6 = Deliver_order::whereIn('work_order_id',$work_orders_4_6)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_return_6_10 = Activity::whereIn('work_order_id',$work_orders_6_10)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_return_6_10 = Deliver_order::whereIn('work_order_id',$work_orders_6_10)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_return_10_15 = Activity::whereIn('work_order_id',$work_orders_10_15)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_return_10_15 = Deliver_order::whereIn('work_order_id',$work_orders_10_15)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();

        $created_return_15_00 = Activity::whereIn('work_order_id',$work_orders_15_00)->where('owner_stage_id', 48)->where('status', 'closed')->select('work_order_id','updated_at')->get();
        $packing_return_15_00 = Deliver_order::whereIn('work_order_id',$work_orders_15_00)->select('work_order_id','created_at')->groupBy('work_order_id')->orderBy('work_order_id', 'asc')->get();


        $work_order_ids_1_3 = Activity::whereIn('work_order_id',$work_orders_1_3)->where('owner_stage_id', 48)->where('status', 'closed')->pluck('work_order_id')->toArray();
        $sum_qty_1_3 = WorkOrder::whereIn('id', $work_order_ids_1_3)->sum('product_count');
        $qty_1_3 = ['sum_qty_1_3'=>$sum_qty_1_3];

        $work_order_ids_4_6 = Activity::whereIn('work_order_id',$work_orders_4_6)->where('owner_stage_id', 48)->where('status', 'closed')->pluck('work_order_id')->toArray();
        $sum_qty_4_6 = WorkOrder::whereIn('id', $work_order_ids_4_6)->sum('product_count');
        $qty_4_6 = ['sum_qty_4_6'=>$sum_qty_4_6]; 

        $work_order_ids_6_10 = Activity::whereIn('work_order_id',$work_orders_6_10)->where('owner_stage_id', 48)->where('status', 'closed')->pluck('work_order_id')->toArray();
        $sum_qty_6_10 = WorkOrder::whereIn('id', $work_order_ids_6_10)->sum('product_count');
        $qty_6_10 = ['sum_qty_6_10'=>$sum_qty_6_10]; 

        $work_order_ids_10_15 = Activity::whereIn('work_order_id',$work_orders_10_15)->where('owner_stage_id', 48)->where('status', 'closed')->pluck('work_order_id')->toArray();
        $sum_qty_10_15 = WorkOrder::whereIn('id', $work_order_ids_10_15)->sum('product_count');
        $qty_10_15 = ['sum_qty_10_15'=>$sum_qty_10_15]; 

        $work_order_ids_15_00 = Activity::whereIn('work_order_id',$work_orders_15_00)->where('owner_stage_id', 48)->where('status', 'closed')->pluck('work_order_id')->toArray();
        $sum_qty_15_00 = WorkOrder::whereIn('id', $work_order_ids_15_00)->sum('product_count');
        $qty_15_00 = ['sum_qty_15_00'=>$sum_qty_15_00]; 
       
        $counts_1_3 = [];    $count_hours_1_3=[];
        foreach ($packing_1_3 as $packing) {
            // Find the corresponding item in $created_1_3 based on work_order_id
            $created = $created_1_3->firstWhere('work_order_id', $packing->work_order_id);

            if ($created) {
                $difference = $packing->created_at->diffInDays($created->updated_at);
                $counts_1_3[] = $difference;
            }

            if ($created) {
                $difference_hours = $packing->created_at->diffInHours($created->updated_at);
                $count_hours_1_3[] = $difference_hours;
                sort($count_hours_1_3);
                $first_value_1_3 = reset($count_hours_1_3);
                $last_value_1_3 = end($count_hours_1_3);
            }
        }
        $first_days_1_3 = floor($first_value_1_3 / 24);
        $first_remaining_hours_1_3 = $first_value_1_3 % 24;
        $faster_1_3 = ['days'=>$first_days_1_3 , 'hours'=>$first_remaining_hours_1_3];

        $last_days_1_3 = floor($last_value_1_3 / 24);
        $last_remaining_hours_1_3 = $last_value_1_3 % 24;
        $slower_1_3 = ['days'=>$last_days_1_3 , 'hours'=>$last_remaining_hours_1_3];

        
        $averageDays_1_3 = count($counts_1_3) > 0 ? array_sum($counts_1_3) / count($counts_1_3) : 0;         //متوسط عدد الايام التشغيل 

        $days_1_3 = floor($averageDays_1_3);
        $hours_1_3 = round(($averageDays_1_3 - $days_1_3) * 24);

        $average_1_3 = ['days'=>$days_1_3 , 'hours'=>$hours_1_3];

//    return $average_1_3;

        $counts_4_6 = [];  $count_hours_4_6=[];
        foreach ($packing_4_6 as $packing) {
            $created = $created_4_6->firstWhere('work_order_id', $packing->work_order_id);
                 
            if ($created) {
                $difference = $packing->created_at->diffInDays($created->updated_at);
                $counts_4_6[] = $difference;
            }

            if ($created) {
                $difference_hours = $packing->created_at->diffInHours($created->updated_at);
                $count_hours_4_6[] = $difference_hours;
                sort($count_hours_4_6);
                $first_value_4_6 = reset($count_hours_4_6);
                $last_value_4_6 = end($count_hours_4_6);
            }
        }
        $first_days_4_6 = floor($first_value_4_6 / 24);
        $first_remaining_hours_4_6 = $first_value_4_6 % 24;
        $faster_4_6 = ['days'=>$first_days_4_6 , 'hours'=>$first_remaining_hours_4_6];

        $last_days_4_6 = floor($last_value_4_6 / 24);
        $last_remaining_hours_4_6 = $last_value_4_6 % 24;
        $slower_4_6 = ['days'=>$last_days_4_6 , 'hours'=>$last_remaining_hours_4_6];


        $averageDays_4_6 = count($counts_4_6) > 0 ? array_sum($counts_4_6) / count($counts_4_6) : 0;         //متوسط عدد الايام التشغيل 

        $days_4_6 = floor($averageDays_4_6);
        $hours_4_6 = round(($averageDays_4_6 - $days_4_6) * 24);

        $average_4_6 = ['days'=>$days_4_6 , 'hours'=>$hours_4_6];                                     //  متوسط عدد الايام التشغيل بالايام والساعات 
        

        $counts_6_10 = [];      $count_hours_6_10=[];
        foreach ($packing_6_10 as $packing) {
            $created = $created_6_10->firstWhere('work_order_id', $packing->work_order_id);
            
            if ($created) {
                $difference = $packing->created_at->diffInDays($created->updated_at);
                $counts_6_10[] = $difference;
            }

            if ($created) {
                $difference_hours = $packing->created_at->diffInHours($created->updated_at);
                $count_hours_6_10[] = $difference_hours;
                sort($count_hours_6_10);
                $first_value_6_10 = reset($count_hours_6_10);
                $last_value_6_10 = end($count_hours_6_10);
            }
        }
        $first_days_6_10 = floor($first_value_6_10 / 24);
        $first_remaining_hours_6_10 = $first_value_6_10 % 24;
        $faster_6_10 = ['days'=>$first_days_6_10 , 'hours'=>$first_remaining_hours_6_10];

        $last_days_6_10 = floor($last_value_6_10 / 24);
        $last_remaining_hours_6_10 = $last_value_6_10 % 24;
        $slower_6_10 = ['days'=>$last_days_6_10 , 'hours'=>$last_remaining_hours_6_10];


        $averageDays_6_10 = count($counts_6_10) > 0 ? array_sum($counts_6_10) / count($counts_6_10) : 0;         //متوسط عدد الايام التشغيل 

        $days_6_10 = floor($averageDays_6_10);
        $hours_6_10 = round(($averageDays_6_10 - $days_6_10) * 24);

        $average_6_10 = ['days'=>$days_6_10 , 'hours'=>$hours_6_10];                                              //  متوسط عدد الايام التشغيل بالايام والساعات 

        
        $counts_10_15 = [];        $count_hours_10_15=[];
        foreach ($packing_10_15 as $packing) {
            $created = $created_10_15->firstWhere('work_order_id', $packing->work_order_id);
            
            if ($created) {
                $difference = $packing->created_at->diffInDays($created->updated_at);
                $counts_10_15[] = $difference;
            }

            if ($created) {
                $difference_hours = $packing->created_at->diffInHours($created->updated_at);
                $count_hours_10_15[] = $difference_hours;
                sort($count_hours_10_15);
                $first_value_10_15 = reset($count_hours_10_15);
                $last_value_10_15 = end($count_hours_10_15);
            }
        }
        $first_days_10_15 = floor($first_value_10_15 / 24);
        $first_remaining_hours_10_15 = $first_value_10_15 % 24;
        $faster_10_15 = ['days'=>$first_days_10_15 , 'hours'=>$first_remaining_hours_10_15];

        $last_days_10_15 = floor($last_value_10_15 / 24);
        $last_remaining_hours_10_15 = $last_value_10_15 % 24;
        $slower_10_15 = ['days'=>$last_days_10_15 , 'hours'=>$last_remaining_hours_10_15];

        $averageDays_10_15 = count($counts_10_15) > 0 ? array_sum($counts_10_15) / count($counts_10_15) : 0;         //متوسط عدد الايام التشغيل 

        $days_10_15 = floor($averageDays_10_15);
        $hours_10_15 = round(($averageDays_10_15 - $days_10_15) * 24);

        $average_10_15 = ['days'=>$days_10_15 , 'hours'=>$hours_10_15];                                               //  متوسط عدد الايام التشغيل بالايام والساعات 

        
        $counts_15_00 = [];     $count_hours_15_00=[];
        foreach ($packing_15_00 as $packing) {
            $created = $created_15_00->firstWhere('work_order_id', $packing->work_order_id);
            
            if ($created) {
                $difference = $packing->created_at->diffInDays($created->updated_at);
                $counts_15_00[] = $difference;
            }

            if ($created) {
                $difference_hours = $packing->created_at->diffInHours($created->updated_at);
                $count_hours_15_00[] = $difference_hours;
                sort($count_hours_15_00);
                $first_value_15_00 = reset($count_hours_15_00);
                $last_value_15_00 = end($count_hours_15_00);
            }
        }
        $first_days_15_00 = floor($first_value_15_00 / 24);
        $first_remaining_hours_15_00 = $first_value_15_00 % 24;
        $faster_15_00 = ['days'=>$first_days_15_00 , 'hours'=>$first_remaining_hours_15_00];

        $last_days_15_00 = floor($last_value_15_00 / 24);
        $last_remaining_hours_15_00 = $last_value_15_00 % 24;
        $slower_15_00 = ['days'=>$last_days_15_00 , 'hours'=>$last_remaining_hours_15_00];

        $averageDays_15_00 = count($counts_15_00) > 0 ? array_sum($counts_15_00) / count($counts_15_00) : 0;         //متوسط عدد الايام التشغيل 

        $days_15_00 = floor($averageDays_15_00);
        $hours_15_00 = round(($averageDays_15_00 - $days_15_00) * 24);

        $average_15_00 = ['days'=>$days_15_00 , 'hours'=>$hours_15_00];                                              //  متوسط عدد الايام التشغيل بالايام والساعات 

        // $combined_fast_slow = [
        //     'faster_1_3' => $faster_1_3,
        //     'slower_1_3' => $slower_1_3,
        //     'faster_4_6' => $faster_4_6,
        //     'slower_4_6' => $slower_4_6,
        //     'faster_6_10' => $faster_6_10,
        //     'slower_6_10' => $slower_6_10,
        //     'faster_10_15' => $faster_10_15,
        //     'slower_10_15' => $slower_10_15,
        //     'faster_15_00' => $faster_15_00,
        //     'slower_15_00' => $slower_15_00,
        // ];
// return $combined_fast_slow;
        $translations = [
            'sum_qty_1_3' => 'مجموعة من 1 الى 3',
            'sum_qty_4_6' => 'مجموعة من 4 الى 6',
            'sum_qty_6_10' => 'مجموعة من 6 الى 10',
            'sum_qty_10_15' => 'مجموعة من 10 الى 15',
            'sum_qty_15_00' => 'مجموعة من 15 فيما فوق',
        ];

        return view('crm_views.dashboard_report_result')->with([
            'request'=>$request,
            'faster'=>$faster,
            'slower'=>$slower,
            'average_1_3'=>$average_1_3,
            'average_4_6'=>$average_4_6,
            'average_6_10'=>$average_6_10,
            'average_10_15'=>$average_10_15,
            'average_15_00'=>$average_15_00,

            'faster_1_3' => $faster_1_3,
            'slower_1_3' => $slower_1_3,
            'faster_4_6' => $faster_4_6,
            'slower_4_6' => $slower_4_6,
            'faster_6_10' => $faster_6_10,
            'slower_6_10' => $slower_6_10,
            'faster_10_15' => $faster_10_15,
            'slower_10_15' => $slower_10_15,
            'faster_15_00' => $faster_15_00,
            'slower_15_00' => $slower_15_00,

            'data'=>[
                'sum_qty_1_3'=>$sum_qty_1_3,
                'sum_qty_4_6'=>$sum_qty_4_6,
                'sum_qty_6_10'=>$sum_qty_6_10,
                'sum_qty_10_15'=>$sum_qty_10_15,
                'sum_qty_15_00'=>$sum_qty_15_00,
            ],
            'translations'=>$translations,
            // 'combined_fast_slow'=>$combined_fast_slow,
        ]); 
    }

    public function activity_logs(Request $request){

        $users = User::select('name','username','id')->get();
        $work_orders = WorkOrder::select('id','id')->get();
    
        return view('crm_views.activity_logs')->with([
            'users'=>$users,
            'work_orders'=>$work_orders,
        ]);

    }

    public function activity_logs_result(Request $request){

        // return $request;
        $activities = ActivityLog::with(['causer:name,id']);

        if($request->user_id !=='all'){
            $activities=$activities->where('causer_id',$request->user_id);
        }

        if($request->workorder_id !=='all'){
            $activities=$activities->where('subject_id',$request->workorder_id);
        }

        if (isset($request->from)) {
        $activities=$activities->where('created_at','>=',$request->from);
        }

        if (isset($request->to)) {
        $activities=$activities->where('created_at','<=',$request->to.' 23:59:59');
        }

        $activities = $activities->get();

        return view('crm_views.activity_logs_result')->with([
            'activities'=>$activities,
        ]);
    }

    public function final_delivers_report(Request $request){

        $final_deliver_order_ids = FinalDeliver::select('final_deliver_order_id')->distinct()->get();
        $customers = Customer::select('name','id')->get();
        $work_orders = WorkOrder::select('id')->get();
        $recepits = ReceiveReceipt::select('id')->get();
        $receivables = Receivable::select('name','id')->get();
        $models = ReceiveReceipt::whereNotNULL('model')->select('model')->distinct()->get();

        // $work_orders = WorkOrder::select('id','id')->get();
    
        return view('crm_views.final_delivers_report')->with([
            'final_deliver_order_ids'=>$final_deliver_order_ids,
            'customers'=>$customers,
            'work_orders'=>$work_orders,
            'recepits'=>$recepits,
            'models'=>$models,
            'receivables'=>$receivables,
        ]);

    }

    public function final_delivers_result(Request $request){

        // return $request;

        $query = FinalDeliver::select(
            'final_deliver_order_id',
            'work_orders.id as work_order_id',
            'work_orders.product_count as work_order_product_count',
            'work_orders.product_weight as work_order_product_weight',
            DB::raw('SUM(final_deliver_details.package_number) as package_number_sum'),
            DB::raw('SUM(final_deliver_details.total) as total_sum'),
            'receive_receipts.id as receive_receipt_id',
            'receive_receipts.model as receive_receipt_model',
            'customers.name as customer_name',
            'receivables.name as receivable_name',
            'products.name as product_name',
            'final_deliver_details.created_at',
            DB::raw('(SELECT GROUP_CONCAT(DISTINCT si.name SEPARATOR ",")
            FROM work_order_stages wos
            JOIN service_item_satges sis ON wos.service_item_satge_id = sis.id
            JOIN service_items si ON sis.service_item_id = si.id
            WHERE wos.work_order_id = work_orders.id) as service_item_names'),

            DB::raw('(SELECT SUM(si.price)
            FROM work_order_stages wos
            JOIN service_item_satges sis ON wos.service_item_satge_id = sis.id
            JOIN service_items si ON sis.service_item_id = si.id
            WHERE wos.work_order_id = work_orders.id) as service_items_total_price')
        )
        ->join('deliver_orders', 'final_deliver_details.deliver_order_id', '=', 'deliver_orders.id')
        ->join('work_orders', 'deliver_orders.work_order_id', '=', 'work_orders.id')
        ->leftJoin('customers', 'deliver_orders.customer_id', '=', 'customers.id') 
        ->leftJoin('receivables', 'deliver_orders.receive_id', '=', 'receivables.id') 
        ->leftJoin('receive_receipts', 'deliver_orders.receipt_id', '=', 'receive_receipts.id') 
        ->leftJoin('products', 'deliver_orders.product_id', '=', 'products.id'); 
       
        // Apply filters based on request parameters
        if ($request->final_deliver_order_id !== 'all') {
            $query = $query->where('final_deliver_order_id', $request->final_deliver_order_id);
        }
        
        if ($request->customer_id !== 'all') {
            $query = $query->where('deliver_orders.customer_id', $request->customer_id);
        }
        
        if ($request->work_order_id !== 'all') {
            $query = $query->where('work_orders.id', $request->work_order_id);
        }
        
        if ($request->recepit_id !== 'all') {
            $query = $query->where('deliver_orders.receipt_id', $request->recepit_id);
        }
        
        if ($request->model !== 'all') {
            $recepit_ids = ReceiveReceipt::where('model', $request->model)->pluck('id')->toArray();
            $query = $query->whereIn('deliver_orders.receipt_id', $recepit_ids);
        }
        
        if (isset($request->from)) {
            $query = $query->where('final_deliver_details.created_at', '>=', $request->from);
        }
        
        if (isset($request->to)) {
            $query = $query->where('final_deliver_details.created_at', '<=', $request->to . ' 23:59:59');
        }
        
        if (isset($request->flag_inovice)) {
            $query = $query->where('final_deliver_details.flag_inovice', $request->flag_inovice);
        }
        
        $report = $query->groupBy(
            'final_deliver_order_id',
            'work_orders.id',
            'customers.name',
            'receivables.name',
            'products.name',
            'receive_receipts.id',
            'receive_receipts.model',
            'final_deliver_details.created_at'
        )->get();
        
        // Convert the concatenated service item names into an array
        $report->transform(function ($item) {
            $item->service_item_names = explode(',', $item->service_item_names);
            return $item;
        });
    
        $formattedReport = [];
        foreach ($report as $item) {
            $finalDeliverOrderId = $item->final_deliver_order_id;
    
            // Initialize the entry for this final_deliver_order_id if it doesn't exist
            if (!isset($formattedReport[$finalDeliverOrderId])) {
                $formattedReport[$finalDeliverOrderId] = [
                    'final_deliver_order_id' => $finalDeliverOrderId,
                    'work_orders' => [],
                    'total_package_number' => 0,
                    'total_sum' => 0,
                ];
            }
    
            // Add the work_order details with additional information
            $formattedReport[$finalDeliverOrderId]['work_orders'][] = [
                'work_order_id' => $item->work_order_id,
                'work_order_product_count' => $item->work_order_product_count,
                'work_order_product_weight' => $item->work_order_product_weight,
                'receive_receipt_id' => $item->receive_receipt_id,
                'model' => $item->receive_receipt_model,
                'package_number_sum' => $item->package_number_sum,
                'total_sum' => $item->total_sum,
                'customer_name' => $item->customer_name ?? null, // Handle null values
                'receivable_name' => $item->receivable_name ?? null, // Handle null values
                'product_name' => $item->product_name ?? null, // Handle null values
                'created_at' => $item->created_at, // Handle null values
                'service_items_total_price' => $item->service_items_total_price,
                'service_item_names' => $item->service_item_names, // Add service_item_names for this work order
            ];
    
            // Update the totals for this final_deliver_order_id
            $formattedReport[$finalDeliverOrderId]['total_package_number'] += $item->package_number_sum;
            $formattedReport[$finalDeliverOrderId]['total_sum'] += $item->total_sum;
        }
    
        // Convert the formatted report to a collection
        $formattedReport = collect($formattedReport)->values();

        return view('crm_views.final_delivers_result')->with([
            // 'report'=>$report,
            'result'=>$formattedReport,
            'request'=>$request,
        ]);
    }

// ============================================================ For Ajax ========================================================================
    public function get_customers_for_model(Request $request){
        //  return $request->model;
        $customer_ids=ReceiveReceipt::where('model',$request->model)->select('customer_id')->distinct()->pluck('customer_id')->toArray();
        $customers=Customer::whereIn('id',$customer_ids)->select('name','id')->get();
        return $customers;
        }

    public function get_customers_for_recepit_id(Request $request){
        //  return $request->recepit_id;
        $customer_id=ReceiveReceipt::where('id',$request->recepit_id)->pluck('customer_id')->toArray();
        $customer=Customer::whereIn('id',$customer_id)->select('name','id')->get();
        return $customer;
        }
//    ================================================================================================================================================     
}

