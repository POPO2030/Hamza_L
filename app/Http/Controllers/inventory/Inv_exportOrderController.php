<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_exportOrderDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_exportOrderRequest;
use App\Http\Requests\inventory\UpdateInv_exportOrderRequest;
use App\Repositories\inventory\Inv_exportOrderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\CRM\Stage;
use App\Models\inventory\Inv_product;
use App\Models\inventory\Inv_store;
use App\Models\inventory\InvUnit;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Inv_exportOrder_details;
use App\Models\inventory\Inv_importorder_details;
use App\Models\inventory\Inv_exportOrder;
use App\Models\inventory\Inv_importOrder;
use App\Models\inventory\Inv_category;
use App\Models\inventory\product_color;
use App\Models\CRM\WorkOrder;
use App\Models\inventory\Color;
use App\Models\inventory\InvFinalProductStock;
use App\Models\sales\Final_product_requset;
use App\Models\sales\Final_product_request_detail;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use DB;    
use Auth;

class Inv_exportOrderController extends AppBaseController
{
    /** @var Inv_exportOrderRepository $invExportOrderRepository*/
    private $invExportOrderRepository;

    public function __construct(Inv_exportOrderRepository $invExportOrderRepo)
    {
        $this->invExportOrderRepository = $invExportOrderRepo;
    }

    /**
     * Display a listing of the Inv_exportOrder.
     *
     * @param Inv_exportOrderDataTable $invExportOrderDataTable
     *
     * @return Response
     */
    public function index(Inv_exportOrderDataTable $invExportOrderDataTable)
    {
        $inv_category = Inv_category::select('id','name')->get();
        return $invExportOrderDataTable->render('inv_export_orders.index',['inv_category'=> $inv_category]);
    }

    /**
     * Show the form for creating a new Inv_exportOrder.
     *
     * @return Response
     */
    public function create()
    {
        $colors=Color::with('invcolor_category:name,id','get_color_code:name,id')->get();
        $customers = Customer::select('id','name')->get();
        $stages = Stage::select('id','name')->get();
        // return $customers;
        $work_orders= WorkOrder::select('id')->where('status','open')->get();
        return view('inv_export_orders.create')
        ->with([
            'customers'=>$customers,
            'stages'=>$stages,
            'work_orders'=>$work_orders,
            'colors'=>$colors,
            
         ]);
    }

    public function store(CreateInv_exportOrderRequest $request)
    {
    //    return $request;
        if(! $request->unit_id){
            return redirect(route('invExportOrders.index'))->with('error', trans('عفوآ...لم يتم اختيار اصناف'));
        }
        // =====================================================================
        try {
            // --------------------------------------------------------
                    DB::beginTransaction();    
                // -----------------insert Stock out-----------------
                        $input = $request->all();
                        $input['work_order_id']= $request->work_order_id;
                        $input['manual_id']= $request->manual_id;
                        $input['user_id']=Auth::user()->id;
                        $invExportOrder = $this->invExportOrderRepository->create($input);
                // -----------------insert Stockout Details-----------------
                        $data2=[];
                        for ($i=0; $i <count($request->product_id) ; $i++) { 
                            $data2[$i]=[
                                'inv_export_id'=>$invExportOrder->id,
                                'product_id'=>$request->product_id[$i],
                                'supplier_id'=>$request->supplier_id[$i],
                                'unit_id'=>$request->unit_id[$i],
                                'quantity'=>$request->quantity[$i],
                                'store_id'=>$request->store_id[$i],
                                'created_at'=>$invExportOrder->created_at,
                            ];
                        }
                    Inv_exportOrder_details::insert($data2);
                // -----------------insert stock Control-----------------
                    $data3=[];
                    for ($i=0; $i <count($request->product_id) ; $i++) { 
                        $productID =product_color::where('id',$request->product_id[$i])->pluck('product_id');
                        $unitcontent=Inv_ProductUnit::select('unitcontent')
                        ->where('product_id',$productID)
                        ->where('unit_id',$request->unit_id[$i])->first();
                        $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                        $data3[$i]=[
                            'invimport_export_id'=>$invExportOrder->id,
                            'supplier_id'=>$request->supplier_id[$i],
                            'work_order_id'=>$request->work_order_id,
                            'product_id'=>$request->product_id[$i],
                            'unit_id'=>$request->unit_id[$i],
                            'quantity_out'=>$total_unitcontent,
                            'store_id'=>$request->store_id[$i],
                            'created_at'=>$invExportOrder->created_at,
                            'flag'=>2
                        ];
                    }
                    Inv_controlStock::insert($data3);

            DB::commit();
            } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
    }
        // =====================================================================

