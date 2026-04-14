<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_StockTransferDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_StockTransferRequest;
use App\Http\Requests\inventory\UpdateInv_StockTransferRequest;
use App\Repositories\inventory\Inv_StockTransferRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\inventory\Inv_store;
use App\Models\CRM\suppliers;
use App\Models\inventory\product_color;
use App\Models\inventory\Inv_product;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Inv_StockTransfer;
use App\Models\inventory\Inv_stockTransfer_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class Inv_StockTransferController extends AppBaseController
{
    /** @var Inv_StockTransferRepository $invStockTransferRepository*/
    private $invStockTransferRepository;

    public function __construct(Inv_StockTransferRepository $invStockTransferRepo)
    {
        $this->invStockTransferRepository = $invStockTransferRepo;
    }

    /**
     * Display a listing of the Inv_StockTransfer.
     *
     * @param Inv_StockTransferDataTable $invStockTransferDataTable
     *
     * @return Response
     */
    public function index(Inv_StockTransferDataTable $invStockTransferDataTable)
    {
        return $invStockTransferDataTable->render('inv__stock_transfers.index');
    }

    /**
     * Show the form for creating a new Inv_StockTransfer.
     *
     * @return Response
     */
    public function create()
    {
        // $products= InvProduct::all();
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
        $stores=Inv_store::pluck('name','id');
        return view('inv__stock_transfers.create')->with(['stores'=>$stores,'products'=>$products]);
    }

    /**
     * Store a newly created Inv_StockTransfer in storage.
     *
     * @param CreateInv_StockTransferRequest $request
     *
     * @return Response
     */
    public function store(CreateInv_StockTransferRequest $request)
    {
        // return $request;
        if(! $request->unit_id){
            Flash::error('عفوآ...لم يتم اختيار اصناف');
            return redirect(route('invStockOuts.index'));
        }

        try {
            DB::beginTransaction();
            $input = $request->all();
            // $input['serial']=time();
            $input['user_id']=Auth::user()->id;
            $input['status']='pending';
            $invStockTransfer = $this->invStockTransferRepository->create($input);
    
            // -----------------insert stock Control-----------------

              $data1=[];
            for ($i=0; $i <count($request->product_id) ; $i++) { 
                // $unitcontent=Inv_ProductUnit::select('unitcontent')->where('product_id',$request->product_id[$i])->where('unit_id',$request->unit_id[$i])->first();
                $productID = product_color::select('product_id')->where('id', $request->product_id[$i])->first();
                $unitcontent=Inv_ProductUnit::select('unitcontent')->where('product_id',$productID->product_id)->where('unit_id',$request->unit_id[$i])->first();
                $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                $data1[$i]=[
                    'inv_stock_transfer_id'=>$invStockTransfer->id,
                    'product_id'=>$request->product_id[$i],
                    'unit_id'=>$request->unit_id[$i],
                    'quantity'=>$total_unitcontent,
                    'supplier_id'=>$request->supplier_id[$i],
                    'store_id'=>$request->store_out,
                    'created_at'=>$invStockTransfer->created_at
                ];
            }
            Inv_stockTransfer_details::insert($data1);

            // $data1=[];
            $data2=[];
            for ($i=0; $i <count($request->product_id) ; $i++) { 
                // $unitcontent=Inv_ProductUnit::select('unitcontent')->where('product_id',$request->product_id[$i])->where('unit_id',$request->unit_id[$i])->first();
                // $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                $productID = product_color::select('product_id')->where('id', $request->product_id[$i])->first();
                $unitcontent=Inv_ProductUnit::select('unitcontent')->where('product_id',$productID->product_id)->where('unit_id',$request->unit_id[$i])->first();
                $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                $data2[$i]=[
                    'invimport_export_id'=>$invStockTransfer->id,
                    'product_id'=>$request->product_id[$i],
                    'unit_id'=>$request->unit_id[$i],
                    'quantity_out'=>$total_unitcontent,
                    'supplier_id'=>$request->supplier_id[$i],
                    'store_id'=>$request->store_out,
                    'created_at'=>$invStockTransfer->created_at,
                    'flag'=>4
                ];
            }
            Inv_controlStock::insert($data2);
    
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        Flash::success('تنبيه....تم التحويل من مخزن الى مخزن اخر بنجاح');

        return redirect(route('invStockTransfers.index'));
    }


    public function confirm_transfer(Request $request){
        // return $request;
        $invStockTransfer = Inv_StockTransfer::where('id',$request->id)->first();
        $stockTransfer_details = Inv_stockTransfer_details::where('inv_stock_transfer_id',$request->id)->get();

        if($invStockTransfer->status != 'pending'){
            return redirect()->back()->with('error', trans('عفوا... تم اضافة هذا الاذن من قبل'));
        }
        try {
            DB::beginTransaction();
            // -------------------------------------------------
            $data2=[];
            for ($i=0; $i <count($stockTransfer_details) ; $i++) { 
                $detail = $stockTransfer_details[$i];
                $total_unitcontent =$detail->quantity;
                $data2[$i]=[
                    'invimport_export_id'=>$invStockTransfer->id,
                    'product_id'=>$detail->product_id,
                    'unit_id'=>$detail->unit_id,
                    'quantity_in'=>$total_unitcontent,
                    'supplier_id'=>$detail->supplier_id,
                    'store_id'=>$invStockTransfer->store_in,
                    'created_at'=>$invStockTransfer->created_at,
                    'flag'=>4
                ];
            }

          Inv_controlStock::insert($data2);
       
            Inv_StockTransfer::where('id',$request->id)->update(['status'=>'Approved']);
            
          DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
            // =====================================================================
            return redirect(route('invStockTransfers.index'))->with('success', trans('تنبيه...تمت الموافقة على اذن التحويل بنجاح'));
    }
    /**
     * Display the specified Inv_StockTransfer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invStockTransfer = Inv_StockTransfer::with('get_store_in:name,id')
        ->with('get_store_out:name,id')
        ->with('get_user:name,id')
        ->find($id);

        $table_body = Inv_stockTransfer_details::with(['get_product_color:id,product_id,color_id', 
        'get_product_color.get_product:name,id,category_id,system_code,manual_code',
        'get_product_color.get_product.invproduct_category:name,id',
        'get_product_color.get_color:name,id,colorCategory_id,color_code_id',
        'get_product_color.get_color.invcolor_category:name,id',
        'get_product_color.get_color.get_color_code:name,id',
        'get_supplier:name,id',
        'get_product_color.get_product.get_units:id,name'])
        ->where('inv_stock_transfer_id', $invStockTransfer->id)->get();
   
        return view('inv__stock_transfers.show')
        ->with(['invStockTransfer'=> $invStockTransfer , 'table_body'=>$table_body]);
    }

    /**
     * Show the form for editing the specified Inv_StockTransfer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invStockTransfer = $this->invStockTransferRepository->find($id);

        if($invStockTransfer->status == 'Approved'){
            return redirect(route('invStockTransfers.index'))->with('error', trans('عفوا... تم تاكيد التحويل  ولا يمكنك التعديل'));
        }

        if (empty($invStockTransfer)) {
            Flash::error('عفوآ...لم يتم العثور على اذن التحويل من مخزن الى اخر');

            return redirect(route('invStockTransfers.index'));
        }

        $Inv_product = Inv_product::pluck('id')->toArray();
        $products = product_color::with([
            'get_color:name,id,colorCategory_id,color_code_id',
            'get_color.invcolor_category:name,id',
            'get_color.get_color_code:name,id',
            'get_product:name,id,category_id,system_code,manual_code',
            'get_product.invproduct_category:name,id'
        ])->whereIn('product_id',$Inv_product)->select('id','product_id','color_id')->get();
        $stores = Inv_store::pluck('name','id');
        $suppliers = suppliers::select('id','name')->get();

        $stockTransfer_details = Inv_stockTransfer_details::with(['get_product_color.get_product.get_units:name,id'])
        ->where('inv_stock_transfer_id', $invStockTransfer->id)->get();
        $product_ids = $stockTransfer_details->pluck('product_id')->toArray();
                    
        $formattedArray = [];
        foreach ($stockTransfer_details as $item) {

            $stocks = Inv_controlStock::with(['get_supplier:name,id'])
            ->whereIn('product_id', $product_ids)
            ->where('supplier_id', $item->supplier_id)
            ->selectRaw('store_id,supplier_id, (SUM(quantity_in) - SUM(quantity_out)) as sum')
            ->first();

                $totalSum = $stocks ? $stocks->sum : 0 ;
     
                $formattedArray[] = [
                    'product_id' => $item->product_id,
                    'units' => $item->get_product_color->get_product->get_units,
                    'quantity' => $item->quantity,
                    // 'total_sum' => $totalSum  + $item->quantity,
                    'total_sum' => $totalSum ,
                    'supplier_id' => $item->supplier_id,
                    'supplier_name' => $item->get_supplier->name,
                ];
        }
        
        $table_body = $formattedArray;
    
        // return $table_body;
        return view('inv__stock_transfers.edit')
        ->with([
            'invStockTransfer'=> $invStockTransfer,
            'stores'=>$stores,
            'products'=>$products,
            'suppliers'=>$suppliers,
            'table_body'=>$table_body
        ]);
    }

    /**
     * Update the specified Inv_StockTransfer in storage.
     *
     * @param int $id
     * @param UpdateInv_StockTransferRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_StockTransferRequest $request)
    {
        $invStockTransfer = $this->invStockTransferRepository->find($id);

        if (empty($invStockTransfer)) {
            Flash::error('عفوآ...لم يتم العثور على اذن التحويل من مخزن الى اخر');

            return redirect(route('invStockTransfers.index'));
        }

        try {
            // return $request;
            DB::beginTransaction();
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;
            $invStockTransfer = $this->invStockTransferRepository->update($input, $id);

            Inv_controlStock::where('invimport_export_id',$invStockTransfer->id)->where('flag', 4)->delete();
            Inv_stockTransfer_details::where('inv_stock_transfer_id',$invStockTransfer->id)->delete();
            
            $data1=[];
            $data2=[];
            for ($i=0; $i <count($request->product_id) ; $i++) { 
                // $unitcontent=Inv_ProductUnit::select('unitcontent')
                // ->where('product_id',$request->product_id[$i])
                // ->where('unit_id',$request->unit_id[$i])->first();
                $productID = product_color::select('product_id')->where('id', $request->product_id[$i])->first();
                $unitcontent=Inv_ProductUnit::select('unitcontent')
                ->where('product_id',$productID->product_id)
                ->where('unit_id',$request->unit_id[$i])->first();
                
                $total_unitcontent=$unitcontent->unitcontent*$request->quantity[$i];
                $data1[$i]=[
                    'inv_stock_transfer_id'=>$invStockTransfer->id,
                    'product_id'=>$request->product_id[$i],
                    'unit_id'=>$request->unit_id[$i],
                    'quantity'=>$total_unitcontent,
                    'supplier_id'=>$request->supplier_id[$i],
                    'store_id'=>$request->store_out,
                    'created_at'=>$invStockTransfer->created_at,
                    'updated_at'=>now(),
                ];
            }
            Inv_stockTransfer_details::insert($data1);
    
            for ($i=0; $i <count($request->product_id) ; $i++) { 
                $productID = product_color::select('product_id')->where('id', $request->product_id[$i])->first();
                $unitcontent=Inv_ProductUnit::select('unitcontent')
                ->where('product_id',$productID->product_id)
                ->where('unit_id',$request->unit_id[$i])->first();
                
                $total_unitcontent=$unitcontent->unitcontent * $request->quantity[$i];
                $data2[$i]=[
                    'invimport_export_id'=>$invStockTransfer->id,
                    'product_id'=>$request->product_id[$i],
                    'unit_id'=>$request->unit_id[$i],
                    'quantity_out'=>$total_unitcontent,
                    'supplier_id'=>$request->supplier_id[$i],
                    'store_id'=>$request->store_out,
                    'created_at'=>$invStockTransfer->created_at,
                    'updated_at'=>now(),
                    'flag'=>4
                ];
            }
            Inv_controlStock::insert($data2);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }



        Flash::success('تنبيه...تم تعديل بيانات اذن التحويل بنجاح');

        return redirect(route('invStockTransfers.index'));
    }

    /**
     * Remove the specified Inv_StockTransfer from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invStockTransfer = $this->invStockTransferRepository->find($id);

        if (empty($invStockTransfer)) {
            Flash::error('عفوآ...لم يتم العثور على اذن التحويل من مخزن الى اخر');

            return redirect(route('invStockTransfers.index'));
        }

        if($invStockTransfer->status != 'pending'){
            return redirect(route('invStockTransfers.index'))->with('error', trans('عفوا... تم تاكيد التحويل  ولا يمكنك الحذف'));
        }

        $this->invStockTransferRepository->delete($id);
        Inv_stockTransfer_details::where('inv_stock_transfer_id',$invStockTransfer->id)->delete();
        Inv_controlStock::where('invimport_export_id',$invStockTransfer->id)->delete();

        Flash::success('تنبيه...تم حذف اذن التحويل من مخزن الى اخر بنجاح');

        return redirect(route('invStockTransfers.index'));
    }

    public function find_stockTransfer(Request $request) {

        $productID = product_color::select('product_id')->where('id', $request->item_id)->first();

        $content = Inv_ProductUnit::where('product_id', $productID->product_id)
            ->where('unit_id', $request->unit_id)->first('unitcontent');
    

              $stocks = Inv_controlStock::with('get_store:name,id')
              ->where('product_id', $request->item_id)
              ->where('store_id', $request->store_out)
              ->selectRaw('store_id, SUM(quantity_in) - SUM(quantity_out) as sum')
            //   ->groupBy('store_id')
              ->get();

                for ($i = 0; $i < count($stocks); $i++) {
                    $stocks[$i]->sum = $stocks[$i]->sum / $content->unitcontent;
                }
            
                // Fetch supplier_id where product_id matches and flag is set to 1
                $suppliers = Inv_controlStock::where('product_id', $request->item_id)
                    // ->whereIn('flag',[1,5] )
                    ->where('store_id', $request->store_out)
                    ->select('supplier_id')
                    ->with('get_supplier:name,id')
                    ->distinct()
                    ->get();     
// return $suppliers;

        return [
            'stocks' => $stocks,
            'suppliers' => $suppliers,
        ];
    }


    public function get_supplier_stock(Request $request) {
 
        $productID = product_color::select('product_id')->where('id', $request->item_id)->first();
    
        $content = Inv_ProductUnit::where('product_id', $productID->product_id)
            ->where('unit_id', $request->unit_id)->first('unitcontent');

              $stocks = Inv_controlStock::with('get_store:name,id')
              ->where('product_id', $request->item_id)
              ->where('store_id', $request->store_out)
              ->where('supplier_id', $request->supplier_id)
              ->selectRaw('store_id, (SUM(quantity_in) - SUM(quantity_out)) as sum')
            //   ->groupBy('store_id')
              ->get();

        for ($i = 0; $i < count($stocks); $i++) {
            $stocks[$i]->sum = $stocks[$i]->sum / $content->unitcontent;
        }

        return $stocks;
    }
 
    public function get_store_in_data(Request $request) {
           $stores = Inv_store::select('id','name')->where('id', '!=', $request->store_out)->get();
           return $stores;
    
        }
}
