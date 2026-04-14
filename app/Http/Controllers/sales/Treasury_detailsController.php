<?php

namespace App\Http\Controllers\sales;

use App\DataTables\Treasury_detailsDataTable;
use App\Http\Requests\sales;
use App\Http\Requests\sales\CreateTreasury_detailsRequest;
use App\Http\Requests\sales\UpdateTreasury_detailsRequest;
use App\Repositories\sales\Treasury_detailsRepository;
use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\sales\Customer_details;
use App\Models\sales\Supplier_details;
use App\Models\sales\Treasury_details;
use App\Models\sales\Treasury;
use App\Models\sales\Treasury_journal;
use App\Models\accounting\Bank;
use App\Models\accounting\Payment_type;
use App\Models\accounting\Treasury_check_details;
use App\Models\accounting\Banks_detail;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Auth;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use DB;

class Treasury_detailsController extends AppBaseController
{
    use UploadTrait;
    /** @var Treasury_detailsRepository $treasuryDetailsRepository*/
    private $treasuryDetailsRepository;

    public function __construct(Treasury_detailsRepository $treasuryDetailsRepo)
    {
        $this->treasuryDetailsRepository = $treasuryDetailsRepo;
    }

    /**
     * Display a listing of the Treasury_details.
     *
     * @param Treasury_detailsDataTable $treasuryDetailsDataTable
     *
     * @return Response
     */

    
    public function index(Treasury_detailsDataTable $treasuryDetailsDataTable)
    {
        return $treasuryDetailsDataTable->render('treasury_details.index');
    }

    public function treasury_journal()
    {
        
// -------------------------- check ----------------------------

         $check = Treasury_details::whereDate('created_at', today())->get();
         $check_treasury_journal = Treasury_journal::whereDate('created_at', today())->get();
         
         $last_record = Treasury_details::latest('created_at')->where('payment_type_id', 2)->first();
         
         if ($last_record) {
         $credit_total_check = Treasury_details::whereDate('created_at', $last_record->created_at)->where('payment_type_id', 2)->sum('credit');
         $debit_total_check = Treasury_details::whereDate('created_at', $last_record->created_at)->where('payment_type_id', 2)->sum('debit');
         $balance_first_duration = $credit_total_check - $debit_total_check;
         
 
         if ($check->isEmpty() && $check_treasury_journal->isEmpty()) {
 
             Treasury_journal::create([
                 'balance_first_duration' => $balance_first_duration,
                 'date' => $last_record->created_at,
                 'treasury_id' => $last_record->treasury_id,
                 
             ]);
 
             Treasury_details::create([
                 'treasury_id' => $last_record->treasury_id,
                 'treasury_journal' => $last_record->treasury_journal,
                 'payment_type_id' => 2,
                 'credit' => $balance_first_duration,
                 'debit' => NULL,
                 'details' => 'رصيد افتتاحي',
             ]);
         }
        }
// -------------------End check----------------------------------
        $payment_type=Payment_type::select('name','id')->get();

        $journal=Treasury_details::select('id','credit','debit','details','payment_type_id')->whereDate('created_at', today())->get();
        $treasury_details=Treasury::pluck('name','id');
        $Customer=Customer::select('name','id','customer_code')->get();
        $suppliers=suppliers::select('name','id')->get();
        $banks=Bank::select('name','id','amount')->get();

        $credit_total_cash = Treasury_details::where('payment_type_id',2)->whereDate('created_at', today())->sum('credit');
        $debit_total_cash = Treasury_details::where('payment_type_id',2)->whereDate('created_at', today())->sum('debit');
        $result_cash = $credit_total_cash - $debit_total_cash;

       
        

        return view('treasury_details.treasury_journal')
        ->with(['Customer'=>$Customer,
        'suppliers'=>$suppliers,
        'journal'=>$journal,
        'treasury_details'=>$treasury_details,
        'credit_total_cash'=>$credit_total_cash,
        'debit_total_cash' => $debit_total_cash,
        'payment_type' => $payment_type,
        'result_cash' => $result_cash,
        'banks' => $banks,
    ]);
    }


    public function bankpayment($id)
    {
        $bank_account = Treasury_details::with('get_payment_type:name,id')->where('payment_type_id', $id)->get();
        $credit_total = Treasury_details::where('payment_type_id', $id)->sum('credit');
        $debit_total = Treasury_details::where('payment_type_id', $id)->sum('debit');
        $result_total = $credit_total - $debit_total;


        return view('treasury_details.bank_account_payments_result')
        ->with([
            'bank_account' => $bank_account,
            'result_total' => $result_total
                 ]);
    }

    public function create()
    {
        $treasury_details=Treasury::pluck('name','id');
        $Customer=Customer::select('name','id')->get();
        $suppliers=suppliers::select('name','id')->get();
        return view('treasury_details.create')->with(['Customer'=>$Customer,'suppliers'=>$suppliers,'treasury_details'=>$treasury_details]);
        // return view('treasury_details.create');
    }



