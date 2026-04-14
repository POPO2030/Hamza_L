<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\Deliver_orderDataTable;
use App\DataTables\Deliver_orderDataTable_final_deliver;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateDeliver_orderRequest;
use App\Http\Requests\CRM\UpdateDeliver_orderRequest;
use App\Repositories\CRM\Deliver_orderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use DataTables;
use Illuminate\Http\Request;
use App\Models\CRM\Customer;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\Product;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Receivable;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\Deliver_order_details;
use App\Models\CRM\FinalDeliver;
use App\Models\CRM\Service;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\ServiceItem;
use App\Models\sales\Customer_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class Deliver_orderController extends AppBaseController
{
    /** @var Deliver_orderRepository $deliverOrderRepository*/
    private $deliverOrderRepository;

    public function __construct(Deliver_orderRepository $deliverOrderRepo)
    {
        $this->deliverOrderRepository = $deliverOrderRepo;
    }

    /**
     * Display a listing of the Deliver_order.
     *
     * @param Deliver_orderDataTable $deliverOrderDataTable
     *
     * @return Response
     */
    public function index(Deliver_orderDataTable $deliverOrderDataTable)
    {

        return $deliverOrderDataTable->render('deliver_orders.index');
        
    }

    public function final_deliver_orders(Deliver_orderDataTable_final_deliver $deliverOrderDataTable)
    {

        return $deliverOrderDataTable->render('deliver_orders.final_deliver_orders');
        
    }

    /**
     * Show the form for creating a new Deliver_order.
     *
     * @return Response
     */
    public function create($receipt_id=null,$workOrder_id=null,$customer_id=null,$products_id=null,$receive_id=null)
    {

        $redirect='';
        if($receipt_id && $workOrder_id && $customer_id && $products_id && $receive_id){

           $data= WorkOrder::with('get_ReceiveReceipt','get_deliver_order.get_details')->find($workOrder_id);
          
        $deliverOrderIds = Deliver_order::select('id')->where('receipt_id' , $receipt_id )->pluck('id')->toArray();     //   كل ال IDs بتاعت اذن الاستلام
        $totaldeliverpack= Deliver_order_details::whereIn('deliver_order_id',$deliverOrderIds)->sum('total');        ///  مجموع الكميات اللى تم تغليفها
        // return $totaldeliverpack;
           $total_deliver_order = 0;
            for ($i=0; $i <count($data->get_deliver_order) ; $i++) { 
                for($x=0;$x<count($data->get_deliver_order[$i]->get_details);$x++){
                    $total_deliver_order +=  $data->get_deliver_order[$i]->get_details[$x]->total;
                }
            }
           $remaining = $data->product_count - $total_deliver_order;                         // المتبقى من الغسلة
            $remainReceipt= $data->get_ReceiveReceipt->final_count - $totaldeliverpack ;                // المتبقى من اذن الاستلام

           
             if (!empty($remaining) && $remaining > 0){

            $redirect='true';
            $customer_data = Customer::where('id',$customer_id)->pluck('name','id');
            $receipt_data = ReceiveReceipt::where('id',$receipt_id)->pluck('id','id');
            $product_data = Product::where('id',$products_id)->pluck('name','id');
            $receive_data = Receivable::where('id',$receive_id)->pluck('name','id');
            $work_order_data= WorkOrder::where('id',$workOrder_id)->pluck('id','id');

         
            $receivables=Receivable::pluck('name','id');

            return view('deliver_orders.create')
            ->with([
                'redirect'=>$redirect,
                'receipt_data'=>$receipt_data,
                'customer_data'=>$customer_data,
                'product_data'=>$product_data ,
                'receive_data'=>$receive_data ,
                'product_type'=>$data->get_ReceiveReceipt->product_type,
                'work_order_data'=>$work_order_data,
                'data'=>$data->product_count,
                'receivables'=>$receivables,
                'remaining' => $remaining,
                'remainReceipt' => $remainReceipt,
                ]);

            }else{
                Flash::error('عفوا تم تغليف الغسلة بالكامل');
                return redirect(route('workOrders.index'));    
            }
        }else{

            $customers=Customer::pluck('name','id');
            $receipts=ReceiveReceipt::pluck('id','id');
            $products=Product::pluck('name','id');
            $work_orders=WorkOrder::pluck('id','id');
            $product_count= WorkOrder::pluck('product_count');
            $receivables=Receivable::pluck('name','id');
            return view('deliver_orders.create')
            ->with([
                'customers'=>$customers,
                'receipts'=>$receipts,
                'products'=>$products,
                'work_orders'=>$work_orders,
                // 'product_count'=>$product_count,
                'receivables'=>$receivables,
                'data'=>$data->product_count,
                'remaining' => $remaining,
                'remainReceipt' => $remainReceipt,
            ]);
        }
  

    }




    /**
     * Store a newly created Deliver_order in storage.
     *
     * @param CreateDeliver_orderRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliver_orderRequest $request)
    { 
        // return $request; 
        if($request->count){   
        $data= WorkOrder::with('get_deliver_order.get_details')->find($request->work_order_id);
        

        $deliverOrderIds = Deliver_order::select('id')->where('receipt_id' , $request->receipt_id )->pluck('id')->toArray();     //   كل ال IDs بتاعت اذن الاستلام
        $totaldeliverpack= Deliver_order_details::whereIn('deliver_order_id',$deliverOrderIds)->sum('total');        ///  مجموع الكميات اللى تم تغليفها
    
        $total_deliver_order = 0;
        for ($i=0; $i <count($data->get_deliver_order) ; $i++) { 
            for($x=0;$x<count($data->get_deliver_order[$i]->get_details);$x++){
                $total_deliver_order +=  $data->get_deliver_order[$i]->get_details[$x]->total;
            }
        }

       $remaining = $data->product_count - $total_deliver_order;                         // المتبقى من الغسلة
       $remainReceipt= $data->get_ReceiveReceipt->final_count - $totaldeliverpack ;                // المتبقى من اذن الاستلام


            if ( $totaldeliverpack + array_sum($request->total) <= $data->get_ReceiveReceipt->final_count) {
                
     
            try {
                DB::beginTransaction();
                $input['work_order_id'] = $request->work_order_id;
                $input['product_id'] = $request->product_id;
                $input['product_type'] = $request->product_type;
                $input['receipt_id'] = $request->receipt_id;
                $input['receive_id'] = $request->receive_id;
                $input['customer_id'] = $request->customer_id;
                $input['status'] = 'open';

               
                $deliverOrder = $this->deliverOrderRepository->create($input);
    
                $data2=[];
                for ($i=0; $i <count($request->package_number) ; $i++) { 
                    $data2[$i]=[
                        'deliver_order_id'=> $deliverOrder->id ,
                        'package_number'=>$request->package_number[$i] ,
                        'count'=>$request->count[$i] ,
                        'total'=>$request->total[$i],
                        'weight'=>$request->total[$i] * $data->weight_piece,
                        'creator_id'=> Auth::user()->id,
                        'barcode'=>rand(1234567890,50),
                        'created_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                Deliver_order_details::insert($data2);
   
                //  ------------------------------------------------------ تسجيل Log -------------------------------------------------------
                $data=$deliverOrder->where('id',$deliverOrder->id)->with(['get_customer:name,id'])->first();
                $customer_name=$data->get_customer->name;
                $sum_package_number=array_sum($request->package_number);
                $sum_total=array_sum($request->total);

        
                $properties['امر الشغل'] = $request->work_order_id;
                $properties['اذن تغليف'] = $deliverOrder->id;
                $properties['العميل'] = $customer_name;
                $properties['عدد الاكياس'] = $sum_package_number;
                $properties['الاجمالى'] = $sum_total;
               
                activity()
                ->performedOn(new Deliver_order())
                ->causedBy(Auth::user())
                ->withProperties([
                    'attributes' => $properties,
                    
                    ])
                ->tap(function ($activity) use ($deliverOrder) {
                    $activity->subject_id = $deliverOrder->work_order_id;
                    $activity->save();
                })
                ->log('created');
                // -----------------------------------------------------------------------------------------------------------------------

                // $new_remaining = $data->product_count - array_sum($request->total);   
                // if ($new_remaining <= 0) {
                //     $deliverOrder->status = 'closed';
                // }else{
                //     $deliverOrder->status = 'open';
                // }
                // $deliverOrder->save(); 


        // ==============================================  حساب تكلفة الغسلة  ================================================

            $service_ids_water= Service::where('service_category_id',1)->pluck('id')->toArray();    // الخدمات المائية
            $service_ids_dry= Service::where('service_category_id',2)->pluck('id')->toArray();    // الخدمات الجافة
            $service_item_ids = Work_order_stage::where('work_order_id',$request->work_order_id)->pluck('service_item_satge_id')->toArray();
            $selectedservice = ServiceItemSatge::whereIn('id',$service_item_ids)->distinct()->pluck('service_item_id')->toArray();   // كل الخدمات المختارة 

            $service_item_with_kilo = ServiceItem::whereIn('id',$selectedservice)->whereIn('service_id',$service_ids_water)->get();
            $service_item_with_unit = ServiceItem::whereIn('id',$selectedservice)->whereIn('service_id',$service_ids_dry)->get();

            $total_amount_water=0;
            $total_water=0;
            if($service_item_with_kilo){

            foreach($service_item_with_kilo as $item){
                $total_water+= $item->money;
            }
            
            }
            $total_amount_water= $total_water * $data->product_weight;    //مجموع اسعار الخدمات المائية * الوزن
        
            $total_amount_unit=0;
            $total_unit=0;
            if($service_item_with_unit){
                foreach($service_item_with_unit as $unit){
                    $total_unit+= $unit->money;
                }

            }
            $total_amount_unit= $total_unit * $data->product_count;       //مجموع اسعار الفاشون * عدد القطع

            $total_amount_work_order = $total_amount_water + $total_amount_unit;
            
            // $check=Customer_details::where('work_order_id',$data->id)->first();
            // if(!isset($check)){
            //     $customer_details = Customer_details::create([
            //         'customer_id'=>$request->customer_id,
            //         'work_order_id'=>$data->id,
            //         'cash_balance_debit'=>$total_amount_work_order,
            //         'flag'=>'work_order',
            //         'note'=>'حساب غسلة',
            //         'creator_id'=>Auth::user()->id,
            //     ]);
            // }
          
        // ==============================================================================================
                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
            }
           
        }else{
    
            session()->flash('error', 'كمية التغليف اكبر من الكمية المتبقية فى اذن الاستلام');
            return redirect('deliverOrders/create/'.$request->receipt_id.'/'.$request->work_order_id.'/'.$request->customer_id.'/'.$request->product_id.'/'.$request->receive_id);
    
        }

        
            Flash::success('تم إنشاء إذن التغليف بنجاح');
            return redirect(route('deliverOrders.index'));
        }else{
            Flash::error('لم يتم اختيار كميات');
            return redirect(route('deliverOrders.index'));
        }

    
    }

    /**
     * Display the specified Deliver_order.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //$deliverOrder = $this->deliverOrderRepository->with('get_customer')->find($id);
        $deliverOrder = Deliver_order::with(['get_customer:name,id','get_products:name,id','get_receivable:name,id','get_details'])->find($id);
    //    return $deliverOrder;

        if (empty($deliverOrder)) {
            Flash::error('Deliver Order not found');

            return redirect(route('deliverOrders.index'));
        }

        return view('deliver_orders.show')->with('deliverOrder', $deliverOrder);
    }

    /**
     * Show the form for editing the specified Deliver_order.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hasDelivered= Deliver_order_details::select('delivered_package')
        ->where('deliver_order_id',$id)->sum('delivered_package');
    //    return $hasDelivered;
     if($hasDelivered>0){
        Flash::error('عفوا....لايمكن التعديل على اذن تغليف تم تسليم جزء منه او تم تسليمه بالكامل');
        return redirect(route('deliverOrders.index'));    
    }

    
        $customers=Customer::pluck('name','id');
        $receipts=ReceiveReceipt::pluck('id','id');
        $products=Product::pluck('name','id');
        $work_orders=WorkOrder::pluck('id','id');

        $receivables=Receivable::pluck('name','id');
        $deliverOrder = Deliver_order::with(['get_customer:name,id','get_products:name,id','get_receivable:name,id','get_details','get_receive_receipt'])->find($id);

        
        $deliverOrderIds = Deliver_order::select('id')->where('receipt_id' , $deliverOrder->receipt_id )->pluck('id')->toArray();     //   كل ال IDs بتاعت اذن الاستلام
        $totaldeliverpack= Deliver_order_details::whereIn('deliver_order_id',$deliverOrderIds)->sum('total');        ///  مجموع الكميات اللى تم تغليفها
        

     $data= WorkOrder::with('get_deliver_order.get_details')->find($deliverOrder->work_order_id);

       // return $data;
        
        $total_deliver_order = 0;
         for ($i=0; $i <count($data->get_deliver_order) ; $i++) { 
             for($x=0;$x<count($data->get_deliver_order[$i]->get_details);$x++){
                 $total_deliver_order +=  $data->get_deliver_order[$i]->get_details[$x]->total;
             }
         }
         
         $remaining = $data->product_count - $total_deliver_order;                         // المتبقى من الغسلة
         $remainReceipt= $data->get_ReceiveReceipt->final_count - $totaldeliverpack ;                // المتبقى من اذن الاستلام

       //  return $remaining;

        if (empty($deliverOrder)) {
            Flash::error('Deliver Order not found');

            return redirect(route('deliverOrders.index'));
        }

        return view('deliver_orders.edit')
        ->with([
            'deliverOrder'=> $deliverOrder,
            'customers'=>$customers,
            'receipts'=>$receipts,
            'products'=>$products,
            'work_orders'=>$work_orders,
            'data'=>$data->product_count,
            'receivables'=>$receivables,
            'remaining' => $remaining,
            'remainReceipt' => $remainReceipt,
        ]);
    }

    /**
     * Update the specified Deliver_order in storage.
     *
     * @param int $id
     * @param UpdateDeliver_orderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliver_orderRequest $request)
    {
    
        $deliverOrderIds = Deliver_order::select('id')->where('receipt_id' , $request->receipt_id )->pluck('id')->toArray();     //   كل ال IDs بتاعت اذن الاستلام
        $totaldeliverpack= Deliver_order_details::whereIn('deliver_order_id',$deliverOrderIds)->sum('total');        ///  مجموع الكميات اللى تم تغليفها
        $totaldeliverpackOne= Deliver_order_details::where('deliver_order_id',$id)->sum('total');        ///  مجموع الكميات اللى تم تغليفها للاذن المراد تعديله
        // return $totaldeliverpackOne;
        try {
            DB::beginTransaction();
            //---------------------------------   لتسجيل Log ------------------------------------
            $data_deliver_details=Deliver_order_details::where('deliver_order_id',$id)->get();
            $data_deliver=Deliver_order::where('id',$id)->with(['get_details','get_customer:name,id'])->first();
 
            $customer_name=$data_deliver->get_customer->name;
 
            $sum_current_package=0; $sum_current_total=0;
            foreach($data_deliver->get_details as $item){
                $sum_current_package+=$item->package_number;
                $sum_current_total+=$item->total;
            }
 
            $currentData['امر الشغل'] = $data_deliver->work_order_id;
            $currentData['اذن تغليف'] = $data_deliver->id;
            $currentData['العميل'] = $customer_name;
            $currentData['عدد الاكياس'] = $sum_current_package;
            $currentData['الاجمالى'] = $sum_current_total;
            // ------------------------------------------------------------------------------------------------

            Deliver_order_details::where('deliver_order_id',$id)->delete();
            $data= WorkOrder::with('get_ReceiveReceipt','get_deliver_order.get_details')->find($request->work_order_id);
            $total_deliver_order = 0;
            for ($i=0; $i <count($data->get_deliver_order) ; $i++) { 
                for($x=0;$x<count($data->get_deliver_order[$i]->get_details);$x++){
                    $total_deliver_order +=  $data->get_deliver_order[$i]->get_details[$x]->total;
                }
            }
            $remaining = $data->product_count - $total_deliver_order;                         // المتبقى من الغسلة
            $remainReceipt= $data->get_ReceiveReceipt->final_count - $totaldeliverpack ;                // المتبقى من اذن الاستلام
            $newtotaldeliverpack =  $totaldeliverpack - $totaldeliverpackOne; 
            //    return $newRemain;   

            if ($newtotaldeliverpack + array_sum($request->total) > $data->get_ReceiveReceipt->final_count) {
                DB::rollBack();
                Flash::error('الكمية المطلوبة اكبر من العدد المتبقى');
                return redirect(route('deliverOrders.index')); 
            }

            if(! $request->count){  
                Flash::error('لم يتم اختيار كميات');
                return redirect(route('deliverOrders.index'));
            }

                $deliverOrder = $this->deliverOrderRepository->find($id);

                $deliverOrder = $this->deliverOrderRepository->update($request->all(), $id);
        
                
                $data2=[];
                for ($i=0; $i <count($request->package_number) ; $i++) { 
                    $data2[$i]=[
                        'deliver_order_id'=> $deliverOrder->id ,
                        'package_number'=>$request->package_number[$i] ,
                        'count'=>$request->count[$i] ,
                        'total'=>$request->total[$i],
                        'weight'=>$request->total[$i] * $data->weight_piece,
                        'updated_by'=> Auth::user()->id,
                        'barcode'=>rand(1234567890,50)];
                }
                Deliver_order_details::insert($data2);

                // =========================================== تسجيل Log ============================================
                $requestData['امر الشغل'] = $deliverOrder->work_order_id;
                $requestData['اذن تغليف'] = $deliverOrder->id;
                $requestData['العميل'] = $customer_name;
                $requestData['عدد الاكياس'] = array_sum($request->package_number);
                $requestData['الاجمالى'] = array_sum($request->total);

                $removedData = array_diff($currentData, $requestData);
                $addedData = array_diff($requestData, $currentData);

                $currentData=$requestData;

                if ($addedData) {
                    $properties['added'] = $addedData;
                }
                if ($removedData) {
                    $properties['removed'] = $removedData;
                }
                $properties['current'] = $currentData;
                activity()
                ->performedOn(new Deliver_order())
                ->causedBy(Auth::user())
                ->withProperties($properties)
                ->tap(function ($activity) use ($deliverOrder) {
                    $activity->subject_id = $deliverOrder->work_order_id;
                    $activity->save();
                })
                ->log('updated');
                // ==================================================================================================

                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
            }

            Flash::success('تم التعديل بنجاح');
            return redirect(route('deliverOrders.index'));
    
    }


    /**
     * Remove the specified Deliver_order from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

        $deliverOrder = $this->deliverOrderRepository->find($id);

        $has_deliverorder=FinalDeliver::where('deliver_order_id',$deliverOrder->id)->get();
        if(!count($has_deliverorder)){

        if (empty($deliverOrder)) {
            Flash::error('Deliver Order not found');

            return redirect(route('deliverOrders.index'));
        }
    
        $this->deliverOrderRepository->delete($id);
        Deliver_order_details::where('deliver_order_id',$id)->delete();

        // ============================================== لتسجيل Log =====================================
        activity()
        ->performedOn(new Deliver_order())
        ->causedBy(Auth::user())
        ->withProperties(['old' => $deliverOrder->toArray()])
        ->tap(function ($activity) use ($deliverOrder) {
            $activity->subject_id = $deliverOrder->work_order_id;
            $activity->save();
        })
        ->log('deleted');
        // ==================================================================================================

        Flash::success('تم حذف اذن التغليف بنجاح');

        return redirect(route('deliverOrders.index'));

    }else{
        Flash::error('عفوآ...لا يمكن حذف اذن التغليف  تم تسليم جزء منه او تم تسليمه بالكامل');
        return redirect(route('deliverOrders.index'));
    }
    }

    public function print_barcode($id){
        $deliver_order_details = Deliver_order_details::where('deliver_order_id',$id)->get();
        $workOrder = Deliver_order::where('id',$id)->get();
        // return $workOrder[0];
        // return $deliver_order_details;
        return view('deliver_orders.print_barcode')->with(['deliver_order_details'=> $deliver_order_details, 'workOrder'=>$workOrder]);
    }



    public function close_deliver_order($id){

            // لجب المتبقى من كمية التسليم
            $product_count= WorkOrder::where('id',$workOrder_id)->pluck('product_count');                                 // كمية الغسلة
            $deliver_order_id = Deliver_order::where('work_order_id',$workOrder_id)->pluck('id');                         //id بتاع اذن التسليم فى جدول التسليم
            $totalDelivered = Deliver_order_details::whereIn('deliver_order_id', $deliver_order_id)->sum('total');        // مجموع الاجمالى الخاص برقم امر التسليم
            $remaining = $product_count[0] - $totalDelivered;                                                             // الفرق مابين كمية الغسلة و المتبقى

        if(count($remaining)>0){
            return \Redirect::back()->withErrors(['msg' => 'لايمكن اغلاق اذن التغليف لعدم وجود كمية جاهزة']);
        }
        // $closed_by_id = Auth::user()->id;
        // $closed_team_id = Auth::user()->team_id;
        // $input['closed_by_id']=$closed_by_id ;
        // $input['closed_team_id']= $closed_team_id;
        $input['status']='closed';
        Deliver_order::where('id',$id)->update($input);
        return redirect()->back();
    }


    public function deliverOrders_finance($receipt_id, $workOrder_id, $customer_id, $products_id, $receive_id)
    {
        $has_deliverorder=Deliver_order::where('work_order_id',$workOrder_id)->get();
        // return $has_deliverorder;
        if(!count($has_deliverorder)>0){
            return \Redirect::back()->withErrors(['msg' => 'عفوا... لم يتم تغليف الغسلة حتى الان  ']);
        }

        $receipt_data = ReceiveReceipt::where('id', $receipt_id)->pluck('id', 'id');
        $work_order_data = WorkOrder::where('id', $workOrder_id)->pluck('id', 'id');
        $customer_data = Customer::where('id', $customer_id)->pluck('name', 'id');
        $product_data = Product::where('id', $products_id)->pluck('name', 'id');
        $receive_data = Receivable::where('id', $receive_id)->pluck('name', 'id');
        $product_type=ReceiveReceipt::where('id', $receipt_id)->first();
   
        // $start_value = 1;
        // $finalDeliver_id = $start_value;
        // while (FinalDeliver::where('final_deliver_order_id', $finalDeliver_id)->exists()) {
        //     $finalDeliver_id++;
        // }
    
        $finalDeliver_id = FinalDeliver::all()->last();

        if(!isset($finalDeliver_id)){
            $finalDeliver_id=1;
        }else{
            $finalDeliver_id = $finalDeliver_id->final_deliver_order_id+1;
        }

        $ready_packages = Deliver_order::with('get_details', 'get_count_product')
            ->where('work_order_id', $workOrder_id)
            ->where('receipt_id', $receipt_id)
            ->get();
    
        return view('deliver_orders.deliverOrders_finance')->with([
            'customer_data' => $customer_data,
            'receipt_data' => $receipt_data,
            'product_data' => $product_data,
            'product_type' => $product_type->product_type,
            'work_order_data' => $work_order_data,
            'receive_data' => $receive_data,
            'ready_packages' => $ready_packages,
            'finalDeliver_id' => $finalDeliver_id
        ]);
    }
    

    public function update_delivered_package(Request $request){
        //   return $request;
            DB::beginTransaction();
        try {
            
            
            for ($i=0; $i <count($request->id) ; $i++) { 

                $current=Deliver_order_details::where('id',$request->id[$i])->first();

                $total= $current->delivered_package + $request->delivered_package[$i]; 
              
                if ($total > $current->package_number) {
    
                    Flash::error('عدد الاكياس المطلوبة اكبر من العدد المتبقى');
                    return redirect()->back();
                }
    
                Deliver_order_details::where('id',$request->id[$i])
                ->update(['delivered_package'=>$total]);
             }
            
          
            $data3 = [];
            for ($i = 0; $i < count($request->delivered_package); $i++) {

                $workorder_id= Deliver_order::where('id',$request->deliver_order_id[$i])->first()->work_order_id;
                $weight_piece = WorkOrder::where('id',$workorder_id)->select('weight_piece')->first()->weight_piece;

                if (empty($request->delivered_package[$i])) {
                    // Value is empty, do nothing
                } else {
                    $data3[$i] = [
                        'final_deliver_order_id' => $request->final_deliver_order_id[$i],
                        'deliver_order_id' => $request->deliver_order_id[$i],
                        'package_number' => $request->delivered_package[$i],
                        'count' => $request->count[$i],
                        'total' => $request->delivered_package[$i] * $request->count[$i],
                        'weight' => $request->delivered_package[$i] * $request->count[$i] * $weight_piece,
                        'creator_id'=> Auth::user()->id,
                        'created_at' => now(),
                    ];
                  
                }
            }
             FinalDeliver::insert($data3);
            //  ==============================================================================
    // لحساب الكميه الجاهزه للتسليم
//              $workOrderids=Deliver_order::whereIn('id',$request->deliver_order_id)->pluck('work_order_id')->first();
//              $totalDelivered = FinalDeliver::whereIn('deliver_order_id', $request->deliver_order_id)->sum('total');        //كمية التسليم 
//              $product_count= WorkOrder::where('id',$workOrderids)->pluck('product_count')->first(); 
            
//              $readyPack= $product_count - $totalDelivered ;
//    pop 
//              if($readyPack == 0 ){
    
//                 $input['status']='closed';
//                 Deliver_order::whereIn('id',$request->deliver_order_id)->update($input);
    
//             }

                for ($x = 0; $x < count($request->deliver_order_id); $x++) {

                    $total_details=Deliver_order_details::where('deliver_order_id',$request->deliver_order_id[$x])->first();
                    // return $total_details;
                    $readyPack= $total_details->package_number - $total_details->delivered_package ;
                // return $readyPack;
                    if($readyPack == 0 ){

                        $input['status']='closed';
                        Deliver_order::where('id',$request->deliver_order_id[$x])->update($input);
                    }
                }

                // =============================== لتسجيل Log ====================================
                $work_order_ids=Deliver_order::whereIn('id',$request->deliver_order_id)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
                if(count($work_order_ids) == 1){
                    $customer_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_customer:name,id')->select('customer_id')->first();
                    $receivable_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_receivable:name,id')->select('receive_id')->first();
                    $sum_package_number=array_sum($request->delivered_package);
                    // $sum_total=array_sum($total);
    
                    $properties['اذن تسليم'] = $request->final_deliver_order_id[0];
                    $properties['امر الشغل'] = $work_order_ids[0];
                    $properties['العميل'] = $customer_name->get_customer->name;
                    $properties['جهة التسليم'] = $receivable_name->get_receivable->name;
                    $properties['عدد الاكياس'] = $sum_package_number;
                    $properties['الاجمالى'] = $total;
                   
                    activity()
                    ->performedOn(new FinalDeliver())
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'attributes' => $properties,
                        
                        ])
                    ->tap(function ($activity) use ($work_order_ids) {
                        $activity->subject_id = $work_order_ids[0];
                        $activity->save();
                    })
                    ->log('created');
                }
                
            // ================================================================================
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
                }
       
            //  return $readyPack;
             Flash::success('تم  انشاء اذن التسليم بنجاح');
            //   return redirect(route('final_deliver_orders')); 
            return redirect()->route('show_final_deliver', ['finalDeliver_id' => $request->final_deliver_order_id[0]]);        
        }
    

// ------------------------------------------طباعة اذن التسليم-------------------------------------//
    public function show_final_deliver($final_deliver_order_id)
    {
      
      //  return $final_deliver_order_id;
        // $deliverOrder = Deliver_order::with(['get_customer:name,id','get_products:name,id','get_receivable:name,id','get_final_deliver'])->where('id',$deliver_order_id)->find($deliver_order_id);
        $deliverOrder =  FinalDeliver::where('final_deliver_order_id',$final_deliver_order_id)->with(['get_deliver_order.get_customer:name,id', 'get_deliver_order.get_products:name,id','get_deliver_order.get_receivable:name,id','get_receivable_name:name,id','get_deliver_order.get_receive_receipt:model,product_type,id'])->get();
    //    return $deliverOrder;

        if (empty($deliverOrder)) {
            Flash::error('Deliver Order not found');

            return redirect(route('deliverOrders.index'));
        }

        return view('deliver_orders.print_pos')->with('deliverOrder', $deliverOrder);
    }
    
// ----------------------------------index اذن التسليم ---------------------------------------//
// public function final_deliver_orders(Request $request)
// {

//     if ($request->ajax()) {

//         $data = FinalDeliver::with([
//             'get_deliver_order.get_customer:name,id',
//             'get_deliver_order.get_products:name,id',
//             'get_deliver_order.get_receivable:name,id'
//         ])
//         ->select('final_deliver_order_id','deliver_order_id','created_at')
//         ->where('created_at', '>', date("Y-m-d", strtotime("-2 month")))
//         ->distinct()
//         ->get();

//         return Datatables::of($data)
//             ->addIndexColumn()
//             ->addColumn('action', function ($row)  {
//                 $btn = '';
//                 if (auth()->user()->can('show_final_deliver')) {
//                     $btn .= '<a href="/show_final_deliver/'.$row->final_deliver_order_id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-print fa-lg"></i></a>';
//                 }
//                 // if (auth()->user()->can('edit_final_deliver')) {
//                 //     $btn .= '<a href="/edit_final_deliver/'.$row->final_deliver_order_id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-edit fa-lg"></i></a>';
//                 // }
//                 if (auth()->user()->can('delete_final_deliver_all')) {
//                     $btn .= '<form action="/delete_final_deliver_all/' . $row->final_deliver_order_id . '" method="post" style="display:inline;">
//                         ' . csrf_field() . '
//                         ' . method_field('post') . '
//                         <input type="hidden" name="final_deliver_order_id" value="' .$row->final_deliver_order_id. '">
//                         <button type="submit" class="btn btn-link btn-danger btn-just-icon" onclick="return confirm(\'هل انت متأكد من حذف إذن التسليم؟\')">
//                             <i class="fa fa-trash fa-lg"></i>
//                         </button>
//                     </form>';
//                 }
//                 return $btn;
//             })
//             ->rawColumns(['action'])
//             ->make(true);
//     }

//     return view('deliver_orders.final_deliver_orders');
// }
// -----------------------------------انشاء اذن تسليم مجمع------------------------------//
    public function deliverOrders_finance_customers(Request $request ,$id)
    {
      
        $deliverOrders_ids = Deliver_order::with('get_details','get_customer:name,id','get_products:name,id','get_receivable:name,id')
        ->where('customer_id', $id)->where('status', 'open')
        ->where('receive_id', $request->receive_name)
        // ->whereNotIn('id', function ($query) {
        //     $query->select('deliver_order_id')
        //             ->from('final_deliver_details');
        // })
        ->get();
        
//  return $deliverOrders_ids;
        $receive_id = Receivable::pluck('name', 'id');
        
        // $start_value = 1;
        // $finalDeliver_id = $start_value;
        // while (FinalDeliver::where('final_deliver_order_id', $finalDeliver_id)->exists()) {
        //     $finalDeliver_id++;
        // }
        $finalDeliver_id = FinalDeliver::all()->last();

        if(!isset($finalDeliver_id)){
            $finalDeliver_id=1;
        }else{
            $finalDeliver_id = $finalDeliver_id->final_deliver_order_id+1;
        }
        // return $finalDeliver_id;
        return view('deliver_orders.deliverOrders_finance_customers')->with([
            'deliverOrders_ids' => $deliverOrders_ids,
            'finalDeliver_id' => $finalDeliver_id,
             'receive_id' => $receive_id
        ]);
    }

// -----------------------------------------------حفظ اذن التسليم مجمع--------------------------------------------------//
        public function update_delivered_package_all(Request $request){
            // return $request;
            try {
                DB::beginTransaction();

                for ($i=0; $i <count($request->id) ; $i++) { 
                    $current=Deliver_order_details::where('id',$request->id[$i])->first();
         
                    $total= $current->delivered_package + $request->delivered_package[$i];
                    // return $total;  
        
                    if ($total > $current->package_number) {
        
                        Flash::error('عدد الاكياس المطلوبة اكبر من العدد المتبقى');
                        return redirect()->back();
                    }
        
                    Deliver_order_details::where('id',$request->id[$i])
                    ->update(['delivered_package'=>$total]);
                 }

                 
                $data3 = [];
                for ($i = 0; $i < count($request->delivered_package); $i++) {

                    $workorder_id= Deliver_order::where('id',$request->deliver_order_id[$i])->first()->work_order_id;
                    $weight_piece = WorkOrder::where('id',$workorder_id)->select('weight_piece')->first()->weight_piece;
                    if (empty($request->delivered_package[$i])) {
                        // Value is empty, do nothing
                    } else {
                        $data3[$i] = [
                            'final_deliver_order_id' => $request->final_deliver_order_id[$i],
                            'deliver_order_id' => $request->deliver_order_id[$i],
                            'package_number' => $request->delivered_package[$i],
                            'count' => $request->count[$i],
                            'total' => $request->delivered_package[$i] * $request->count[$i],
                            'weight' => $request->delivered_package[$i] * $request->count[$i] * $weight_piece,
                            'receivable_id'=>$request->receivable_id,
                            'creator_id'=> Auth::user()->id,
                            'created_at' => now(),
                        ];
                      
                    }
                }
              //  return $data3;
                 FinalDeliver::insert($data3);
                //  ==============================================================================
        // لحساب الكميه الجاهزه للتسليم
                //  $workOrderids=Deliver_order::whereIn('id',$request->deliver_order_id)->pluck('work_order_id')->first();
                //  $totalDelivered = FinalDeliver::whereIn('deliver_order_id', $request->deliver_order_id)->sum('total');        //كمية التسليم 
                //  $product_count= WorkOrder::where('id',$workOrderids)->pluck('product_count')->first(); 
                
                //  $total_details= Deliver_order_details::whereIn('deliver_order_id',$request->deliver_order_id)->sum('total');   // كمية التغليف
       
                //  $readyPack= $total_details - $totalDelivered ;
        
                //  if($readyPack == 0 ){
        
                //     $input['status']='closed';
                //     Deliver_order::whereIn('id',$request->deliver_order_id)->update($input);
        
                // }
                for ($x = 0; $x < count($request->deliver_order_id); $x++) {

                    $total_details=Deliver_order_details::where('deliver_order_id',$request->deliver_order_id[$x])->first();
                    // return $total_details;
                    $readyPack= $total_details->package_number - $total_details->delivered_package ;
                // return $readyPack;
                    if($readyPack == 0 ){

                        $input['status']='closed';
                        Deliver_order::where('id',$request->deliver_order_id[$x])->update($input);
                    }
                }
             
                 // =============================== لتسجيل Log ====================================
                 $work_order_ids=[]; $total=0;
                for ($b=0; $b <count($request->delivered_package) ; $b++) { 
                    if($request->delivered_package[$b] == null){
                        continue;
                    }else{
                    // if($request->delivered_package[$b] != null){
                        
                        $total+=$request->delivered_package[$b] * $request->count[$b];
                        $work=Deliver_order::where('id',$request->deliver_order_id[$b])->select('work_order_id')->first();
                        if ($work && !in_array($work->work_order_id, $work_order_ids)) {
                            $work_order_ids[] = $work->work_order_id;
                        }
                        
                        
                    }
                }
                
                
                //  $work_order_ids=Deliver_order::whereIn('id',$request->deliver_order_id)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
                 if(count($work_order_ids) == 1){
                     $customer_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_customer:name,id')->select('customer_id')->first();
                     $receivable_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_receivable:name,id')->select('receive_id')->first();
                     $sum_package_number=array_sum($request->delivered_package);

                     // $sum_total=array_sum($total);
    
                     $properties['اذن تسليم'] = $request->final_deliver_order_id[0];
                     $properties['امر الشغل'] = $work_order_ids[0];
                     $properties['العميل'] = $customer_name->get_customer->name;
                     $properties['جهة التسليم'] = $receivable_name->get_receivable->name;
                     $properties['عدد الاكياس'] = $sum_package_number;
                     $properties['الاجمالى'] = $total;
                      
                     activity()
                     ->performedOn(new FinalDeliver())
                     ->causedBy(Auth::user())
                     ->withProperties([
                         'attributes' => $properties,
                           
                         ])
                     ->tap(function ($activity) use ($work_order_ids) {
                         $activity->subject_id = $work_order_ids[0];
                         $activity->save();
                     })
                     ->log('created');
 
                 }else{
           
                     $customer_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_customer:name,id')->select('customer_id')->first();
                     $receivable_name=Deliver_order::whereIn('id',$request->deliver_order_id)->with('get_receivable:name,id')->select('receive_id')->first();
                     $deliverOrderIds = collect($request->deliver_order_id)->unique()->values()->all();
 
                        //  for ($y=0; $y <count($deliverOrderIds) ; $y++) { 
                            for ($y=0; $y <count($request->delivered_package) ; $y++) { 
                                if($request->delivered_package[$y] == null){
                                    continue;
                                }else{
                                    $work_order_id= FinalDeliver::where('deliver_order_id',$request->deliver_order_id[$y])->with('get_deliver_order')->first();
                                    $sum_package_number= FinalDeliver::where('deliver_order_id',$request->deliver_order_id[$y])->sum('package_number');
                                    $total= FinalDeliver::where('deliver_order_id',$request->deliver_order_id[$y])->sum('total');
                              
                                    $properties['اذن تسليم'] = $request->final_deliver_order_id[0];
                                    $properties['امر الشغل'] = $work_order_id->get_deliver_order->work_order_id;
                                    $properties['العميل'] = $customer_name->get_customer->name;
                                    $properties['جهة التسليم'] = $receivable_name->get_receivable->name;
                                    $properties['عدد الاكياس'] = $sum_package_number;
                                    $properties['الاجمالى'] = $total;
                                
                                    activity()
                                    ->performedOn(new FinalDeliver())
                                    ->causedBy(Auth::user())
                                    ->withProperties([
                                        'attributes' => $properties,
                                        
                                        ])
                                    ->tap(function ($activity) use ($work_order_id) {
                                        $activity->subject_id = $work_order_id->get_deliver_order->work_order_id;
                                        $activity->save();
                                    })
                                    ->log('created');
                                }
                            
                         }
 
                 }
               // ================================================================================

                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
                DB::rollBack();
                    
            }
                //  return $readyPack;

                 Flash::success('تم  انشاء اذن التسليم بنجاح');
                 return redirect()->route('show_final_deliver', ['finalDeliver_id' => $request->finalDeliver_id]);
            
            }


           // -----------------------------------تعديل اذن تسليم مجمع------------------------------//
        public function edit_final_deliver($id)
        {
            $deliverOrders_ids = FinalDeliver::where('final_deliver_order_id',$id)->pluck('deliver_order_id')->toArray();
    
            $deliverOrders = Deliver_order::with('get_details','get_customer:name,id','get_products:name,id','get_receivable:name,id','get_final_deliver')
           ->whereIn('id',$deliverOrders_ids)->get();
   
            $receive_id = Receivable::pluck('name', 'id');

            return view('deliver_orders.edit_final_deliver_all')->with([
                'deliverOrders' => $deliverOrders,
                'receive_id' => $receive_id,
            ]);
        }

        // -----------------------------------------------update تحديث اذن التسليم مجمع--------------------------------------------------//
        public function update_final_deliver_all(Request $request){
                    //  return $request;
                
           try {
                DB::beginTransaction();

                for ($i=0; $i <count($request->id) ; $i++) { 

                    $current=Deliver_order_details::where('id',$request->id[$i])->first();
                        //  return $current; 

                    // $total= $current->delivered_package + $request->delivered_package[$i]; 
                    // return $total;  

                    if ($request->delivered_package[$i] > $current->package_number) {
        
                        Flash::error('عدد الاكياس المطلوبة اكبر من العدد المتبقى');
                        return redirect()->back();
                    }
        
                    Deliver_order_details::where('id',$request->id[$i])
                    ->update(['delivered_package'=>$request->delivered_package[$i]]);
                 }

                //  FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id)->delete();
                 
                $data3 = [];
                for ($z = 0; $z < count($request->delivered_package); $z++) {
                    if (!empty($request->delivered_package[$z])) {
                        $data3[] = [
                            'final_deliver_order_id' => $request->final_deliver_order_id[$z],
                            'deliver_order_id' => $request->deliver_order_id[$z],
                            'package_number' => $request->delivered_package[$z],
                            'count' => $request->count[$z],
                            'total' => $request->delivered_package[$z] * $request->count[$z],
                            'receivable_id' => $request->receivable_id,
                            'creator_id' => Auth::user()->id,
                            'created_at' => now(),
                        ];
                       
                    }
                    $ids = FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id[$z])->pluck('id');
                    FinalDeliver::whereIn('id',$ids)->delete();
                    // return $ids;

                }
                FinalDeliver::insert($data3);
         
               
        
                //  ==============================================================================
        // لحساب الكميه الجاهزه للتسليم
                for ($x = 0; $x < count($request->deliver_order_id); $x++) {

                $total_details=Deliver_order_details::where('deliver_order_id',$request->deliver_order_id[$x])->first();
                // return $total_details;
                 $readyPack= $total_details->package_number - $total_details->delivered_package ;
        
                 if($readyPack == 0 ){
        
                    $input['status']='closed';
                    Deliver_order::where('id',$request->deliver_order_id[$x])->update($input);
                }else{
                    $input['status']='open';
                    Deliver_order::where('id',$request->deliver_order_id[$x])->update($input);
        
                }
            }  
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
                //  return $readyPack;

                 Flash::success('تم  تعديل اذن التسليم المجمع بنجاح');
               return view('deliver_orders.final_deliver_orders');
            
            }

//-----------------------------------------------------------------------------------------
    public function delete_final_deliver_all(Request $request, $finalDeliver_id){
                
        $has_invoiced=FinalDeliver::where('final_deliver_order_id', $request->final_deliver_order_id)->where('flag_inovice',1)->get();

        if(count($has_invoiced)){
            Flash::error('عفوا... لايمكنك حذف الاذن لوجود فاتورة له');
            return redirect(route('final_deliver_orders'));
        }

        try {
            DB::beginTransaction();
                    
            $data2 = FinalDeliver::where('final_deliver_order_id', $request->final_deliver_order_id)
            ->select('deliver_order_id')
            ->distinct()
            ->get();
                   
                    
            for ($i=0; $i <count($data2) ; $i++) { 

                Deliver_order_details::where('deliver_order_id',$data2[$i]->deliver_order_id)->update(['delivered_package'=> 0]);

                Deliver_order::where('id',$data2[$i]->deliver_order_id)->update(['status'=> 'open']);

                // ============================================== لتسجيل Log =====================================
                $work_order_id=Deliver_order::where('id',$data2[$i]->deliver_order_id)->select('work_order_id')->first();
                $customer_name=Deliver_order::where('id',$data2[$i]->deliver_order_id)->with('get_customer:name,id')->select('customer_id')->first();
                $receivable_name=Deliver_order::where('id',$data2[$i]->deliver_order_id)->with('get_receivable:name,id')->select('receive_id')->first();
                $sum_package_number = FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id)->where('deliver_order_id',$data2[$i]->deliver_order_id)->sum('package_number');
                $sum_total = FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id)->where('deliver_order_id',$data2[$i]->deliver_order_id)->sum('total');

                $properties['اذن تسليم'] = $request->final_deliver_order_id;
                $properties['امر الشغل'] = $work_order_id->work_order_id;
                $properties['العميل'] = $customer_name->get_customer->name;
                $properties['جهة التسليم'] = $receivable_name->get_receivable->name;
                $properties['عدد الاكياس'] = $sum_package_number;
                $properties['الاجمالى'] = $sum_total;

                activity()
                ->performedOn(new FinalDeliver())
                ->causedBy(Auth::user())
                ->withProperties(['old' => $properties])
                ->tap(function ($activity) use ($work_order_id) {
                    $activity->subject_id = $work_order_id->work_order_id;
                    $activity->save();
                })
                ->log('deleted');
                // ==================================================================================================
            }

        FinalDeliver::where('final_deliver_order_id',$request->final_deliver_order_id)->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    
        Flash::success('تم  حذف اذن التسليم بنجاح');
        //  return view('deliver_orders.final_deliver_orders');
        return redirect(route('final_deliver_orders'));
    }


           
            
           
}