        return redirect(route('invExportOrders.index'))->with('success', trans('تنبيه...تم حفظ اذن صرف بضاعه بنجاح'));
    }

    public function show($id)
    {
        $invExportOrder = Inv_exportOrder::with(['get_user:name,id'])->find($id);

        if (empty($invExportOrder)) {
            return redirect(route('invExportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن صرف البضاعه'));
        }
  
        $table_body =Inv_exportOrder_details::
        with(['get_store:name,id',
        'product_color:id,product_id,color_id',
        'product_color.get_product:name,id,category_id,description_id,size_id,weight_id,manual_code',
        'product_color.get_color:id,color_code_id,colorCategory_id',
        'product_color.get_color.invcolor_category:name,id',
        'product_color.get_color.get_color_code:name,id',
        'get_unit:name,id'])
       ->where('inv_export_id',$invExportOrder->id)
       ->get(); 
        $sum_qty = [];

          foreach ($table_body as $item) {
        
            $product_Id = product_color::select('product_id')->where('id', $item->product_id)->first();

            $content = Inv_ProductUnit::where('product_id', $product_Id->product_id)
            ->where('unit_id', $item->unit_id)->first('unitcontent');

            $stocks = Inv_controlStock::where('product_id', $item->product_id)
            ->selectRaw('store_id,product_id,SUM(quantity_in) - SUM(quantity_out) as sum')
            ->groupBy('store_id')
            ->get();

            foreach ($stocks as $stock) {
                $stock->sum = $stock->sum / $content->unitcontent;
                $sum_qty[] = ['stocks'=>$stocks, 'unit_id'=> $item->unit_id]; 
            }
          }



        return view('inv_export_orders.show')
        ->with(['invExportOrder'=> $invExportOrder,
        'table_body'=>$table_body]);
    }

    /**
     * Show the form for editing the specified Inv_exportOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invExportOrder = Inv_exportOrder::with(['get_user:name,id'])->find($id);
       
        if (empty($invExportOrder)) {
            return redirect(route('invExportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن صرف البضاعه'));
        }
  
        $table_body =Inv_exportOrder_details::
         with(['get_store:name,id',
         'product_color:id,product_id,color_id',
         'product_color.get_product:name,id,category_id,description_id,size_id,weight_id,manual_code',
         'product_color.get_color:id,color_code_id,colorCategory_id',
         'product_color.get_color.invcolor_category:name,id',
         'product_color.get_color.get_color_code:name,id',
         'get_unit:name,id','product_supplier'])
        ->where('inv_export_id',$invExportOrder->id)
        ->get(); 

        $sum_qty = [];


          foreach ($table_body as $item) {
        
            $product_Id = product_color::select('product_id')->where('id', $item->product_id)->first();

            $content = Inv_ProductUnit::where('product_id', $product_Id->product_id)
            ->where('unit_id', $item->unit_id)->first('unitcontent');

            $stocks = Inv_controlStock::where('product_id', $item->product_id)
            ->where('supplier_id', $item->supplier_id)
            ->selectRaw('store_id,product_id,SUM(quantity_in) - SUM(quantity_out) as sum')
            ->groupBy('store_id')
            ->get();

            // foreach ($stocks as $stock) {
            //     $stock->sum = $stock->sum / $content->unitcontent;
            //     $sum_qty[] = ['stocks'=>$stocks, 'unit_id'=> $item->unit_id ,'supplier_id'=> $item->supplier_id]; 
            // }

                      // عدّل الـ sum حسب الـ unitcontent
                    foreach ($stocks as $stock) {
                        $stock->sum = $stock->sum / $content->unitcontent;
                    }

                    // أضف مجموعة واحدة فقط
                    $sum_qty[] = [
                        'stocks'     => $stocks,
                        'unit_id'    => $item->unit_id,
                        'supplier_id'=> $item->supplier_id
                    ];

          }
      
            $Inv_product = Inv_product::pluck('id')->toArray();
            $products = product_color::with([
                'get_color:name,id,colorCategory_id,color_code_id',
                'get_color.invcolor_category:name,id',
                'get_color.get_color_code:name,id',
                'get_product:name,id,category_id,description_id,size_id,weight_id,manual_code',
                'get_product.invproduct_category:name,id'

            ])->whereIn('product_id',$Inv_product)->select('id','product_id','color_id')->get();

        $work_orders = WorkOrder::select('id')->get();
        $customers = Customer::select('id','name')->get();
        $stages = Stage::select('id','name')->get();

        return view('inv_export_orders.edit')
        ->with([
            'invExportOrder'=> $invExportOrder,
            'table_body'=>$table_body,
            'sum_qty'=>$sum_qty,
            'work_orders'=>$work_orders,
            'products'=>$products,
            'customers'=>$customers,
            'stages'=>$stages,
        ]);
    }

    /**
     * Update the specified Inv_exportOrder in storage.
     *
     * @param int $id
     * @param UpdateInv_exportOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_exportOrderRequest $request)
    {
        // return $request;
        if(! $request->unit_id){
            return redirect(route('invExportOrders.index'))->with('error', trans('عفوآ...لم يتم اختيار اصناف'));
        }
        $invExportOrder = $this->invExportOrderRepository->find($id);
        // ======================================================================================
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['work_order_id']= $request->work_order_id;
            $input['manual_id']= $request->manual_id;
            $input['updated_by'] = Auth::user()->id;
            $invExportOrder = $this->invExportOrderRepository->update($request->all(), $id);
    
            Inv_exportOrder_details::where('inv_export_id',$invExportOrder->id)->delete();
            Inv_controlStock::where('invimport_export_id',$invExportOrder->id)
            ->where('flag',2)->delete();
    
             // -----------------insert StockOut Details-----------------
             $data2=[];
             for ($i=0; $i <count($request->product_id) ; $i++) { 

                 $data2[$i]=[
                     'inv_export_id'=>$invExportOrder->id,
                     'product_id'=>$request->product_id[$i],
                     'supplier_id'=>$request->supplier_id[$i],
                     'unit_id'=>$request->unit_id[$i],
                     'quantity'=>$request->quantity[$i],
                     'store_id'=>$request->store_id[$i],
                     'created_at'=>$invExportOrder->created_at,
                     'updated_at'=>now(),
                 ];
             }
             Inv_exportOrder_details::insert($data2);
     // -----------------insert stock Control-----------------
     
             $data3=[];
             for ($i=0; $i <count($request->product_id) ; $i++) { 
                
                $productID =product_color::where('id',$request->product_id[$i])->pluck('product_id');
                $unitcontent=Inv_ProductUnit::select('unitcontent')
                 ->where('product_id',$productID)
                 ->where('unit_id',$request->unit_id[$i])->first();

                $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                 $data3[$i]=[
                     'invimport_export_id'=>$invExportOrder->id,
                     'supplier_id'=>$request->supplier_id[$i],
                     'product_id'=>$request->product_id[$i],
                     'unit_id'=>$request->unit_id[$i],
                     'quantity_out'=>$total_unitcontent,
                     'store_id'=>$request->store_id[$i],
                     'work_order_id'=>$request->work_order_id,
                     'created_at'=>$invExportOrder->created_at,
                     'updated_at'=>now(),
                     'flag'=>2
                 ];
             }
             Inv_controlStock::insert($data3);

             DB::commit();
           } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
           }
    
        // ======================================================================================

        return redirect(route('invExportOrders.index'))->with('success', trans('تنبيه...تم تعديل اذن صرف بضاعه بنجاح'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
        $invExportOrder = $this->invExportOrderRepository->find($id);

        if (empty($invExportOrder)) {

            return redirect(route('invExportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن صرف بضاعه'));
        }

        Inv_exportOrder_details::where('inv_export_id',$invExportOrder->id)->delete();
        Inv_controlStock::where('invimport_export_id',$invExportOrder->id)->where('flag',2)->delete();

        $this->invExportOrderRepository->delete($id);

    DB::commit();
    } catch (\Throwable $th) {
     DB::rollBack();
     throw $th;
    }

        return redirect(route('invExportOrders.index'))->with('success', trans('تنبيه...تم حذف اذن صرف بضاعه بنجاح'));
    }


    public function findunits(Request $request){
        $units =product_color::with(['get_product.get_inv_product_unit.get_unit','get_color'])
        ->where('id',$request->id)->get();

        return $units;
    }

    public function find_stock(Request $request) {
        $productID = product_color::select('product_id')->where('id', $request->item_id)->first();
    
        $content = Inv_ProductUnit::where('product_id', $productID->product_id)
            ->where('unit_id', $request->unit_id)->first('unitcontent');
    
              $stocks = Inv_controlStock::with('get_store:name,id')
              ->where('product_id', $request->item_id)
              ->selectRaw('store_id, SUM(quantity_in) - SUM(quantity_out) as sum')
              ->groupBy('store_id')
              ->get();

                for ($i = 0; $i < count($stocks); $i++) {
                    $stocks[$i]->sum = $stocks[$i]->sum / $content->unitcontent;
                }
            
                // Fetch supplier_id where product_id matches and flag is set to 1
                $suppliers = Inv_controlStock::where('product_id', $request->item_id)
                    // ->where('flag', 1)
                    ->select('supplier_id')
                    ->with('get_supplier:name,id')
                    ->distinct()
                    ->get();
        

        return [
            // 'stocks' => $stocks,
            'stocks' => $stocks,
            'suppliers' => $suppliers,
        ];
    }


    public function find_supplier_stock(Request $request) {
        // return $request;
        $productID = product_color::select('product_id')->where('id', $request->item_id)->first();
    
        $content = Inv_ProductUnit::where('product_id', $productID->product_id)
            ->where('unit_id', $request->unit_id)->first('unitcontent');
    
              $stocks = Inv_controlStock::with('get_store:name,id')
              ->where('product_id', $request->item_id)
              ->where('supplier_id', $request->supplier_id)
              ->selectRaw('store_id, (SUM(quantity_in) - SUM(quantity_out)) as sum')
              ->groupBy('store_id')
              ->get();
        //    return  $stocks;
        for ($i = 0; $i < count($stocks); $i++) {
            $stocks[$i]->sum = $stocks[$i]->sum / $content->unitcontent;
        }

        return $stocks;

    }

    public function final_product_requset_ids(Request $request) {
    
        $final_product_requset_ids = Final_product_requset::with('get_customer:name,id,customer_code')->where('status','under_requset')->orwhere('status','approved')->select('id','customer_id')->get();
        return $final_product_requset_ids;
    }

    public function final_product_requset(Request $request) {
    
        $final_product_requset = Final_product_requset:: where('id',$request->final_product_request_id)->where('status','under_requset')->orwhere('status','approved')->select('id')->first();
        
        $final_product_request_detail = Final_product_request_detail::with([
            'get_product_color:id,product_id,color_id',
            'get_product_color.get_product:name,id,description_id,system_code,manual_code',
            'get_product_color.get_product.get_product_description:name,id',
            'get_product_color.get_color:color_code_id,id,colorCategory_id',
            'get_product_color.get_color.invcolor_category:name,id',
            'get_product_color.get_color.get_color_code:name,id',
            'get_product_color.get_all_unit:id,product_id,unit_id',
            'get_product_color.get_all_unit.get_unit:name,id',
            ])->where('final_product_requset_id',$request->final_product_request_id)
        ->get();

       
        
        return $final_product_request_detail;
    }


    

}