    public function store(CreateTreasury_detailsRequest $request)
    {
// return $request;

    DB::beginTransaction();
    try {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;

 
        $treasuryDetails = $this->treasuryDetailsRepository->create($input);

      

    if (isset($request->customer_id )) {

        $data2=[];
        $data2=[
            'treasury_details_id'=>$treasuryDetails->id,
            'customer_id'=>$request->customer_id,
            'cash_balance_credit'=>$request->credit,
            'cash_balance_debit'=>$request->debit,
            'payment_type_id'=>$request->payment_type_id,
            'bank_id'=>$request->bank_id,
            'date'=>$request->date,
            'note'=>$request->details,
            'created_at'=>now(),
            'creator_id' => Auth::user()->id,
        ];
       $customer_details= Customer_details::create($data2);
    }

    if (isset($request->supplier_id )) {
            $data3=[
                'treasury_details_id'=>$treasuryDetails->id,
                'supplier_id'=>$request->supplier_id,
                'cash_balance_credit'=>$request->credit,
                'cash_balance_debit'=>$request->debit,
                'payment_type_id'=>$request->payment_type_id,
                'bank_id'=>$request->bank_id,
                'note'=>$request->details,
                'created_at'=>now(),
                'creator_id' => Auth::user()->id,

            ];
           $supplier_details= Supplier_details::create($data3);
        }
        
    if ( $request->payment_type_id == 3 )  {
        
        
        if($request->img){
            $imgs=[];
            for ($i=0; $i <count($request->img) ; $i++) { 
                $file_name=$this->upload_file($request->img[$i],'uploads/checks/',$i);
                array_push($imgs,'uploads/checks/'.$file_name);
            }
        }
            //return $imgs;
        // --------------uplaod file-------
        
            $data4=[
                'bank_id'=>$request->bank_id,
                'customer_id'=>$request->customer_id,
                'supplier_id'=>$request->supplier_id,
                'date_in'=>$request->date_recive_check,
                'date_entitlment'=>$request->date_entitlment,
                'check_no'=>$request->check_no,
                'deposit'=>!empty($request->credit) ? $request->credit : 0,
                'spend'=>!empty($request->debit) ? $request->debit : 0,
                'img' => !empty($imgs) ? json_encode($imgs) : null,
                'status'=>'pending',
                'created_at'=>now(),
                'creator_id' => Auth::user()->id,

            ];
           $bank_details= Banks_detail::create($data4);
        
            if (isset($customer_details)) {
                $customer_details->update(['bank_details_id' => $bank_details->id]);
            }
            if (isset($supplier_details)) {
                $supplier_details->update(['bank_details_id' => $bank_details->id]);
            }
        }

        // ------------------------------------تسميع التحويل البنكي في رصيد البنك  start  -----------------------
    if ( $request->payment_type_id == 5 )  {
        $bank = Bank::where('id', $request->bank_id)->first();
        $bank_transfer_credit = $request->credit ;
        $bank_transfer_debit = $request->debit ;
        $bank_id = $request->bank_id;

        if($request->credit > 0){
            Bank::where('id', $request->bank_id)->update(['amount' => $bank->amount + $bank_transfer_credit]);
        }
        if($request->debit > 0){
            if($bank->amount  >=  $bank_transfer_debit){
                Bank::where('id', $request->bank_id)->update(['amount' => $bank->amount - $bank_transfer_debit]);
            }else{
                return redirect()->back()->with('error', trans('عفوا... مبلغ التحويل اكبر من رصيد الحساب'));
            } 
        }
    }
        // ------------------------------------تسميع التحويل البنكي في رصيد البنك End  -----------------------


        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }

        return redirect()->back()->with('success', trans('تنبيه... تم الحفظ بنجاح'));
            // abort(404);
    }


    public function under_collection()
    {
        $under_collection = Banks_detail::with(['get_customer:name,id','get_supplier:name,id','get_bank:name,id'])->get();
        return view('treasury_details.under_collection')->with('under_collection', $under_collection);
    }

