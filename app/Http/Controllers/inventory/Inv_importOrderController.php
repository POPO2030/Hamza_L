<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_importOrderDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_importOrderRequest;
use App\Http\Requests\inventory\UpdateInv_importOrderRequest;
use App\Repositories\inventory\Inv_importOrderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\CRM\Size_finalproduct;
use App\Models\inventory\Inv_category;
use App\Models\inventory\Inv_product;
use App\Models\inventory\Inv_store;
use App\Models\inventory\InvUnit;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\Inv_importorder_details;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\InvFinalProductStock;
use App\Models\inventory\Inv_importOrder;
use App\Models\inventory\invImportOrders_returns;
use App\Models\inventory\product_color;
use App\Models\sales\Supplier_details;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;

class Inv_importOrderController extends AppBaseController
{
    use UploadTrait;
    /** @var Inv_importOrderRepository $invImportOrderRepository*/
    private $invImportOrderRepository;

    public function __construct(Inv_importOrderRepository $invImportOrderRepo)
    {
        $this->invImportOrderRepository = $invImportOrderRepo;
    }

    /**
     * Display a listing of the Inv_importOrder.
     *
     * @param Inv_importOrderDataTable $invImportOrderDataTable
     *
     * @return Response
     */
    public function index(Inv_importOrderDataTable $invImportOrderDataTable)
    {
        $inv_category = Inv_category::select('id','name')->get();
        return $invImportOrderDataTable->render('inv_import_orders.index',['inv_category'=> $inv_category]);
    }

    /**
     * Show the form for creating a new Inv_importOrder.
     *
     * @return Response
     */
    public function create()
    {
            // -----------------------------مده الغلق-----------------
            // $startDate = Carbon::create(2024, 4, 15);
            // $endDate = Carbon::create(2025, 6, 1);
            // $currentDate = Carbon::now();
        
            // if ($currentDate->lt($startDate) || $currentDate->gte($endDate)) {
            //     // If current date is outside the allowed period, redirect back with an error message
            //     return redirect()->back()->with('error', ' Please Back To (  E R P Developer team ) ');
            // }
            // -----------------------------مده الغلق-----------------   
        $suppliers = suppliers::pluck('name','id');
        $cats=Inv_category::pluck('name','id');
          
        // $stores= Inv_store::where('id', '!=' , 1)->get();
        $stores= Inv_store::select('name','id','category_id')->get();
        return view('inv_import_orders.create')
        ->with([
            'suppliers'=>$suppliers, 
            'cats'=>$cats,
            'stores'=>$stores
         ]);
    }

    /**
     * Store a newly created Inv_importOrder in storage. get_weight
     *
     * @param CreateInv_importOrderRequest $request  invcolor_category:name,id
     *
     * @return Response
     */
    public function store(CreateInv_importOrderRequest $request)
    {
        // return $request;
        // =====================================================================
        if(! $request->unit_id){
            Flash::error('لم يتم اختيار اصناف');
            return redirect(route('invImportOrders.index'));
        }
        try {
            DB::beginTransaction();
// -----------------insert Stock in-----------------

        $input = $request->all();
   
          
          $input['user_id']=Auth::user()->id;
          $input['status']='pending';
          $invImportOrder = $this->invImportOrderRepository->create($input);
  
  // -----------------insert StockIn Details-----------------
          $data2=[];
          for ($i=0; $i <count($request->product_id) ; $i++) { 
            $productID =product_color::where('id',$request->product_id[$i])->pluck('product_id');
            $product_price = Inv_product::where('id',$productID)->select('product_price')->first()->product_price;
              $total_product_price = $product_price * $request->quantity[$i];
    
              $data2[$i]=[
                  'invimport_id'=>$invImportOrder->id,
                  'product_id'=>$request->product_id[$i],
                  'unit_id'=>$request->unit_id[$i],
                  'quantity'=>$request->quantity[$i],
                //   'product_price'=>$product_price,
                //   'total_product_price'=>$product_price * $request->quantity[$i],
                  'store_id'=>$request->store_id[$i],
                  'created_at'=>$invImportOrder->created_at,
              ];

          }
          Inv_importorder_details::insert($data2);
  

     
       
        DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        
        }
        // =====================================================================
        return redirect(route('invImportOrders.index'))->with('success', trans('تنبيه...تم حفظ اذن توريد بضاعه بنجاح'));
    }




