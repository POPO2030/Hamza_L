<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\Return_receiptDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateReturn_receiptRequest;
use App\Http\Requests\CRM\UpdateReturn_receiptRequest;
use App\Repositories\CRM\Return_receiptRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Traits\UploadTrait;
use App\Models\CRM\Product;
use App\Models\CRM\Customer;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Receivable;
use Auth;

class Return_receiptController extends AppBaseController
{
    use UploadTrait;
    /** @var Return_receiptRepository $returnReceiptRepository*/
    private $returnReceiptRepository;

    public function __construct(Return_receiptRepository $returnReceiptRepo)
    {
        $this->returnReceiptRepository = $returnReceiptRepo;
    }

    /**
     * Display a listing of the Return_receipt.
     *
     * @param Return_receiptDataTable $returnReceiptDataTable
     *
     * @return Response
     */
    public function index(Return_receiptDataTable $returnReceiptDataTable)
    {
        return $returnReceiptDataTable->render('return_receipts.index');
    }

    /**
     * Show the form for creating a new Return_receipt.
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
            $old_work_orders= WorkOrder::pluck('id','id');
            return view('return_receipts.create')->with(['products'=>$products,'customer_data'=>$customer_data,'redirect'=>$redirect,'receivables'=>$receivables, 'old_work_orders'=>$old_work_orders]);
        }else{
            $products = Product::pluck('name','id');
            $customers = Customer::pluck('name','id');
            $receivables = Receivable::pluck('name','id');
            $old_work_orders= WorkOrder::pluck('id','id');
            return view('return_receipts.create')
            ->with([
                'products'=>$products,
                'customers'=>$customers,
                'receivables'=>$receivables,
                'old_work_orders'=>$old_work_orders
            ]);
        }
        return view('return_receipts.create');
    }

    /**
     * Store a newly created Return_receipt in storage.
     *
     * @param CreateReturn_receiptRequest $request
     *
     * @return Response
     */
    public function store(CreateReturn_receiptRequest $request)
    {
        // return $request;
         $input = $request->all();
 
         // --------------uplaod file-------
         if($request->img){
             $imgs=[];
             for ($i=0; $i <count($request->img) ; $i++) { 
                 $file_name=$this->upload_file($request->img[$i],'uploads/Return_receipt/',$i);
                 array_push($imgs,'uploads/Return_receipt/'.$file_name);
             }
             //return $imgs;
         // --------------uplaod file-------
         $input['img'] = json_encode($imgs);
         $input['final_weight'] = 0;
         $input['status'] = 'open';
         $input['creator_id']= Auth::user()->id;
         $returnReceipt = $this->returnReceiptRepository->create($input);
 
         }else{
            $input['final_weight'] = 0;
            $input['status'] = 'open';
            $input['creator_id']= Auth::user()->id;
            $returnReceipt = $this->returnReceiptRepository->create($input);
         }
 
        //  if(isset($request->redirect)){
        //      return redirect('get_return_receipt/'.$request->customer_id);
        //  }
 
         Flash::success('تم إنشاء إذن استلام مرتجع بنجاح');
         return redirect(route('returnReceipts.index'));

    }

    /**
     * Display the specified Return_receipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $returnReceipt = $this->returnReceiptRepository->find($id);

        if (empty($returnReceipt)) {
            Flash::error('إذن استلام مرتجع غير موجود');

            return redirect(route('returnReceipts.index'));
        }
        $temp=json_decode($returnReceipt->img);
        return view('return_receipts.show')->with(['returnReceipt'=> $returnReceipt , 'temp'=>$temp]);
    }

    /**
     * Show the form for editing the specified Return_receipt.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $returnReceipt = $this->returnReceiptRepository->find($id);

        $products = Product::pluck('name','id');
       $customers = Customer::pluck('name','id');
       $receivables = Receivable::pluck('name','id');
       $old_work_orders= WorkOrder::pluck('id','id');

       if (empty($returnReceipt)) {
           Flash::error('إذن استلام مرتجع غير موجود');

           return redirect(route('returnReceipts.index'));
       }
       $temp=json_decode($returnReceipt->img);
       return view('return_receipts.edit')
       ->with([
           'returnReceipt'=> $returnReceipt ,
            'products'=>$products ,
             'customers'=>$customers,
              'temp'=>$temp,
             'receivables'=>$receivables,
             'old_work_orders'=>$old_work_orders
           ]);
    }

    /**
     * Update the specified Return_receipt in storage.
     *
     * @param int $id
     * @param UpdateReturn_receiptRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReturn_receiptRequest $request)
    {
        $returnReceipt = $this->returnReceiptRepository->find($id);

        if (empty($returnReceipt)) {
            Flash::error('إذن استلام مرتجع غير موجود');

            return redirect(route('returnReceipts.index'));
        }

        if($request->img){
            $imgs=[];
            for ($i=0; $i <count($request->img) ; $i++) { 
                $file_name=$this->upload_file($request->img[$i],'uploads/Return_receipt/',$i);
                array_push($imgs,'uploads/Return_receipt/'.$file_name);
            }
        // --------------uplaod file-------
        $input['img'] = json_encode($imgs);
        $input['updated_by']= Auth::user()->id;
        $returnReceipt = $this->returnReceiptRepository->update($request->all(), $id);

        }else{
        $input=$request->all();
        $input['img']=$returnReceipt->img;
        $input['updated_by']= Auth::user()->id;
        $returnReceipt = $this->returnReceiptRepository->update($input, $id);
       }

        Flash::success('تم تحديث إذن استلام مرتجع بنجاح');

        return redirect(route('returnReceipts.index'));
    }

    /**
     * Remove the specified Return_receipt from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $returnReceipt = $this->returnReceiptRepository->find($id);

        if (empty($returnReceipt)) {
            Flash::error('إذن استلام مرتجع غير موجود');

            return redirect(route('returnReceipts.index'));
        }

        $this->returnReceiptRepository->delete($id);

        Flash::success('تم حذف إذن استلام مرتجع بنجاح');

        return redirect(route('returnReceipts.index'));
    }
}