    public function check_approved(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {

            $bank_details = Banks_detail::where('id', $request->id)->first();
            $bank_details->update(['status' => 'approved','updated_by' => Auth::user()->id,]);
            $bank = Bank::where('id', $bank_details->bank_id)->first();

            if($bank_details->deposit > 0){
                Bank::where('id', $bank_details->bank_id)->update(['amount' => $bank->amount + $bank_details->deposit]);
            }

            if($bank_details->spend > 0){
                if($bank->amount  >=  $bank_details->spend){
                    Bank::where('id', $bank_details->bank_id)->update(['amount' => $bank->amount - $bank_details->spend]);
                }else{
                    return redirect()->back()->with('error', trans('عفوا... مبلغ الشيك اكبر من رصيد الحساب'));
                }
                
            }
           

        
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->back()->with('success', trans('تنبيه... تم تحصيل الشيك بنجاح'));

    }

    public function check_reject(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {

            $bank_details = Banks_detail::where('id', $request->id)->first();
            $bank_details->update(['status' => 'reject']);

            $customer_details= Customer_details::where('bank_details_id',$request->id)->first();
            $customer_details->update(['note'=>'تم رفض الشيك']);

            Treasury_details::where('id',$customer_details->treasury_details_id)->update(['details'=>'تم رفض الشيك']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->back()->with('success', trans('تنبيه... تم رفض الشيك '));

    }
    
    /**
     * Display the specified Treasury_details.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $treasuryDetails = $this->treasuryDetailsRepository->find($id);

        if (empty($treasuryDetails)) {
            return redirect(route('treasuryDetails.index'))->with('error', trans('عفوآ... لم يتم العثور على يوميه الخزينه'));
        }

        return view('treasury_details.show')->with('treasuryDetails', $treasuryDetails);
    }

    /**
     * Show the form for editing the specified Treasury_details.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $treasuryDetails = $this->treasuryDetailsRepository->find($id);

        if (empty($treasuryDetails)) {
            return redirect(route('treasuryDetails.index'))->with('error', trans('عفوآ... لم يتم العثور على يوميه الخزينه'));
        }

        return view('treasury_details.edit')->with('treasuryDetails', $treasuryDetails);
    }

    /**
     * Update the specified Treasury_details in storage.
     *
     * @param int $id
     * @param UpdateTreasury_detailsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTreasury_detailsRequest $request)
    {
        $treasuryDetails = $this->treasuryDetailsRepository->find($id);

        if (empty($treasuryDetails)) {
            return redirect(route('treasuryDetails.index'))->with('error', trans('عفوآ... لم يتم العثور على يوميه الخزينه'));
        }

        $treasuryDetails = $this->treasuryDetailsRepository->update($request->all(), $id);

        return redirect(route('treasuryDetails.index'))->with('success', trans('تنبيه...تم التعديل بنجاح'));
    }

    /**
     * Remove the specified Treasury_details from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $treasuryDetails = $this->treasuryDetailsRepository->find($id);

        if (empty($treasuryDetails)) {
            return redirect(route('treasuryDetails.index'))->with('error', trans('عفوآ... لم يتم العثور على يوميه الخزينه'));
        }

        $this->treasuryDetailsRepository->delete($id);

        Customer_details::where('treasury_details_id',$id)->delete();
        Supplier_details::where('treasury_details_id',$id)->delete();

        return redirect(route('treasuryDetails.index'))->with('success', trans('تنبيه...تم الحذف بنجاح'));
    }



    public function add_discount_customer(Request $request,$id){
        // return $request;

        $data=[
            'treasury_details_id'=>null,
            'customer_id'=>$id,
            'cash_balance_credit'=>$request->amount,
            'cash_balance_debit'=>null,
            'payment_type_id'=>10,                  //خصم
            'bank_id'=>null,
            'note'=>$request->note,
            'date'=>$request->date,
            'created_at'=>now(),
            'creator_id' => Auth::user()->id,
        ];
        Customer_details::insert($data);
        
        return redirect(route('redirect_customer_account_result',['customer_id'=>$id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم اضافة الخصم بنجاح'));
    }

    public function add_account_settlement_customer(Request $request,$id){
        // return $request;

        $data=[
            'treasury_details_id'=>null,
            'customer_id'=>$id,
            'cash_balance_credit'=>null,
            'cash_balance_debit'=>$request->amount,
            'payment_type_id'=>11,                  //تسويه
            'bank_id'=>null,
            'note'=>$request->note,
            'date'=>$request->date,
            'created_at'=>now(),
            'creator_id' => Auth::user()->id,
        ];
        Customer_details::insert($data);
        
        return redirect(route('redirect_customer_account_result',['customer_id'=>$id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم اضافة التسويه بنجاح'));
    }

    public function edit_account_settlement_customer(Request $request,$id){
        // return $request;

        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->update([
            'cash_balance_debit'=>$request->amount,
            'note'=>$request->note,
            'date'=>$request->date,
            'updated_by'=>Auth::user()->id,
        ]);
      
        return redirect(route('redirect_customer_account_result',['customer_id'=>$request->customer_id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم تعديل التسويه بنجاح'));
    }
    public function edit_discount_customer(Request $request,$id){
        // return $request;

        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->update([
            'cash_balance_credit'=>$request->amount,
            'note'=>$request->note,
            'date'=>$request->date,
            'updated_by'=>Auth::user()->id,
        ]);
      
        return redirect(route('redirect_customer_account_result',['customer_id'=>$request->customer_id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم تعديل الخصم بنجاح'));
    }

    public function delete_settlement(Request $request,$id){
        // return $request;

        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->update(['deleted_by'=>Auth::user()->id]);
        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->delete();

        return redirect(route('redirect_customer_account_result',['customer_id'=>$request->customer_id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم حذف التسويه بنجاح'));
    }

    public function delete_discount(Request $request,$id){
        // return $request;

        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->update(['deleted_by'=>Auth::user()->id]);
        Customer_details::where('customer_id',$request->customer_id)->where('id',$request->id)->delete();

        return redirect(route('redirect_customer_account_result',['customer_id'=>$request->customer_id ,'from'=>$request->from,'to'=>$request->to]))->with('success', trans('تنبيه...تم حذف الخصم بنجاح'));
    }


}