    public function insert_into_stores(Request $request){
        // return $request;
        $invImportOrder = Inv_importOrder::where('id',$request->id)->first();
        $inv_import_details = Inv_importorder_details::where('invimport_id',$request->id)->get();
        // return $invImportOrder;

        if($invImportOrder->status != 'pending'){
            return redirect()->back()->with('error', trans('عفوا... تم اضافة هذا الاذن من قبل'));
        }
        try {
            DB::beginTransaction();

    
            // -----------------------insert supplier details----------------------

            $sum_total_product_price =Inv_importorder_details::where('invimport_id',$invImportOrder->id)->sum('total_product_price');
            //   return   $sum_total_product_price;
            $supplier_details = Supplier_details::create(
                [
                    'invimport_id'=>$invImportOrder->id,
                    'cash_balance_credit' => $sum_total_product_price,
                    'supplier_id' => $invImportOrder->supplier_id,
                ]
            );
 
            // -------------------------------------------------
        // -----------------insert stock Control-----------------
          $data3=[];
          for ($i=0; $i <count($inv_import_details) ; $i++) { 
  
            $productID =product_color::where('id',$inv_import_details[$i]->product_id)->pluck('product_id');
            $unitcontent=Inv_ProductUnit::select('unitcontent')
              ->where('product_id',$productID)
              ->where('unit_id',$inv_import_details[$i]->unit_id)->first();
  
              $total_unitcontent=$unitcontent->unitcontent*$inv_import_details[$i]->quantity;
              $data3[$i]=[
                  'invimport_export_id'=>$invImportOrder->id,
                //   'customer_id'=>$request->customer_id,
                  'supplier_id'=>$invImportOrder->supplier_id,
                  'product_id'=>$inv_import_details[$i]->product_id,
                  'unit_id'=>$inv_import_details[$i]->unit_id,
                  'quantity_in'=>$total_unitcontent,
                  'store_id'=>$inv_import_details[$i]->store_id,
                  'created_at'=>now(),
                  'flag'=>1
              ];
          }
          Inv_controlStock::insert($data3);
       
            Inv_importOrder::where('id',$request->id)->update(['status'=>'Approved']);
            
          DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
            // =====================================================================
            return redirect(route('invImportOrders.index'))->with('success', trans('تنبيه...تمت الموافقة على اذن الاستلام بنجاح'));
    }
    /**
     * Display the specified Inv_importOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invImportOrder =Inv_importOrder::with(['get_supplier:name,id',
        'get_user:name,id','invproduct_category:name,id'])->find($id);
        
        // $table_body=Inv_importorder_details::
        // with('get_store:name,id')
        // ->with('product_color.get_product')
        // ->with('get_unit')
        // ->with('product_color.get_color:name,id,colorCategory_id')
        // ->with('product_color.get_color.invcolor_category:name,id')
        // ->where('invimport_id',$invImportOrder->id)
        // ->get();
        $table_body = Inv_importorder_details::
        with('get_store:name,id,category_id')
        ->with('product_color.get_product:name,id,category_id,description_id,size_id,weight_id,manual_code')
        ->with('product_color.get_product.get_product_description:name,id')
        ->with('get_unit:id,name')
        ->with('product_color.get_color:name,id,colorCategory_id,color_code_id')
        ->with('product_color.get_color.invcolor_category:name,id')
        ->where('invimport_id',$invImportOrder->id)
        ->get();
        // return $table_body;
        $dataArray = [];

        foreach ($table_body as $item) {
            
            // $systemCode = $item->product_color->get_product->system_code ?? '';
            $manualCode = $item->product_color->get_product->manual_code. '-'?? '';
            $productName = $item->product_color->get_product->name ?? '';
            $productDescription = $item->product_color->get_product->get_product_description->name ?? '';
            $colorCategory = $item->product_color->get_color->invcolor_category->name ?? '';
            $colorName = $item->product_color->get_color->get_color_code->name ?? '';

            // Concatenate the strings
       $productNames = $manualCode . $productName . ' ' . $productDescription;
       if ($item->product_color->get_color->colorCategory_id != 1 && $item->product_color->get_color->color_code_id != 1) {
           $productNames .= ' (' . $colorCategory . ' - ' . $colorName . ')';
       } elseif ($item->product_color->get_color->colorCategory_id != 1 && $item->product_color->get_color->color_code_id == 1) {
           $productNames .= ' (' . $colorCategory . ')';
       } elseif ($item->product_color->get_color->colorCategory_id == 1 && $item->product_color->get_color->color_code_id != 1) {
           $productNames .= ' (' . $colorName . ')';
       }
            $unitId = $item->unit_id;
            $unitNames = $item->get_unit->name;
            $storeid = $item->store_id;
            $storeNames = $item->get_store->name;

        // return $productNames;
            $dataArray[] = [
                'importorder_details_id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $productNames,
                'unit_id' => $unitId,
                'unit_name' => $unitNames,
                'store_id' => $storeid,
                'store_name' => $storeNames,
                'quantity' => $item->quantity,
            ];
        }
        // return $table_body;

        if (empty($invImportOrder)) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));
        }

        return view('inv_import_orders.show')
        ->with(['invImportOrder'=> $invImportOrder , 'table_body'=>$dataArray]);
    }

    /**
     * Show the form for editing the specified Inv_importOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {  
        $has_returned = invImportOrders_returns::where('invimport_id',$id)->get();
        if(Count($has_returned)){
            return redirect()->back()->with('error', trans('عفوآ...لايمكن تعديل الاذن حيث انه يوجد مرتجع منه'));
        }
        $suppliers = suppliers::pluck('name','id');
        $stores= Inv_store::select('name','id','category_id')->get();
        $cats=Inv_category::pluck('name','id');
        $invImportOrder =Inv_importOrder::with('get_user:name,id')->find($id);
       

        $products =product_color::with([
            // 'get_product.get_inv_product_unit.get_unit:name,id',
            'get_color:name,id,colorCategory_id',
            'get_color.invcolor_category:name,id',
            'get_product:name,id,category_id,description_id,size_id,weight_id',
            'get_product.get_weight:name,id',
            'get_product.get_product_description:name,id',
            'get_product.get_size:name,id',
            'get_product.invproduct_category:name,id'
        ])->select('id','product_id','color_id')->get();

        $table_body=Inv_importorder_details::
        with('get_store:name,id,category_id')
        ->with('product_color.get_product:name,id,category_id,description_id,size_id,weight_id')
        ->with('product_color.get_product.get_product_description:name,id')
        ->with('get_unit:id,name')
        ->with('product_color.get_color:name,id,colorCategory_id,color_code_id')
        ->with('product_color.get_color.invcolor_category:name,id')
        ->where('invimport_id',$invImportOrder->id)
        ->get();
        $dataArray = [];

        foreach ($table_body as $item) {
            
            // $systemCode = $item->product_color->get_product->system_code ?? '';
            $manualCode = $item->product_color->get_product->manual_code. '-'?? '';
            $productName = $item->product_color->get_product->name ?? '';
            $productDescription = $item->product_color->get_product->get_product_description->name ?? '';
            $colorCategory = $item->product_color->get_color->invcolor_category->name ?? '';
            $colorName = $item->product_color->get_color->get_color_code->name ?? '';

            // Concatenate the strings
       $productNames = $manualCode . $productName . ' ' . $productDescription;
       if ($item->product_color->get_color->colorCategory_id != 1 && $item->product_color->get_color->color_code_id != 1) {
           $productNames .= ' (' . $colorCategory . ' - ' . $colorName . ')';
       } elseif ($item->product_color->get_color->colorCategory_id != 1 && $item->product_color->get_color->color_code_id == 1) {
           $productNames .= ' (' . $colorCategory . ')';
       } elseif ($item->product_color->get_color->colorCategory_id == 1 && $item->product_color->get_color->color_code_id != 1) {
           $productNames .= ' (' . $colorName . ')';
       }
            $unitId = $item->unit_id;
            $unitNames = $item->get_unit->name;
            $storeid = $item->store_id;
            $storeNames = $item->get_store->name;

        // return $productNames;
            $dataArray[] = [
                'importorder_details_id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $productNames,
                'unit_id' => $unitId,
                'unit_name' => $unitNames,
                'store_id' => $storeid,
                'store_name' => $storeNames,
                'quantity' => $item->quantity,
            ];
        }
        
        //  return $dataArray;
        if (empty($invImportOrder)) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));
        }

        if (count($table_body)>140) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...تم الوصول للحد الاقصي من المنتجات على اذن الاستلام الواحد'));
        }

        return view('inv_import_orders.edit')
        ->with([
            'invImportOrder'=> $invImportOrder,
            'products'=>$products,
            'suppliers'=>$suppliers,
            'stores'=>$stores,
            'cats'=> $cats,
            'table_body'=>$dataArray
    ]);
    }

    public function update($id, UpdateInv_importOrderRequest $request)
    {
        
        $invImportOrder = $this->invImportOrderRepository->find($id);
   
// ================================start validation on deleting product from import order======================
        $old_product=Inv_importorder_details::where('invimport_id',$id)->pluck('product_id')->toArray();

        if(count($old_product) > count($request->product_id)){

            $result= array_diff($old_product,$request->product_id);
            // return ((array_values($result)));
            for ($i = 0; $i < count(((array_values($result)))); $i++) {
            $sum_product_qty = Inv_controlStock::where('product_id', ((array_values($result)))[$i] )
            // ->where('customer_id', $invImportOrder->customer_id)
            ->groupBy('product_id')
            ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum '))->first();
            // return $sum_product_qty;
            $old_qty=Inv_importorder_details::where('invimport_id',$id)->where('product_id', ((array_values($result)))[$i])
            ->select('quantity')->first();
            // return $old_qty;
            $check = $sum_product_qty->sum - $old_qty->quantity;
            if($check < 0){
                return redirect()->back()->with('error', trans('عفوآ...تم الوصول للحد الاقصي من المنتجات على اذن الاستلام الواحد'));
            }
            }
        }
// ================================End of validation on deleting product from import order======================

// ============================== start of validation if product has an inventory greater than zero====================  
            if($invImportOrder->status=="Approved"){ 
                for ($i = 0; $i < count($request->product_id); $i++) {
                        $details = Inv_importorder_details::where('invimport_id', $id)
                            ->where('product_id', $request->product_id[$i])
                            ->select('product_id', 'quantity')
                            ->first();
                    
                        if ($details) {
                        $sum_quantity_in = Inv_controlStock::where('product_id', $request->product_id[$i])
                            ->groupBy('product_id')
                            ->select(\DB::raw('sum(quantity_in) as sum_in'))
                            ->first();
                        
                        $ready_in = $sum_quantity_in->sum_in - $details->quantity;
                    
                        $sum_quantity_out = Inv_controlStock::where('product_id', $details->product_id)
                            ->groupBy('product_id')
                            ->select(\DB::raw('sum(quantity_out) as sum_out'))
                            ->first();
                    
                        $total = $ready_in - $sum_quantity_out->sum_out;
                    
                        $check = $request->quantity[$i] + $total;
                    
                        if ($check < 0) {
                            return redirect()->back()->with('error', trans('كمية التعديل اصغر من كميات اذون الصرف'));

                        }
                    }
                }
            }    
// =================================================================================================================================
    

        if(! $request->unit_id){
            return redirect(route('invImportOrders.index'))->with('error', trans('لم يتم اختيار اصناف'));
        }
        // ============================== End of validation if product the product has an inventory greater than zero====================  
        // return $request;
        try {
            DB::beginTransaction();
              // $input = $request->all();
          
           $input['product_category_id']= $request->product_category_id;
           $input['date_in'] = $request->date_in;
           $input['supplier_id'] = $request->supplier_id;
           $input['comment'] = $request->comment;
           $input['status']='pending';
           $input['updated_by'] = Auth::user()->id;
            $invImportOrder = $this->invImportOrderRepository->update($input, $id);

            Inv_importorder_details::where('invimport_id',$invImportOrder->id)->delete();
            Supplier_details::where('invimport_id',$invImportOrder->id)->delete();
            
            Inv_controlStock::where('invimport_export_id',$invImportOrder->id)->where('flag',1)->delete();

    // -----------------insert StockIn Details-----------------
            $data2=[];
            for ($i=0; $i <count($request->product_id) ; $i++) { 
                // $productID =product_color::where('id',$request->product_id[$i])->pluck('product_id');
                // $product_price = Inv_product::where('id',$productID)->select('product_price')->first()->product_price;
                //   $total_product_price = $product_price * $request->quantity[$i];

                $data2[$i]=[
                    'invimport_id'=>$invImportOrder->id,
                    'product_id'=>$request->product_id[$i],
                    'unit_id'=>$request->unit_id[$i],
                    'quantity'=>$request->quantity[$i],
                    // 'product_price'=>0,
                    // 'total_product_price'=>0,
                    'store_id'=>$request->store_id[$i],
                    'created_at'=>$invImportOrder->updated_at,
                ];
            }
            Inv_importorder_details::insert($data2);
              // -----------------------insert supplier details----------------------

            $sum_total_product_price =Inv_importorder_details::where('invimport_id',$invImportOrder->id)->sum('total_product_price');

            $supplier_details = Supplier_details::create(
            [
                'invimport_id'=>$invImportOrder->id,
                'cash_balance_credit' => $sum_total_product_price,
                'supplier_id' => $request->supplier_id,
        
            ]
            );
   
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        // =========================================================================
        return redirect(route('invImportOrders.index'))->with('success', trans('تنبيه...تم تعديل بيانات اذن توريد بضاعه بنجاح'));
    }
    // ===================================== Start Product pricing ===============================================

    public function edit_product_pricing($id)
    {  
        $suppliers = suppliers::pluck('name','id');
        $invImportOrder =Inv_importOrder::with(['get_supplier:name,id',
        'get_user:name,id','invproduct_category:name,id'])->find($id);
        
        $table_body=Inv_importorder_details::
        with('get_store:name,id')
        ->with('product_color.get_product')
        ->with('get_unit')
        ->with('product_color.get_color:name,id,colorCategory_id')
        ->with('product_color.get_color.invcolor_category:name,id')
        ->where('invimport_id',$invImportOrder->id)
        ->get();

        $dataArray = [];

        foreach ($table_body as $item) {
        
            $productNames = $item->product_color->get_product->name . ' - ' . 
                            $item->product_color->get_color->invcolor_category->name . 
                                 ' - (' . $item->product_color->get_color->name . ')';

            $unitId = $item->unit_id;
            $unitNames = $item->get_unit->name;
            $storeid = $item->store_id;
            $storeNames = $item->get_store->name;
            // $final_product_sizeNames = $item->get_size_finalproducts->name ?? "";
        
            $dataArray[] = [
                'importorder_details_id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $productNames,
                'unit_id' => $unitId,
                'unit_name' => $unitNames,
                'store_id' => $storeid,
                'store_name' => $storeNames,
                // 'final_product_size_id' => $item->final_product_size_id,
                // 'final_product_size_name' => $final_product_sizeNames,
                'quantity' => $item->quantity,
                
            ];
        }
        // return $table_body;

        if (empty($invImportOrder)) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));
        }

        return view('inv_import_orders.edit_product_pricing')
        ->with(['invImportOrder'=> $invImportOrder , 'table_body'=>$table_body, 'suppliers' => $suppliers,]);
    }


    // -------------------------------- تسعير المنتجات من اذن الاضافة --------------------------------
    public function update_product_pricing($id ,Request $request){
 
        for ($i = 0; $i < count($request->product_id); $i++) {

            $product_qty=Inv_importorder_details::where('invimport_id', $id)->where('product_id', $request->product_id[$i])->select('quantity')->first()->quantity;

            Inv_importorder_details::where('invimport_id', $id)
                ->where('product_id', $request->product_id[$i])
                ->update(['product_price' => $request->product_price[$i],
                'total_product_price'=> $product_qty * $request->product_price[$i], 
            ]);

            Inv_importOrder::where('id',$id)->update(['supplier_id'=>$request->supplier_id]);
            Inv_controlStock::where('invimport_export_id',$id)->update(['supplier_id'=>$request->supplier_id]);
        }
    
     
    
        if ($request->hasFile('original_invoice_img')) {

            $request->validate([
                'original_invoice_img' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file_name = $this->upload_img($request->file('original_invoice_img'), 'uploads/original_invoice_img/');
            Inv_importOrder::where('id', $id)->update(['original_invoice_img' => $file_name]);
        } 
        
    
    //           -----------------------insert supplier details----------------------

            $sum_total_product_price =Inv_importorder_details::where('invimport_id',$id)->sum('total_product_price');
            // return $sum_total_product_price ;
            $supplier_id=Inv_importOrder::where('id', $id)->select('supplier_id')->first()->supplier_id;

            Supplier_details::where('invimport_id',$id)->delete();
            
            $supplier_details = Supplier_details::create(
                [
                    'invimport_id'=>$id,
                    'cash_balance_credit' => $sum_total_product_price,
                    'supplier_id' => $supplier_id,

                ]
            );
 
    //  -------------------------------------------------

    return redirect(route('invImportOrders.index'))->with('success', trans('تنبيه... تم تسعير اذن توريد البضاعة بنجاح'));
    

    }

    // ===================================== end Product pricing ===============================================
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
        $invImportOrder = $this->invImportOrderRepository->find($id);

        if (empty($invImportOrder)) {
            return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لم يتم العثور على اذن الاستلام'));
        }

        $details= Inv_importorder_details::where('invimport_id',$id)->select('product_id','quantity')->get();

        if ($invImportOrder->product_category_id != 3) {
            if($invImportOrder->status=="Approved"){ 
                foreach($details as $detail){
                    $get_qty=Inv_controlStock::where('product_id',$detail->product_id)
                    ->groupBy('product_id')
                    ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum '))->first();
                    
                $residal = $get_qty->sum - $detail->quantity;
        
                    if($residal < 0){
                        return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لايمكن حذف اذن اضافة تم صرف كميه منه'));
                    }
                }
            }
            $this->invImportOrderRepository->delete($id);
            Inv_importorder_details::where('invimport_id',$invImportOrder->id)->delete();
            Inv_controlStock::where('invimport_export_id',$invImportOrder->id)->where('flag',1)->delete();

        }else{
            if($invImportOrder->status=="Approved"){
                foreach($details as $detail){
                    $get_qty=InvFinalProductStock::where('product_id',$detail->product_id)
                    ->groupBy('product_id')
                    ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum '))->first();
                    
                $residal = $get_qty->sum - $detail->quantity;
        
                    if($residal < 0){
                        return redirect(route('invImportOrders.index'))->with('error', trans('عفوآ...لايمكن حذف اذن اضافة تم صرف كميه منه'));
                    }
                }
            }
            $this->invImportOrderRepository->delete($id);
            Inv_importorder_details::where('invimport_id',$invImportOrder->id)->delete();
            InvFinalProductStock::where('invimport_export_id',$invImportOrder->id)->where('flag',1)->delete();
        }
   
    
    DB::commit();
    } catch (\Throwable $th) {
     DB::rollBack();
     throw $th;
    }
    return redirect(route('invImportOrders.index'))->with('success', trans('تنبيه... تم حذف اذن توريد بضاعه بنجاح'));
    }

    public function get_imp_products(Request $request){
        // return $request;
        
        $Inv_product = Inv_product::pluck('id')->toArray();
    
        $products = product_color::with([
            'get_color:name,id,colorCategory_id,color_code_id',
            'get_color.invcolor_category:name,id',
            'get_color.get_color_code:name,id',
            'get_product:name,id,category_id,description_id,size_id,weight_id,system_code,manual_code',
            'get_product.get_weight:name,id',
            'get_product.get_product_description:name,id',
            'get_product.get_size:name,id',
            'get_product.invproduct_category:name,id'
        ])->whereIn('product_id',$Inv_product)->select('id','product_id','color_id')->get();

        // $Size_finalproduct =Size_finalproduct::select('id','name')->get();
        return [
            'products' => $products,
            // 'Size_finalproduct' => $Size_finalproduct,
        ];
    }

    public function findunits(Request $request){
        $units =product_color::with(['get_product.get_inv_product_unit.get_unit','get_color'])
        ->where('id',$request->id)->get();

        return $units;
    }
    
}
