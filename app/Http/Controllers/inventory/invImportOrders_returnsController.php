<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\invImportOrders_returnsDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateinvImportOrders_returnsRequest;
use App\Http\Requests\inventory\UpdateinvImportOrders_returnsRequest;
use App\Repositories\inventory\invImportOrders_returnsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\inventory\Inv_importOrder;
use App\Models\inventory\Inv_importorder_details;
use App\Models\inventory\invImportOrders_returns;
use App\Models\inventory\Inv_importorder_details_return;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Inv_stockIn;
use App\Models\inventory\product_color;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\InvFinalProductStock;
use App\Models\sales\Supplier_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Auth;

class invImportOrders_returnsController extends AppBaseController
{
    /** @var invImportOrders_returnsRepository $invImportOrdersReturnsRepository*/
    private $invImportOrdersReturnsRepository;

    public function __construct(invImportOrders_returnsRepository $invImportOrdersReturnsRepo)
    {
        $this->invImportOrdersReturnsRepository = $invImportOrdersReturnsRepo;
    }

    /**
     * Display a listing of the invImportOrders_returns.
     *
     * @param invImportOrders_returnsDataTable $invImportOrdersReturnsDataTable
     *
     * @return Response
     */
    public function index(invImportOrders_returnsDataTable $invImportOrdersReturnsDataTable)
    {
        $importorders_customers = Inv_importOrder::where('product_category_id','<>',3)->select('id')->get();

        return $invImportOrdersReturnsDataTable->render('inv_import_orders_returns.index',['importorders_customers'=>$importorders_customers]);
    }

    /**
     * Show the form for creating a new invImportOrders_returns.
     *
     * @return Response
     */


    public function create(Request $request,$id = null)
    {

        if($id){
            $invImportOrder =Inv_importOrder::with(['invproduct_category:name,id','get_user:name,id'])->find($id);
      
            if (empty($invImportOrder)) {
                return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));  
            }
    
            $table_body=Inv_importorder_details::
            with('get_store:name,id')
            ->with('product_color.get_product.get_size:name,id')
            ->with('product_color.get_product.get_weight:name,id')
            ->with('product_color.get_product.invproduct_category:name,id')
            ->with(['get_unit','get_return'])
            ->with('product_color.get_color.invcolor_category:name,id')
            ->where('invimport_id',$invImportOrder->id)
            ->get();

            // --------------------------------------  حساب كمية المرتجع السابق  -----------------------------------------------------
            $import_order_return =invImportOrders_returns::where('invimport_id',$id)->with('get_details')->get();
            $import_order_return_details = $import_order_return->flatMap(function ($import_order) {
                return $import_order->get_details;
            })->groupBy('product_id')->map(function ($group, $product_id) {
                return [
                    'product_id' => $product_id,
                    'quantity' => $group->sum('quantity')
                ];
            })->values();
        // --------------------------------------  نهاية حساب كمية المرتجع السابق  -----------------------------------------------------

