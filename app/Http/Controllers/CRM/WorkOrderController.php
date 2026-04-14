<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\WorkOrderDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateWorkOrderRequest;
use App\Http\Requests\CRM\UpdateWorkOrderRequest;
use App\Repositories\CRM\WorkOrderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\CRM\Customer;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\Product;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Stage;
use App\Models\CRM\Team;
use App\Models\CRM\Activity;
use App\Models\CRM\Note;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\Deliver_order_details;
use App\Models\CRM\Place;
use App\Models\CRM\Receivable;
use App\Models\CRM\Reservation;
use App\Models\CRM\Fabric;
use App\Models\CRM\Fabric_source;
use App\Models\CRM\Service;
use App\Models\sales\Customer_details;
use Auth;

use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Spatie\Activitylog\Facades\LogActivity;


class WorkOrderController extends AppBaseController
{
    /** @var WorkOrderRepository $workOrderRepository*/
    private $workOrderRepository;

    public function __construct(WorkOrderRepository $workOrderRepo)
    {
        $this->workOrderRepository = $workOrderRepo;
    }
    
    /**
     * Display a listing of the WorkOrder.
     *
     * @param WorkOrderDataTable $workOrderDataTable
     *
     * @return Response
     */
    public function index(WorkOrderDataTable $workOrderDataTable)
    {
        $important=WorkOrder::where('priority',1)->count();
        return $workOrderDataTable->render('work_orders.index',['important'=>$important]);

    }

    /**
     * Show the form for creating a new WorkOrder.
     *
     * @return Response
     */
    public function create($receiveReceipt_id=null,$customer_id=null,$product_id=null)
    {
    
        $redirect='';
        if($receiveReceipt_id && $customer_id && $product_id){
            $redirect='true';
            $customer_data = Customer::where('id',$customer_id)->pluck('name','id');
            $receipt_data = ReceiveReceipt::where('id',$receiveReceipt_id)->pluck('id','id');
            $data = ReceiveReceipt::where('id',$receiveReceipt_id)->find($receiveReceipt_id);
            $product_data = Product::where('id',$product_id)->pluck('name','id');
            $service_items=ServiceItem::select('id','name')->get();
            $notes = Note::pluck('note','id');
            $places = Place::pluck('name','id');
            $receivables = ReceiveReceipt::with('get_receivables')->where('id',$receiveReceipt_id)->first();
            // $old_work_orders= WorkOrder::where('customer_id',$customer_id)->pluck('id','id');
            $old_work_orders= WorkOrder::pluck('id','id');
            $total_initial_count = WorkOrder::where('receive_receipt_id',$receiveReceipt_id)->sum('initial_product_count');

            $remaining = $data->initial_count - $total_initial_count;
        //    return $receipt_data->id;
           
            $fabric_sources =Fabric_source::pluck('name','id');
            $fabrics =Fabric::pluck('name','id');

            return view('work_orders.create')->with([
                'redirect'=>$redirect,
                'receipt_data'=>$receipt_data,
                'customer_data'=>$customer_data,
                'product_data'=>$product_data ,
                'product_type'=>$data->product_type ,
                'service_items'=>$service_items,
                'notes'=>$notes,
                'places'=>$places,
                'receivables'=>$receivables,
                'remaining'=>$remaining,
                'old_work_orders'=>$old_work_orders,
                'fabric_sources'=>$fabric_sources,
                'fabrics'=>$fabrics,
                ]);
        }else{
            $customers = Customer::pluck('name','id');
            $receipts = ReceiveReceipt::pluck('id','id');
            $products = Product::pluck('name','id');
            $service_items=ServiceItem::select('id','name')->get();
            $notes = Note::all();
            $places = Place::pluck('name','id');
            $receivables = Receivable::pluck('name','id');
            $fabric_sources =Fabric_source::pluck('name','id');
            $fabrics =Fabric::pluck('name','id');
    
            return view('work_orders.create')->with(['customers'=>$customers,'receipts'=>$receipts,'products'=>$products , 'service_items'=>$service_items , 'notes'=>$notes , 'places'=>$places , 'receivables'=>$receivables , 'remaining'=>$remaining, 'fabric_sources'=>$fabric_sources,
            'fabrics'=>$fabrics, ]);

        }
   
  
    
    }

