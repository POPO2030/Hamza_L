<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ReceiveReceiptDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateReceiveReceiptRequest;
use App\Http\Requests\CRM\UpdateReceiveReceiptRequest;
use App\Repositories\CRM\ReceiveReceiptRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Traits\UploadTrait;
use App\Models\CRM\Product;
use App\Models\CRM\Customer;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Receivable;
use App\Models\CRM\Dyeing_receive;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ReceiveReceiptController extends AppBaseController
{
    use UploadTrait;
    /** @var ReceiveReceiptRepository $receiveReceiptRepository*/
    private $receiveReceiptRepository;

    public function __construct(ReceiveReceiptRepository $receiveReceiptRepo)
    {
        $this->receiveReceiptRepository = $receiveReceiptRepo;
    }

    /**
     * Display a listing of the ReceiveReceipt.
     *
     * @param ReceiveReceiptDataTable $receiveReceiptDataTable
     *
     * @return Response
     */
    public function index(ReceiveReceiptDataTable $receiveReceiptDataTable)
    {
        return $receiveReceiptDataTable->render('receive_receipts.index');
    }

    /**
     * Show the form for creating a new ReceiveReceipt.
     *
     * @return Response
     */
    public function create($id=null)
    {
        $redirect='';
        if($id){
            $redirect='true';
            $products = Product::pluck('name','id');
            $receivables = Receivable::pluck('name','id');
            $customer_data = Customer::where('id',$id)->pluck('name','id');
            return view('receive_receipts.create')->with(['products'=>$products,'customer_data'=>$customer_data,'redirect'=>$redirect,'receivables'=>$receivables]);
        }else{
            $products = Product::pluck('name','id');
            $customers = Customer::pluck('name','id');
            $receivables = Receivable::pluck('name','id');
            return view('receive_receipts.create')
            ->with([
                'products'=>$products,
                'customers'=>$customers,
                'receivables'=>$receivables
            ]);
        }

    }

    /**
     * Store a newly created ReceiveReceipt in storage.
     *
     * @param CreateReceiveReceiptRequest $request
     *
     * @return Response
     */
    public function store(CreateReceiveReceiptRequest $request)
    {
        // $ids = explode(',',$request->dyeing_receives_id);
        // return $ids[0];
        //   return $request;
        $input = $request->all();
    
        // --------------uplaod file-------
        if($request->img){
            $imgs=[];
            for ($i=0; $i <count($request->img) ; $i++) { 
                $file_name=$this->upload_file($request->img[$i],'uploads/receive_receipt/',$i);
                array_push($imgs,'uploads/receive_receipt/'.$file_name);
            }
            //return $imgs;
        // --------------uplaod file-------
        $input['img'] = json_encode($imgs);
        $input['status'] = 'open';
        $input['is_workOreder'] = 'غير مضاف';
        $input['creator_id']= Auth::user()->id;
        $receiveReceipt = $this->receiveReceiptRepository->create($input);
        
        if($request->dyeing_receives_id){

            $ids = explode(',',$request->dyeing_receives_id);
            for ($i=0; $i <count($ids) ; $i++) { 
                Dyeing_receive::where('dyeing_requests_id',$ids[$i])->update(['status'=>'received']);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/dyeing_requests/{$ids[$i]}");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
            }
            // $id=$request->unique_key;
            // return $server_output;
            if($server_output){
                Flash::success('تنبيه...تم إنشاء اذن الاضافة بنجاح ');
                return redirect(route('receiveReceipts.index'));
                // return redirect(route('receiveReceipts.index'))->with('success', trans('تنبيه...تم إنشاء اذن الاضافة بنجاح'));
            }else{
                Flash::error('تنبيه...تم إنشاء اذن الاضافة ');
                return redirect(route('receiveReceipts.index'));
                // return redirect(route('receiveReceipts.index'))->with('error', trans('عفوآ...حدث خطأ تم تعديل اذن التسليم و لم  يتم الارسال للمغسله'));
            }
        }
        
        }else{
            $input['status'] = 'open';
            $input['is_workOreder'] = 'غير مضاف';
            $input['creator_id']= Auth::user()->id;
           $receiveReceipt = $this->receiveReceiptRepository->create($input);

            if($request->dyeing_receives_id){
                
                $ids = explode(',',$request->dyeing_receives_id);
                for ($i=0; $i <count($ids) ; $i++) { 
                    Dyeing_receive::where('dyeing_requests_id',$ids[$i])->update(['status'=>'received']);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/dyeing_requests/{$ids[$i]}");
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $server_output = curl_exec($ch);
                    curl_close($ch);
                }
                // $id=$request->unique_key;
                // return $server_output;
                if($server_output){
                    Flash::success('تنبيه...تم إنشاء اذن الاضافة بنجاح');
                    return redirect(route('receiveReceipts.index'));
                }else{
                    Flash::error('تنبيه...تم إنشاء اذن الاضافة بنجاح');
                    return redirect(route('receiveReceipts.index'));
                }
            }
        }

        if(isset($request->redirect)){
            return redirect('get_receive_receipt/'.$request->customer_id);
        }

        Flash::success('تم إنشاء اذن الاضافة بنجاح');
        return redirect(route('receiveReceipts.index'));
    }


    /**
     * Display the specified ReceiveReceipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $receiveReceipt = $this->receiveReceiptRepository->find($id);

        if (empty($receiveReceipt)) {
            Flash::error('اذن الاضافة غير موجود');

            return redirect(route('receiveReceipts.index'));
        };

         $temp=json_decode($receiveReceipt->img);
         return view('receive_receipts.show')->with(['receiveReceipt'=> $receiveReceipt , 'temp'=>$temp]);
    }

    /**
     * Show the form for editing the specified ReceiveReceipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $has_workorder=WorkOrder::where('receive_receipt_id',$id)->get();
        if(!count($has_workorder) || Auth::user()->team_id == 1 || Auth::user()->team_id == 2){
            
        $receiveReceipt = $this->receiveReceiptRepository->find($id);
         //return $receiveReceipt;
        $products = Product::pluck('name','id');
        $customers = Customer::pluck('name','id');
        $receivables = Receivable::pluck('name','id');

        if (empty($receiveReceipt)) {
            Flash::error('اذن الاضافة غير موجود');

            return redirect(route('receiveReceipts.index'));
        }
        $temp=json_decode($receiveReceipt->img);
        return view('receive_receipts.edit')
        ->with([
            'receiveReceipt'=> $receiveReceipt ,
             'products'=>$products ,
              'customers'=>$customers, 'temp'=>$temp,
              'receivables'=>$receivables
            ]);
        }else{
            Flash::error(' عفوآ...لا يمكن تعديل اذن اضافة مضاف له غسلات يرجى الرجوع لمدير خدمة العملاء');
            return redirect()->back();
        }
    }

    /**
     * Update the specified ReceiveReceipt in storage.
     *
     * @param int $id
     * @param UpdateReceiveReceiptRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReceiveReceiptRequest $request)
    {
        //return $request;
        $receiveReceipt = $this->receiveReceiptRepository->find($id);

        if (empty($receiveReceipt)) {
            Flash::error('اذن الاضافة غير موجود');
            return redirect(route('receiveReceipts.index'));
        }

        if($request->img){
        $imgs=[];
        for ($i=0; $i <count($request->img) ; $i++) { 
            $file_name=$this->upload_file($request->img[$i],'uploads/receive_receipt/',$i);
            array_push($imgs,'uploads/receive_receipt/'.$file_name);
        }
    // --------------uplaod file-------
    $input['img'] = json_encode($imgs);
    $input['updated_by']= Auth::user()->id;
    $receiveReceipt = $this->receiveReceiptRepository->update($input, $id);

           }else{
            $input=$request->all();
            $input['img']=$receiveReceipt->img;
            $input['updated_by']= Auth::user()->id;
            $receiveReceipt = $this->receiveReceiptRepository->update($input, $id);
           }
// ----------------------------------------------تعديل الصنف  والمستلم-------------------
           $workOrders = WorkOrder::where('receive_receipt_id', $id)->get();
            foreach ($workOrders as $workOrder) {
                    $workOrder->update([
                        'product_id' => $request->product_id,
                        'receivable_id' => $request->receivable_id,
                        
                    ]);
                }

        Flash::success('تم تحديث اذن الاضافة بنجاح');

        return redirect(route('receiveReceipts.index'));
    }

    /**
     * Remove the specified ReceiveReceipt from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $receiveReceipt = $this->receiveReceiptRepository->find($id);

        if (empty($receiveReceipt)) {
            Flash::error('اذن الاضافة غير موجود');

            return redirect(route('receiveReceipts.index'));
        }

        $check = WorkOrder::where('receive_receipt_id',$id)->get();
        // return $check;
        if(count($check)>0){
            Flash::error('  لا يمكن حذف اذن الاضافة لوجود غسلة له   ');

            return redirect(route('receiveReceipts.index'));
        }else{

        $this->receiveReceiptRepository->delete($id);

        Flash::success('تم حذف اذن الاضافة بنجاح');

        return redirect(route('receiveReceipts.index'));
        }
    }

    public function get_customer_orders(Request $request){

        $data=[];
        $models=[];
        $ids=[];

        $orders = Dyeing_receive::where('customer_id',$request->customer_id)->where('status','checked')
        // ->select('*')
        ->select('*', DB::raw('GROUP_CONCAT(dyeing_requests_id) as dyeing_requests_ids'))
        ->selectRaw('sum(quantity) AS quantities')
        ->groupBy('product_color_id','model')
        ->get();

        // for ($i=0; $i <count($orders) ; $i++) { 

        //     if($i==0){
        //         array_push($data , $orders[$i]);
        //         array_push($models , $orders[$i]->model);
        //         array_push($ids , $orders[$i]->product_color_id);
        //         continue;
        //     }

        //     if(in_array($orders[$i]->model , $models) && in_array($orders[$i]->product_color_id , $ids)){

        //         $collection = collect($data);
        //         $filtered = $collection->where('model', $orders[$i]->model);
        //         $data[$filtered->keys()[0]]->quantity += $orders[$i]->quantity;
        //         $data[$filtered->keys()[0]]->dyeing_requests_id = $data[$filtered->keys()[0]]->id.'0'.$orders[$i]->dyeing_requests_id;
        //         //$val = explode("0",$data[$filtered->keys()[0]]->id);
              

        //     }else{
        //         array_push($data , $orders[$i]);
        //         array_push($models , $orders[$i]->model);
        //         array_push($ids , $orders[$i]->product_color_id);
        //     }
        // }

        // $orders = Dyeing_receive::select('*')
        // ->groupBy('model')
        // ->get();

        return $orders;
    }
}