            // return $request->invimport_id;
            return view('inv_import_orders_returns.create')
            ->with([
                'invImportOrder'=> $invImportOrder ,
                 'table_body'=>$table_body,
                 'invimport_id'=>$request->invimport_id,
                 'import_order_return_details'=>$import_order_return_details,
                ]);
        }else{
        $invImportOrder =Inv_importOrder::with('get_user:name,id')->find($request->invimport_id);
        
        if (empty($invImportOrder)) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));  
        }

        $table_body=Inv_importorder_details::
        with('get_store:name,id')
        ->with('product_color.get_product.get_size:name,id')
        ->with('product_color.get_product.get_weight:name,id')
        ->with('product_color.get_product.invproduct_category:name,id')
        ->with(['get_unit','get_return'])
        ->with('product_color.get_color.invcolor_category:name,id')
        ->where('invimport_id',$invImportOrder->id)
        ->get();

         // --------------------------------------  حساب كمية المرتجع السابق  -----------------------------------------------------
         $import_order_return =invImportOrders_returns::where('invimport_id',$request->invimport_id)->with('get_details')->get();
         $import_order_return_details = $import_order_return->flatMap(function ($import_order) {
             return $import_order->get_details;
         })->groupBy('product_id')->map(function ($group, $product_id) {
             return [
                 'product_id' => $product_id,
                 'quantity' => $group->sum('quantity')
             ];
         })->values();
     // --------------------------------------  نهاية حساب كمية المرتجع السابق  -----------------------------------------------------


        return view('inv_import_orders_returns.create')
        ->with([
            'invImportOrder'=> $invImportOrder ,
             'table_body'=>$table_body,
             'invimport_id'=>$request->invimport_id, 
             'import_order_return_details'=>$import_order_return_details,
            ]);
        }
    }

    public function store(CreateinvImportOrders_returnsRequest $request)
    {
        //  return $request;

         if(!count($request->quantity)){
        return redirect()->route('invImportOrders_Returns.index')->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));  

         }
        $invImportOrder =Inv_importOrder::find($request->ImportOrderid);
       
      
        // ======================================================================================
                    // for ($i=0; $i <count($request->product_id) ; $i++) { 
                    //     if($request->quantity[$i]>0){
                    //     $productId = $request->product_id[$i];
                    //     $invImportDetail = Inv_importorder_details::where('invimport_id', $invImportOrder->id)
                    //         ->where('product_id', $productId)
                    //         ->first();

                    //         $sum_qty=Inv_controlStock::where('product_id',$productId)
                    //                         ->where('supplier_id', $invImportOrder->supplier_id)
                    //                         ->groupBy('product_id')
                    //                         // ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum,product_id '))
                    //                         ->selectRaw('sum(quantity_in) - sum(quantity_out) as sum, product_id')
                    //                         ->first();
                    //          $check = $sum_qty->sum - $request->quantity[$i];
                    //          if($check < 0){
                    //            return redirect(route('invImportOrders_Returns.index'))->with('error', trans('عفوآ...كميه المرتجع اكبر من الكميه المتاحه'));
                    //          }
                    //     }
                    // }
      // ======================================================================================
        try {
            DB::beginTransaction();
    // -----------------insert Import Order Return-----------------

        $input = $request->all();
        $input['date_out']=date('Y-m-d');
        $input['comment']=$request->comment;
        $input['product_category_id']=$invImportOrder->product_category_id;
        $input['supplier_id']=$invImportOrder->supplier_id;
        $input['user_id']=Auth::user()->id;
        $invImportOrder_return = $this->invImportOrdersReturnsRepository->create($input);


        // -----------------insert invimport Details-----------------
        $invImport_detials =Inv_importorder_details::where('invimport_id',$request->ImportOrderid)->get();
        
        $data2=[];
        for ($i=0; $i <count($request->quantity) ; $i++) { 
            if($request->quantity[$i]>0){
                $data2[$i]=[
                    'invimport_id_return' => $invImportOrder_return->id,
                    'product_id' => $invImport_detials[$i]->product_id,
                    'unit_id' => $invImport_detials[$i]->unit_id,
                    'quantity' => $request->quantity[$i],
                    'store_id' => $invImport_detials[$i]->store_id,
                    'invimport_id' =>$invImportOrder->id,
                    'product_price' =>$invImport_detials[$i]->product_price,
                    'total_product_price' =>$invImport_detials[$i]->product_price * $request->quantity[$i],
                    'created_at'=>$invImportOrder_return->created_at,
                ];
            }

        }
        Inv_importorder_details_return::insert($data2);
        // -----------------insert Control stock -----------------

        $Inv_controlStock =Inv_controlStock::where('invimport_export_id',$request->ImportOrderid)
        ->where('flag',1)->get();
        $data3=[];
        for ($i=0; $i <count($request->quantity) ; $i++) {
            
            if($request->quantity[$i]>0){
                $productID = product_color::where('id',$Inv_controlStock[$i]->product_id)->pluck('product_id');
        
                $unitcontent = Inv_ProductUnit::select('unitcontent')
                ->where('product_id',$productID)
                ->where('unit_id',$Inv_controlStock[$i]->unit_id)->first();

                $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];

                $data3[$i]=[
                    'invimport_export_id'=>$invImportOrder_return->id,
                    'product_id'=>$Inv_controlStock[$i]->product_id,
                    'unit_id'=>$Inv_controlStock[$i]->unit_id,
                    'quantity_out'=>$total_unitcontent,
                    'store_id'=>$invImport_detials[$i]->store_id,
                    'created_at'=>$invImportOrder_return->created_at,
                    'flag'=>3
                ];
            }

        }
        Inv_controlStock::insert($data3);


    // -----------------------insert supplier details----------------------
        $sum_total_product_price =Inv_importorder_details_return::where('invimport_id_return',$invImportOrder_return->id)->sum('total_product_price');

        $supplier_details = Supplier_details::create([
                'invimport_id'=>$invImportOrder->id,
                'cash_balance_debit' => $sum_total_product_price,
                'supplier_id' => $invImportOrder->supplier_id,
                'flag' => 3,
                'note'=>'مرتجع اذن رقم'.$invImportOrder_return->id,
            ]);
 
    //   -------------------------------------------------

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;

    }

        return redirect(route('invImportOrders_Returns.index'))->with('success', trans('تنبيه...تم حفظ اذن المرتجع بنجاح'));  
    }


    public function show($id)
    {
        $invImportOrder_return = invImportOrders_returns::
        with(['get_user:name,id','invproduct_category:name,id','get_supplier:name,id'])->find($id);
       
        if (empty($invImportOrder_return)) {
            return redirect(route('invImportOrders_Returns.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن المرتجع'));  
        }
        
        $inv_importOrder_details =Inv_importorder_details::where('invimport_id',$invImportOrder_return->invimport_id)->get();

        $table_body = Inv_importorder_details_return::with(['product_color:id,product_id,color_id',
        'product_color.get_product:name,id,category_id,description_id,size_id,weight_id',
        'product_color.get_product.get_product_description:name,id',
        'get_unit',
        'get_return',
        'product_color.get_color:id,colorCategory_id,color_code_id',
        'product_color.get_color.get_color_code:name,id',
        'product_color.get_color.invcolor_category:name,id',
        'get_store:name,id'
        ])
        ->where('invimport_id_return',$invImportOrder_return->id)
        ->get();
    
    //    return $table_body;
        return view('inv_import_orders_returns.show')
        ->with([
            'invImportOrder_return'=> $invImportOrder_return,
            'table_body'=> $table_body,
            'inv_importOrder_details'=> $inv_importOrder_details,
        ]);
    }

    public function edit($id)
    {
        $invImportOrder_return = invImportOrders_returns::
        with(['get_user:name,id','invproduct_category:name,id','get_supplier:name,id'])->find($id);
       
        if (empty($invImportOrder_return)) {
            return redirect(route('invImportOrders_Returns.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن المرتجع'));  
        }

        $inv_importOrder_details =Inv_importorder_details::where('invimport_id',$invImportOrder_return->invimport_id)->get();

        $table_body=Inv_importorder_details_return::
        with('get_store:name,id')
        ->with(['product_color:id,product_id,color_id',
        'product_color.get_product:name,id,category_id,description_id,size_id,weight_id,system_code,manual_code',
        'product_color.get_product.get_product_description:name,id',
        'get_unit',
        'product_color.get_color:id,colorCategory_id,color_code_id',
        'product_color.get_color.get_color_code:name,id',
        'product_color.get_color.invcolor_category:name,id'
        ])
        ->where('invimport_id_return',$invImportOrder_return->id)
        ->get();

    // --------------------------------------  حساب كمية المرتجع السابق  -----------------------------------------------------
        $import_order_return =invImportOrders_returns::where('invimport_id',$invImportOrder_return->invimport_id)->with('get_details')->get();
        $import_order_return_details = $import_order_return->flatMap(function ($import_order) {
            return $import_order->get_details;
        })->groupBy('product_id')->map(function ($group, $product_id) {
            return [
                'product_id' => $product_id,
                'quantity' => $group->sum('quantity')
            ];
        })->values();
    // --------------------------------------  نهاية حساب كمية المرتجع السابق  -----------------------------------------------------


        // return $table_body;
        return view('inv_import_orders_returns.edit')->with([
            'invImportOrder_return'=> $invImportOrder_return,
            'table_body'=> $table_body,
            'inv_importOrder_details'=> $inv_importOrder_details,
            'import_order_return_details'=> $import_order_return_details,
        ]);
    }


    public function update($id, UpdateinvImportOrders_returnsRequest $request)
    {
        // return $request;
        $invImportOrdersReturns = $this->invImportOrdersReturnsRepository->find($id);

        if (empty($invImportOrdersReturns)) {
            return redirect(route('invImportOrders_Returns.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن المرتجع'));  
        }
       

    //            // ================================start Validation for Exceeding Maximum Return Quantity per Product======================
    //            // ================================التحقق من تجاوز الحد الأقصى لكمية الإرجاع لكل منتج======================
    //    $old_product=Inv_importorder_details_return::where('invimport_id_return',$id)->pluck('product_id')->toArray();

    //    if(count($old_product) > count($request->product_id)){

    //        $result= array_diff($old_product,$request->product_id);

    //        for ($i = 0; $i < count(((array_values($result)))); $i++) {
    //        $sum_product_qty = Inv_controlStock::where('product_id', ((array_values($result)))[$i] )
    //        ->groupBy('product_id')
    //        ->selectRaw('sum(quantity_in) - sum(quantity_out) as sum')
    //        ->first();

    //        $old_qty=Inv_importorder_details_return::where('invimport_id_return',$id)->where('product_id', ((array_values($result)))[$i])
    //        ->select('quantity')->first();

    //        $check = $sum_product_qty->sum - $old_qty->quantity;
    //        if($check < 0){
    //            return redirect()->back()->with('error', trans('عفوآ...تم الوصول للحد الاقصي من المنتجات على اذن المرتجع الواحد'));
    //        }
    //        }
    //    }
    //  // ================================End of Validation for Exceeding Maximum Return Quantity per Product======================
    //    // ============================== start of Validation for Adjusting Quantity in Import Order Returns====================  
    //         for ($i = 0; $i < count($request->product_id); $i++) {
    //             if($request->quantity[$i]>0){                
    //             $old_quantity=Inv_importorder_details_return::where('invimport_id_return', $invImportOrdersReturns->id)
    //             ->where('product_id',$request->product_id[$i])->first();
    //             // return $old_quantity;
    //             if ($old_quantity) {
  
    //               $sum_qty=Inv_controlStock::where('product_id',$request->product_id[$i])
    //               ->groupBy('product_id') 
    //               ->selectRaw('sum(quantity_in) - sum(quantity_out) as sum, product_id')
    //               ->first();
    //               $total_qty= $old_quantity->quantity + $sum_qty->sum;
    //               $check = $total_qty - $request->quantity[$i];
    //             if($check < 0){
    //                 return redirect()->back()->with('error', trans('عفوآ...لايمكن التعديل كميه الصرف اكبر من الكميه المتاحه'));
    //             }

    //           }

    //             }
    //         }
    //    // =================================================================================================================
   
            
        try {
            DB::beginTransaction();
// -----------------insert Import Order Return-----------------

        $input = $request->all();
        $input['date_out']=$invImportOrdersReturns->date_out;
        $input['comment']=$request->comment;
        $input['product_category_id']=$invImportOrdersReturns->product_category_id;
        $input['supplier_id']=$invImportOrdersReturns->supplier_id;
        $input['updated_by']=Auth::user()->id;
        $invImportOrdersReturns = $this->invImportOrdersReturnsRepository->update($input, $id);

        if($request->product_category_id != 3){
        $invImport_detials =Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->get();
        Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->delete();
            
        Inv_controlStock::where('invimport_export_id',$invImportOrdersReturns->id)->where('flag',3)->delete();
       
        Supplier_details::where('invimport_id',$invImportOrdersReturns->invimport_id)->where('flag',3)->delete();
 // -----------------insert invimport Details return-----------------

 $data2=[];
for ($i=0; $i <count($request->quantity) ; $i++) { 
    $data2[$i]=[
        'invimport_id_return' => $invImportOrdersReturns->id,
        'product_id' => $invImport_detials[$i]->product_id,
        'unit_id' => $invImport_detials[$i]->unit_id,
        'quantity' => $request->quantity[$i],
        'store_id' => $invImport_detials[$i]->store_id,
        'invimport_id' =>$invImport_detials[$i]->invimport_id,
        'product_price' =>$invImport_detials[$i]->product_price,
        'total_product_price' =>$invImport_detials[$i]->product_price * $request->quantity[$i],
        'created_at'=>$invImportOrdersReturns->updated_at,
    ];
}
Inv_importorder_details_return::insert($data2);
   // -----------------insert Control stock -----------------
   $data3=[];
   for ($i=0; $i <count($request->quantity) ; $i++) { 

       $productID =product_color::where('id',$invImport_detials[$i]->product_id)->pluck('product_id');
      
       $unitcontent=Inv_ProductUnit::select('unitcontent')
       ->where('product_id',$productID)
       ->where('unit_id',$invImport_detials[$i]->unit_id)->first();

       $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
       $data3[$i]=[
           'invimport_export_id'=>$invImportOrdersReturns->id,
           'product_id'=>$invImport_detials[$i]->product_id,
           'unit_id'=>$invImport_detials[$i]->unit_id,
           'quantity_out'=>$total_unitcontent,
           'store_id'=>$invImport_detials[$i]->store_id,
           'created_at'=>$invImportOrdersReturns->updated_at,
           'flag'=>3
       ];
   }
   Inv_controlStock::insert($data3);

    // -----------------------insert supplier details----------------------
        $sum_total_product_price =Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->sum('total_product_price');

        $supplier_details = Supplier_details::create([
                'invimport_id'=>$invImportOrdersReturns->invimport_id,
                'cash_balance_debit' => $sum_total_product_price,
                'supplier_id' => $invImportOrdersReturns->supplier_id,
                'flag' => 3,
                'note'=>'مرتجع اذن رقم'.$invImportOrdersReturns->id,
            ]);
 
    //   -------------------------------------------------
 



        }else{

            $invImport_detials =Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->get();
        Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->delete();
            
        InvFinalProductStock::where('invimport_export_id',$invImportOrdersReturns->id)->where('flag',3)->delete();
 // -----------------insert invimport Details return-----------------

 $data2=[];
for ($i=0; $i <count($request->quantity) ; $i++) { 
    $data2[$i]=[
        'invimport_id_return' => $invImportOrdersReturns->id,
        'product_id' => $invImport_detials[$i]->product_id,
        'unit_id' => $invImport_detials[$i]->unit_id,
        'quantity' => $request->quantity[$i],
        'store_id' => $invImport_detials[$i]->store_id,
        'invimport_id' =>$invImport_detials[$i]->invimport_id,
        'created_at'=>$invImportOrdersReturns->updated_at,
    ];
}
Inv_importorder_details_return::insert($data2);
   // -----------------insert Control stock -----------------
   $data3=[];
   for ($i=0; $i <count($request->quantity) ; $i++) { 

       $productID =product_color::where('id',$invImport_detials[$i]->product_id)->pluck('product_id');
      
       $unitcontent=Inv_ProductUnit::select('unitcontent')
       ->where('product_id',$productID)
       ->where('unit_id',$invImport_detials[$i]->unit_id)->first();

       $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
       $data3[$i]=[
           'invimport_export_id'=>$invImportOrdersReturns->id,
           'product_id'=>$invImport_detials[$i]->product_id,
           'unit_id'=>$invImport_detials[$i]->unit_id,
           'quantity_out'=>$total_unitcontent,
           'store_id'=>$invImport_detials[$i]->store_id,
           'created_at'=>$invImportOrdersReturns->updated_at,
           'flag'=>3
       ];
   }
   InvFinalProductStock::insert($data3);

        }

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    
    }

         return redirect(route('invImportOrders_Returns.index'))->with('success', trans('تنبيه...تم تعديل مرتجع بنجاح'));  
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
        $invImportOrdersReturns = $this->invImportOrdersReturnsRepository->find($id);

        if (empty($invImportOrdersReturns)) {
            return redirect(route('invImportOrders_Returns.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن المرتجع'));  
        }


        $this->invImportOrdersReturnsRepository->delete($id);
        Inv_importorder_details_return::where('invimport_id_return',$invImportOrdersReturns->id)->delete();
        Inv_controlStock::where('invimport_export_id',$invImportOrdersReturns->id)->where('flag',3)->delete();

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    
    }
         return redirect(route('invImportOrders_Returns.index'))->with('success', trans('تنبيه...تم حذف اذن المرتجع بنجاح'));  
    }
}