    /**
     * Store a newly created WorkOrder in storage.
     *
     * @param CreateWorkOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrderRequest $request)
    {
        // return $request;
// return $request->all();
        $totalFinalCount = WorkOrder::where('receive_receipt_id',$request->receive_receipt_id)->sum('initial_product_count');
        $totalFinalCount2 = ReceiveReceipt::where('id',$request->receive_receipt_id)->sum('initial_count');
        if (($totalFinalCount + $request->initial_product_count) <= $totalFinalCount2) {

        try {
            DB::beginTransaction();

            if(isset($request->reservation_id)){
                Reservation::where('id',$request->reservation_id)->update(['status'=>'closed']);
            }

            $creator_id = Auth::user()->id;
            $creator_team_id = Auth::user()->team_id;
            $input = $request->all();

            $input['creator_team_id'] = $creator_team_id;
            $input['creator_id'] = $creator_id;
            $input['status'] = 'open';
            $input['product_count'] = '0';
            $input['product_weight'] = '0';
            $input['barcode'] = rand(1234567890,50);
            $input['is_production'] = 0;

            $workOrder = $this->workOrderRepository->create($input);
            ReceiveReceipt::where('id',$request->receive_receipt_id)->update(['is_workOreder'=>'مضاف']);

            // $modelnumber =ReceiveReceipt::where('id',$request->receive_receipt_id)->first();
            // if(isset($modelnumber)){
            //     $ids=Dyeing_receive::where('model',$modelnumber)->pluck('id')->toArray();
            //     if(count($ids)){
                    
            //     }
            // }
            
            $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id)->pluck('id')->toArray();
            $services_name =ServiceItem::whereIn('id',$request->service_item_id)->select('name')->distinct()->pluck('name')->toArray();
            $workOrder->get_work_order_stage()->attach($serviceItemSatges);
           
            activity()
            ->performedOn(new Work_order_stage())
            ->causedBy(Auth::user())
            ->withProperties([
                'attributes' => $services_name
            ])
            ->tap(function ($activity) use ($workOrder) {
                $activity->subject_id = $workOrder->id; 
                $activity->save();
            })
            ->log('created');

            if($request->note){
                Note::create([
                    'creator_id'=>Auth::user()->id,
                    'creator_team_id'=>Auth::user()->team_id,
                    'note'=>$request->note,
                    'work_order_id'=>$workOrder->id,
                ]);

                activity()
                ->performedOn(new Note())
                ->causedBy(Auth::user())
                ->withProperties([
                    'attributes' => [$request->note],
                ])
                ->tap(function ($activity) use ($workOrder) {
                    $activity->subject_id = $workOrder->id; 
                    $activity->save();
                })
                ->log('created');
            }
            // ========================
            $input=[];
            $input['creator_id']= Auth::user()->id;
            $input['creator_team_id']= Auth::user()->team_id;
            $input['status']= 'open';
            $input['owner_stage_id']= 48;
            $input['work_order_id']=$workOrder->id ;
            Activity::create($input);
            // ==========================

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
    
            if(isset($request->redirect)){
                return redirect('get_work_order/'.$request->receive_receipt_id.'/'.$request->customer_id);
            }
        }
if(Auth::user()->team_id == 3 ||Auth::user()->team_id == 15){
        if(!isset($request->save_print)){
        Flash::success('تنبيه...تم حفظ الغسلة بنجاح');

        return redirect('get_work_order/'.$request->receive_receipt_id.'/'.$request->customer_id);    
    }else{
    //    ============================================
             return redirect('workOrders_print/'. $workOrder->id);
        }
    }else{
        if(!isset($request->save_print)){
            Flash::success('تنبيه...تم حفظ الغسلة بنجاح');
    
            return redirect('get_work_order/'.$request->receive_receipt_id.'/'.$request->customer_id);    
        }else{
        //    ============================================
                 return redirect('workOrders_print_cs/'. $workOrder->id);
            }
    }

    }else{
        Flash::error('عفوآ...لا يمكن انشاء غسلة اضافية , الكمية المستلمة غير كافية');

        return redirect('get_work_order/'.$request->receive_receipt_id.'/'.$request->customer_id);    
    }

    }


    /**
     * Display the specified WorkOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $stages = Stage::all();
        $workOrder = WorkOrder::with(['get_customer:name,id','get_products:name,id','get_user','get_work_order_stage','get_closer:name,id','get_receivables','get_places','get_ReceiveReceipt'])->find($id);
        $temp = json_decode($workOrder->get_ReceiveReceipt->img);

        $creator_team = Team::where('id',$workOrder->creator_team_id)->first();
        $workOrder->get_user->creator_team=$creator_team->name;
        $closed_team = Team::where('id',$workOrder->closed_team_id)->first();
        if($closed_team){
        $workOrder->get_closer->closed_team=$closed_team->name;
        }
        $notes = Note::with(['get_user:name,id','get_team:name,id'])->where('work_order_id',$id)->get();
        $work_order_stages = Work_order_stage::with(['get_work_order_stage:name,id','get_work_order_service:name,id'])->where('work_order_id',$id)->get();
        $follows = Activity::with(['get_user:name,id','get_team:name,id','get_owner:name,id','get_user_closed:name,id','get_team_closed:name,id'])->where('work_order_id',$id)->get();
        return view('work_orders.show')->with(['workOrder'=> $workOrder,'stages'=>$stages ,'notes'=>$notes , 'work_order_stages'=>$work_order_stages,'follows'=>$follows,'temp'=>$temp]);
    }

    /**
     * Show the form for editing the specified WorkOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $has_deliverorder=Deliver_order::where('work_order_id',$id)->get();
        if(!count($has_deliverorder) || Auth::user()->team_id == 13){

            $has_activity=Activity::where('work_order_id',$id)->get();
            if(count($has_activity)==1 || !count($has_activity) || Auth::user()->team_id == 2 || Auth::user()->team_id == 8 || Auth::user()->team_id == 1 || Auth::user()->team_id == 13){
            
           
            $workOrder = $this->workOrderRepository->find($id);


            if(Auth::user()->team_id==2 || Auth::user()->team_id==4){
                $note = Note::where('work_order_id',$id)->whereIn('creator_team_id',[2,4])->first(); 
            }else{
                $note = Note::where('work_order_id',$id)->where('creator_team_id',Auth::user()->team_id)->first(); 
            }
            
            $workOrder->note = $note;
        
        if( $workOrder->status == 'closed' && Auth::user()->team_id != 8 && Auth::user()->team_id != 1 && Auth::user()->team_id != 13 ){
            Flash::error('عفوآ...لا يمكن تعديل غسلة تم تنفيذها');
         
            return redirect(route('workOrders.index'));
        }

        $old_work_orders= WorkOrder::pluck('id','id');
        $customers = Customer::pluck('name','id');
        $receivables = ReceiveReceipt::with('get_receivables')->where('id',$workOrder->receive_receipt_id)->first();
        $receipts = ReceiveReceipt::pluck('id','id');
        $product_type = ReceiveReceipt::where('id',$workOrder->receive_receipt_id)->select('product_type')->first();
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();
        $service_item_ids = Work_order_stage::where('work_order_id',$id)->pluck('service_item_satge_id')->toArray();
        $selectedservice_id = ServiceItemSatge::whereIn('id',$service_item_ids)->distinct()->pluck('service_item_id')->toArray();
    //    $selectedservice=ServiceItem::whereIn('id',$selectedservice_id)->pluck('name','id')->toArray();
        $selectedservice=ServiceItem::whereIn('id',$selectedservice_id)->orderByRaw('FIELD(id, ' . implode(',', $selectedservice_id) . ')')->pluck('name','id')->toArray();
        $places = Place::pluck('name','id');

        $fabric_sources =Fabric_source::pluck('name','id');
        $fabrics =Fabric::pluck('name','id');

        //$receivables = Receivable::pluck('name','id');
 // return $workOrder;
        return view('work_orders.edit')
        ->with([
            'receivables'=>$receivables,
            'workOrder'=> $workOrder,
            'customers'=>$customers,
            'receipts'=>$receipts,
            'products'=>$products , 
            'product_type'=>$product_type , 
            'service_items'=>$service_items ,
             'selectedservice'=>$selectedservice ,
              'places'=>$places ,
               'receivables'=>$receivables,
               'old_work_orders'=>$old_work_orders,
               'fabric_sources'=>$fabric_sources,
               'fabrics'=>$fabrics,
            ]);
            
            }else{
                Flash::error('عفوآ...لا يمكن تعديل غسلة  قيد التنفيذ');
                return redirect(route('workOrders.index'));
            }
        }else{
                Flash::error('عفوآ...لا يمكن تعديل غسلة  تم تغليفها');
                return redirect(route('workOrders.index'));
            }
    }


    /**
     * Update the specified WorkOrder in storage.
     *
     * @param int $id
     * @param UpdateWorkOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
   
        // return $request;
        $workOrder = $this->workOrderRepository->find($id);

        if((Auth::user()->team_id == 3||Auth::user()->team_id == 15) && $request->service_item_id_trail){
            $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id_trail)->pluck('id')->toArray();
            $check= Work_order_stage::where('work_order_id',$id)->whereIn('service_item_satge_id',$serviceItemSatges)->get();
           if(!count($check)){
            $services_name = ServiceItem::whereIn('id', $request->service_item_id_trail)->select('name')->distinct()->pluck('name')->toArray();
            $old_service_item_satge_ids = $workOrder->get_work_order_stage()->pluck('service_item_satge_id')->toArray();
            $old_service_items_ids= ServiceItemSatge::whereIn('id',$old_service_item_satge_ids)->select('service_item_id')->distinct()->pluck('service_item_id')->toArray();
            $oldStages=ServiceItem::whereIn('id', $old_service_items_ids)->select('name')->distinct()->pluck('name')->toArray();
            $workOrder->get_work_order_stage()->attach($serviceItemSatges);

            $new_service_item_satge_ids = $workOrder->get_work_order_stage()->pluck('service_item_satge_id')->toArray();
            $new_service_items_ids= ServiceItemSatge::whereIn('id',$new_service_item_satge_ids)->select('service_item_id')->distinct()->pluck('service_item_id')->toArray();
            $newStages=ServiceItem::whereIn('id', $new_service_items_ids)->select('name')->distinct()->pluck('name')->toArray();
            $addedStages = array_diff($newStages, $oldStages);
            $removedStages = array_diff($oldStages, $newStages);

            $addedStages = $addedStages ?: null; 
            $removedStages = $removedStages ?: null; 
            $newStages = $newStages ?: null;
            if ($addedStages) {
                $properties['added'] = $addedStages;
            }
            if ($removedStages) {
                $properties['removed'] = $removedStages;
            }
            $properties['current'] = $newStages;
            
            activity()
            ->performedOn(new Work_order_stage())
            ->causedBy(Auth::user())
            ->withProperties($properties)
            ->tap(function ($activity) use ($workOrder) {
                $activity->subject_id = $workOrder->id;
                $activity->save();
            })
            ->log('updated');
           }
        }
    
      

        if (empty($workOrder)) {

            Flash::error('عفوآ...لم يتم العثور على الغسلة');
            return redirect(route('workOrders.index'));
        }

        if(!empty($request->service_item_id)) {
            $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id)->pluck('id')->toArray();

            $services_name = ServiceItem::whereIn('id', $request->service_item_id)->select('name')->distinct()->pluck('name')->toArray();
            $old_service_item_satge_ids = $workOrder->get_work_order_stage()->pluck('service_item_satge_id')->toArray();
            $old_service_items_ids= ServiceItemSatge::whereIn('id',$old_service_item_satge_ids)->select('service_item_id')->distinct()->pluck('service_item_id')->toArray();
            $oldStages=ServiceItem::whereIn('id', $old_service_items_ids)->select('name')->distinct()->pluck('name')->toArray();

            $workOrder->get_work_order_stage()->sync($serviceItemSatges);

            $new_service_item_satge_ids = $workOrder->get_work_order_stage()->pluck('service_item_satge_id')->toArray();
            $new_service_items_ids= ServiceItemSatge::whereIn('id',$new_service_item_satge_ids)->select('service_item_id')->distinct()->pluck('service_item_id')->toArray();
            $newStages=ServiceItem::whereIn('id', $new_service_items_ids)->select('name')->distinct()->pluck('name')->toArray();
            $addedStages = array_diff($newStages, $oldStages);
            $removedStages = array_diff($oldStages, $newStages);

            $addedStages = $addedStages ?: null; 
            $removedStages = $removedStages ?: null; 
            $newStages = $newStages ?: null;
            if ($addedStages) {
                $properties['added'] = $addedStages;
            }
            if ($removedStages) {
                $properties['removed'] = $removedStages;
            }
            $properties['current'] = $newStages;

            activity()
            ->performedOn(new Work_order_stage())
            ->causedBy(Auth::user())
            ->withProperties($properties)
            ->tap(function ($activity) use ($workOrder) {
                $activity->subject_id = $workOrder->id;
                $activity->save();
            })
            ->log('updated');
        }    




        if($request->note){
            if(Auth::user()->team_id == 2 || Auth::user()->team_id == 4){
                $check =Note::whereIn('creator_team_id',[2,4])->where('work_order_id',$id)->first(); 
            }else{
                $check =Note::where('creator_team_id',Auth::user()->team_id)->where('work_order_id',$id)->first(); 
            }
            
            $current=Note::where('work_order_id',$id)->first(); 
            if($check){
                Note::where('id',$request->note_id)->update([
                    'updated_by'=>Auth::user()->id,
                    'updated_by_team'=>Auth::user()->team_id,
                    'note'=>$request->note,
                ]);

                $current=Note::where('work_order_id',$id)->first(); 
         
                $checkNotes = $check->note ? explode(' / ', $check->note) : [];
                $requestNotes = $request->note ? explode(' / ', $request->note) : [];
                $currentNotes = $current->note ? explode(' / ', $current->note) : [];

                $removedNote = array_diff($currentNotes, $requestNotes);
                $addedNote = array_diff($requestNotes, $currentNotes);

                if ($addedNote) {
                    $properties['added'] = $addedNote;
                }
                if ($removedNote) {
                    $properties['removed'] = $removedNote;
                }
                $properties['current'] = $currentNotes;
                activity()
                ->performedOn(new Note())
                ->causedBy(Auth::user())
                ->withProperties($properties)
                ->tap(function ($activity) use ($workOrder) {
                    $activity->subject_id = $workOrder->id;
                    $activity->save();
                })
                ->log('updated');

            }else{
                Note::create([
                    'creator_id'=>Auth::user()->id,
                    'creator_team_id'=>Auth::user()->team_id,
                    'note'=>$request->note,
                    'work_order_id'=>$workOrder->id,
                ]);

                activity()
                ->performedOn(new Note())
                ->causedBy(Auth::user())
                ->withProperties([
                    'attributes' => [$request->note]
                ])
                ->tap(function ($activity) use ($workOrder) {
                    $activity->subject_id = $workOrder->id;
                    $activity->save();
                })
                ->log('created');
            }
        }


        
    
        
        $workOrder = $this->workOrderRepository->update($request->all(), $id);
// return $workOrder;
        if($workOrder->product_weight > 0 || $workOrder->product_count > 0){
            $weight_piece = $workOrder->product_weight / $workOrder->product_count;
            $workOrder->update(['weight_piece'=>$weight_piece]);
        }

        $total_count = WorkOrder::where('receive_receipt_id' , $request->receive_receipt_id)->sum('product_count');
        $total_weight = WorkOrder::where('receive_receipt_id' , $request->receive_receipt_id)->sum('product_weight');
        ReceiveReceipt::where('id',$request->receive_receipt_id)->update(['final_count'=>$total_count,'final_weight'=>$total_weight]);
        // ==================

        if(Auth::user()->team_id == 3||Auth::user()->team_id == 15){
            Activity::where('work_order_id',$id)->update([
                'status'=>'closed',
                'closed_by_id'=>Auth::user()->id,
                'closed_team_id'=>Auth::user()->team_id,
            ]);

        }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
        // ==================
    if(Auth::user()->team_id == 3||Auth::user()->team_id == 15) {
        if(!isset($request->save_print)){
        Flash::success('تنبيه...تم تعديل الغسلة بنجاح');

        return redirect(route('workOrders.index'));
        }else{
        //    ============================================
                 return redirect('workOrders_print/'. $workOrder->id);
            }
    }else{
        if(!isset($request->save_print)){
        Flash::success('تنبيه...تم تعديل الغسلة بنجاح');
        
        return redirect(route('workOrders.index'));
        }else{
        //    ============================================
                return redirect('workOrders_print_cs/'. $workOrder->id);
            } 
    }   
}

    /**
     * Remove the specified WorkOrder from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $check_deliver=Deliver_order::where('work_order_id',$id)->get();
        if(count($check_deliver)){
            Flash::error('لا يمكن حذف غسلة تم تغليفها');
            return redirect(route('workOrders.index'));
        }
        $check_activity=Activity::where('work_order_id',$id)->get();
        if(count($check_activity) > 1){
                
            Flash::error('لا يمكن حذف غسلة داخل الانتاج');
            return redirect(route('workOrders.index'));
        }
       

        try {
            DB::beginTransaction();

        $workOrder = $this->workOrderRepository->find($id);

        if (empty($workOrder)) {
            Flash::error('عفوآ...لم يتم العثور على الغسلة');
            return redirect(route('workOrders.index'));
        }

        if($workOrder->product_count > 0 || $workOrder->product_weight > 0 ){
            $receive_receipt= ReceiveReceipt::where('id',$workOrder->receive_receipt_id)->first();

            // لجب المتبقى من كمية التسليم

            $deliver_order_id = Deliver_order::where('work_order_id',$workOrder->id)->pluck('id');                         //id بتاع اذن التغليف فى جدول التغليف
            $totalDelivered = Deliver_order_details::whereIn('deliver_order_id', $deliver_order_id)->sum('total');        // مجموع الاجمالى الخاص برقم امر التغليف
            $remaining = $receive_receipt->final_count - $totalDelivered;                                                             // الفرق مابين اجمالى اذن الاستلام والمغلف
            $net_final_count=$receive_receipt->final_count -  $workOrder->product_count;
            $final_remaining = $remaining - $workOrder->product_count;                                                    //الكمية المتبقية بعد الحذف
            
            if( $totalDelivered > 0 && $final_remaining < 0 ){
                Flash::error('عفوآ...لايمكن حذف الغسلة حيث ان الكمية المتبقية لا تسمح');
                return redirect(route('workOrders.index'));
            }else{
                ReceiveReceipt::where('id',$workOrder->receive_receipt_id)->update([
                    'final_count'=>$receive_receipt->final_count -  $workOrder->product_count,
                    'final_weight'=>$receive_receipt->final_weight -  $workOrder->product_weight,
                ]);
            }
            
        }

            $this->workOrderRepository->delete($id);
            Work_order_stage::where('work_order_id',$id)->delete();

            $check_is_workOreder= WorkOrder::where('receive_receipt_id',$workOrder->receive_receipt_id)->get();
            if(!count($check_is_workOreder)){
                ReceiveReceipt::where('id',$workOrder->receive_receipt_id)->update(['is_workOreder'=>'غير مضاف']);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
            Flash::success('تنبيه...تم حذف الغسلة بنجاح');
            return redirect(route('workOrders.index'));
    // }

       
    }

    public function add_not(Request $request){
        
        if(!isset($request->note)){
            return \Redirect::back()->withErrors(['msg' => 'عفوا ... يجب اضافة ملحوظة']);
        }

        $creator_id = Auth::user()->id;
        $creator_team_id = Auth::user()->team_id;
        $input = $request->all();
        $input['creator_id']=$creator_id ;
        $input['creator_team_id']= $creator_team_id;
        Note::create($input);

        // ============================================ لتسجيل Log ====================================
        activity()
        ->performedOn(new Note())
        ->causedBy(Auth::user())
        ->withProperties([
            'attributes' => [$request->note]
        ])
        ->tap(function ($activity) use ($request) {
            $activity->subject_id = $request->work_order_id;
            $activity->save();
        })
        ->log('created');
        // =============================================================================================

        return redirect()->back();
    }

    public function close_work_order($id){
        
        $check=Activity::where('work_order_id',$id)->where('status','open')->get();
        if(count($check)>0){
            return \Redirect::back()->withErrors(['msg' => 'لايمكن اغلاق الغسلة لوجود مراحل قيد التنفيذ']);
        }
        $closed_by_id = Auth::user()->id;
        $closed_team_id = Auth::user()->team_id;
        $input['closed_by_id']=$closed_by_id ;
        $input['closed_team_id']= $closed_team_id;
        $input['status']='closed';
        $input['priority']='2';
        $get_receipt_id = WorkOrder::where('id',$id)->update($input);

        $workOrder = $this->workOrderRepository->find($id);
        $check_receipt_status = WorkOrder::where('receive_receipt_id',$workOrder->receive_receipt_id)->where('status','open')->pluck('id','status');
        // return $check_receipt_status;
        if(count($check_receipt_status)<1){
            ReceiveReceipt::where('id',$workOrder->receive_receipt_id)->update(['status'=>'closed']);
        }
        
        // ============================================ لتسجيل Log ====================================
        activity()
        ->performedOn(new WorkOrder())
        ->causedBy(Auth::user())
        ->withProperties([
          'attributes' => ['تم اغلاق الغسلة']
        ])
        ->tap(function ($activity) use ($id) {
            $activity->subject_id = $id;
            $activity->save();
        })
        ->log('created');
      // =============================================================================================
        return redirect()->back();
    }

    public function add_activity(Request $request){
        $creator_id = Auth::user()->id;
        $creator_team_id = Auth::user()->team_id;
        $input = $request->all();
        $input['creator_id']=$creator_id ;
        $input['creator_team_id']= $creator_team_id;
        $input['status']= 'open';
        Activity::create($input);
        
        $check_first = Activity::where('work_order_id',$request->work_order_id)->where('status','open')->get();
        if(count($check_first)>1){
            $activity_id = Activity::where('work_order_id',$request->work_order_id)->where('status','open')->first();
            $this->close_activity($activity_id->id,$activity_id->owner_stage_id,$request->work_order_id);
        }
        WorkOrder::where('id',$request->work_order_id)->update(['is_production'=>1]);
        return redirect()->back();
    }

    public function close_activity($id,$owner_stage_id,$work_order_id){
       $ids= Work_order_stage::where('work_order_id',$work_order_id)->pluck('service_item_satge_id');

       $service_item_stage_id= ServiceItemSatge::where('satge_id',$owner_stage_id)
       ->whereIn('id',$ids)->pluck('id')->toArray();

       if($service_item_stage_id){
       $result=Work_order_stage::where('work_order_id',$work_order_id)
       ->whereIn('service_item_satge_id',$service_item_stage_id)
       ->where('status','open')
       ->first();
        if($result){
            $result->update(['status'=>'closed']);
        }
       }
        $closed_by_id = Auth::user()->id;
        $closed_team_id = Auth::user()->team_id;
        $input['closed_by_id']=$closed_by_id ;
        $input['closed_team_id']= $closed_team_id;
        $input['status']='closed';
        Activity::where('id',$id)->update($input);
        return redirect()->back(); 
    }

    public function delete_activity($id,$owner_stage_id,$work_order_id){
       $ids= Work_order_stage::where('work_order_id',$work_order_id)->pluck('service_item_satge_id');

       $service_item_stage_id= ServiceItemSatge::where('satge_id',$owner_stage_id)
       ->whereIn('id',$ids)->pluck('id')->toArray();

       if($service_item_stage_id){
       $result=Work_order_stage::where('work_order_id',$work_order_id)
       ->whereIn('service_item_satge_id',$service_item_stage_id)
       ->where('status','closed')
       ->latest()
       ->first();
        if($result){
            $result->update(['status'=>'open']);
        }
       }
        Activity::where('id',$id)->delete();
        return redirect()->back(); 
    }

    // public function workOrders_print($id){
    //     $workOrder = WorkOrder::with(['get_customer:name,id','get_products:name,id','get_note','get_ReceiveReceipt'])->find($id);
        
    //     $work_order_services = Work_order_stage::with(['get_work_order_stage:name,id','get_work_order_service.get_category.get_category'])->where('work_order_id',$id)->get();
    // //    return $work_order_services;
    //     $temp=json_decode($workOrder->get_ReceiveReceipt->img);
    //     return view('work_orders.print')->with(['workOrder'=> $workOrder,'work_order_services'=>$work_order_services,'temp'=>$temp]);
    // }

    public function workOrders_print($id)
{
    $workOrder = WorkOrder::with(['get_customer:name,id','get_products:name,id','get_note','get_ReceiveReceipt','get_receivables'])->find($id);
    $note_for_updated_cs= Note::where('work_order_id',$id)->whereIn('updated_by_team',[2,4])->first();
    // return $note_for_updated_cs;
    $work_order_services = Work_order_stage::with(['get_work_order_stage:name,id','get_work_order_service.get_category.get_category'])->where('work_order_id', $id)->get();
// return $work_order_services;
    $price = 0;
    $check=[];
    foreach ($work_order_services as $service) {
        foreach ($service->get_work_order_service as $work_order_service) {
            
            if(in_array($work_order_service->id,$check)){

            }else{
                array_push($check , $work_order_service->id);
                $price += $work_order_service->price;
            }
        }
      
    }
    $temp = json_decode($workOrder->get_ReceiveReceipt->img);

    // =======================================  لمعرفة عدد الغسلات وترتيبهم ==============================================
    $count_work_orders = WorkOrder::where('receive_receipt_id' , $workOrder->receive_receipt_id)->count('id');
    $work_orders= WorkOrder::where('receive_receipt_id' , $workOrder->receive_receipt_id)->pluck('id')->toArray();
    $work_orders = array_combine(range(1, count($work_orders)), $work_orders);
    $index = array_search($id, $work_orders);     
    // =======================================  لمعرفة عدد الغسلات وترتيبهم ==============================================

    if(Auth::user()->team_id == 3||Auth::user()->team_id == 15){
    return view('work_orders.print')->with([
        'workOrder' => $workOrder,
        'work_order_services' => $work_order_services,
        'price' => $price,
        'temp' => $temp,
        'count_work_orders' => $count_work_orders,
        'index' => $index,
    ]);
    }else{
        return view('work_orders.print_cs')->with([
            'workOrder' => $workOrder,
            'note_for_updated_cs' => $note_for_updated_cs,
            'work_order_services' => $work_order_services,
            'price' => $price,
            'temp' => $temp
        ]);
    }
}

public function get_old_order_stages(Request $request){
// return $request->order_id;
$work_order_stage_ids=Work_order_stage::where('work_order_id',$request->order_id)->pluck('service_item_satge_id');
$test=ServiceItemSatge::whereIn('id',$work_order_stage_ids)->pluck('service_item_id')->toArray();;
$test=array_unique($test);
$x=ServiceItem::whereIn('id',$test)->get();
return $x;
}


public function important_workOrders($id){

    $workOrder = $this->workOrderRepository->find($id);
    if( $workOrder->status == 'closed'){
        Flash::error('عفوآ...لا يمكن استعجال غسلة تم تنفيذها');
        return redirect()->back();      
        // return redirect(route('workOrders.index'));
    }

    WorkOrder::where('id',$id)->update(['priority'=>1]);
    return redirect()->back();
}
public function get_important(){

    $important=WorkOrder::
    with([
        'get_customer:name,id',
        'get_products:name,id',
        'get_work_order_stage.get_service_item',
        'get_places:name,id',
        'get_ReceiveReceipt:id,id',
        'get_activity.get_owner',
        'get_receivables:name,id'

        
    ])->where('priority',1)->get();

    return view('crm_views.get_important')->with(['important'=>$important]);
}

public function open_work_order($id){
    
    $has_deliverorder=Deliver_order::where('work_order_id',$id)->get();
    if(count($has_deliverorder)>0){
        return \Redirect::back()->withErrors(['msg' => 'لايمكن اعادة فتح الغسلة لوجود لها اذن تغليف ']);
    }
    $input['status']='open';
    WorkOrder::where('id',$id)->update($input);

    return redirect()->back();



    // $work_order_count = WorkOrder::where('id',$id)->sum('product_count');
    // $has_deliverorder=Deliver_order::where('work_order_id',$id)->with('get_details')->get();
    // $totalSum = $has_deliverorder->pluck('get_details')->flatten()->sum('total');
    // // return $totalSum;
    // if($totalSum >= $work_order_count){
    //     return \Redirect::back()->withErrors(['msg' => 'لايمكن اعادة فتح الغسلة  تم تغليف كل كميتها ']);
    // }
    // $input['status']='open';
    // WorkOrder::where('id',$id)->update($input);

    // return redirect()->back();
}

}
