<?php

namespace App\Http\Controllers;

use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\inventory\Color;
use App\Models\inventory\Color_category;
use Illuminate\Http\Request;
use App\Models\inventory\Inv_product;
use App\Models\inventory\Inv_category;
use App\Models\inventory\Inv_store;
use App\Models\inventory\product_color;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Inv_stockControl;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\Inv_stockInDetails;
use App\Models\inventory\Inv_stockOutDetails;
use App\Models\inventory\Inv_stockOut;
// use App\Models\CRM\Model_name;
use App\Models\CRM\Cloth_residual;
use App\Models\inventory\Inv_importOrder;
use App\Models\inventory\Size;
use App\Models\inventory\Weight;
use App\Models\inventory\Brand;
use App\Models\inventory\Inv_stock_return_details;
use App\Models\inventory\InvFinalProductStock;
use App\Models\inventory\final_product;
use App\Models\inventory\Inv_productd_description;
use Illuminate\Support\Facades\DB;
class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_report()
    {
        $products = product_color::select('id','product_id','color_id')->with([
        'get_product',
        'get_color.get_color_code',
        'get_color:name,id,colorCategory_id,color_code_id',
        'get_product.invproduct_category:name,id',
        'get_color.invcolor_category:name,id'
        ])
        // ->whereHas('get_product', function ($query) {
        //     $query->where('category_id', '>', 1);
        // })
        ->get();
        $inv_stores = Inv_store::select('name','id')->get();
        // return $products ;
        return view('reports.product_report')->with(['products'=>$products , 'inv_stores'=>$inv_stores]);
    }


    public function product_report_result(Request $request){
        // return $request;
       $get_product_id = product_color::where('id',$request->product_id)->select('product_id')->first()->product_id;
       $category_type = Inv_product::where('id',$get_product_id)->select("category_id")->first()->category_id;
    //    return  $category_type;

                 $stock = Inv_controlStock::with([
                'get_product_color.get_color.invcolor_category',
                'get_product_color.get_color.get_color_code',
                'get_unit:name,id',
                'get_supplier:name,id',
                'get_store:name,id',
                // 'get_customer:name,id',
                ]);
                
                if (isset($request->supplier_id) && $request->supplier_id !== 'all') {
                    $stock = $stock->where('supplier_id', $request->supplier_id);
                }
                if ($request->product_id !== 'all') {
                    $stock = $stock->where('product_id', $request->product_id);
                }
                if ($request->store_id !=='all') {
                    $stock=$stock->where('store_id',$request->store_id);
                }
                if (isset($request->from)) {
                    $stock=$stock->where('created_at','>=',$request->from);
                }
                if (isset($request->to)) {
                    $stock=$stock->where('created_at','<=',$request->to.' 23:59:59');
                }
                $stocks=$stock->get();
                $totalQuantityIn = 0;
                $totalQuantityOut = 0;

                    $largeQuantityIn = 0;
                    $largeQuantityOut = 0;
                    $smallQuantityIn = 0;
                    $smallQuantityOut = 0;
                    $largename=null;$smallname=null;


                    foreach ($stocks as $key => $stock) {
                       

                    $stock->unit_content= Inv_ProductUnit::where('product_id',$get_product_id)->where('unit_id',$stock->unit_id)->select('unitcontent')->first()->unitcontent;
                   
                    if ($stock->unit_content > 1){
                    $stock->quantity_in= $stock->quantity_in/$stock->unit_content;
                    $stock->quantity_out= $stock->quantity_out/$stock->unit_content;
            
                    // return $stock->quantity_in;
                    $largeQuantityIn += $stock->quantity_in;
                    $largeQuantityOut += $stock->quantity_out;
                    $largename=$stock->get_unit->name;
                   }else{
                    $stock->quantity_in= $stock->quantity_in/$stock->unit_content;
                    $stock->quantity_out= $stock->quantity_out/$stock->unit_content;
            
                    // return $stock->quantity_in;
                    $smallQuantityIn += $stock->quantity_in;
                    $smallQuantityOut += $stock->quantity_out;
                    $smallname=$stock->get_unit->name;
                   }
                    }
                    $large_netQuantity = $largeQuantityIn - $largeQuantityOut;
                    $small_netQuantity = $smallQuantityIn - $smallQuantityOut;
                    // return $stocks;
                    
                    return view('reports.product_report_result')->with([
                        'stocks' => $stocks,
                        'totalQuantityIn' => $totalQuantityIn,
                        'totalQuantityOut' => $totalQuantityOut,
                        'large_netQuantity' => $large_netQuantity,
                        'small_netQuantity' => $small_netQuantity,
                        'largename' => $largename,
                        'smallname' => $smallname,
                        'request' => $request,
                       
                        // 'netQuantity' => $netQuantity,
                    ]);
           
}        
//========================================== Start reports Everything ======================================================

public function total_Products_report()
{
    $inv_stores = Inv_store::select('name','id')->get();
    $customers = Customer::select('name','id')->get();
    $suppliers = suppliers::select('name','id')->get();
    $colors = Color::with('product_color_product')->get();
    $importOrder_notes  = Inv_importOrder::whereNotNull('comment')->select('id','comment')->get();
    $cats=Inv_category::where('id','<>',1)->pluck('name','id');
    //  return $colors;
    $products = product_color::select('id','product_id','color_id')->with([
        'get_product',
        'get_color.get_color_code',
        'get_color:name,id,colorCategory_id,color_code_id',
        'get_product.invproduct_category:name,id',
        'get_color.invcolor_category:name,id'
        ])
    ->get();

// return $products ;

    return view('reports.total_reports')->with([
        'inv_stores'=>$inv_stores,
        'customers'=>$customers,
        'suppliers'=>$suppliers,
        'colors'=>$colors,
        'products'=>$products,
        'cats'=>$cats,
        'importOrder_notes'=> $importOrder_notes,
    ]);
}



public function total_Products_report_result(Request $request)
{
    // return $request;
    $stock = Inv_controlStock::with([
            'get_unit_content',
            'get_store:name,id',
            'get_unit:name,id',
            'get_supplier:name,id',
            'get_product_color.get_color:name,id,colorCategory_id,color_code_id',
            'get_product_color.get_color.invcolor_category:name,id',
            'get_product_color.get_color.get_color_code:name,id',
            'get_product_color.get_product:name,id,size_id,weight_id,category_id,manual_code,system_code,product_price',
            'get_product_color.images',
            'get_product_color.get_product.invproduct_category:name,id',
    ]);

        if ($request->store_id !=='all') {
            $stock=$stock->where('store_id',$request->store_id);
        }

        if ($request->product_id !=='all') {
            $stock=$stock->where('product_id',$request->product_id);
        }
        
        if ($request->category_id !=='all') {
            $stock = $stock->whereHas('get_product_color.get_product', function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            });
        }
        
        if ($request->supplier_id !== 'all') {
            $stock = $stock->where('supplier_id', $request->supplier_id);
        }
        if ($request->work_order_id !== 'all') {
            $stock = $stock->where('work_order_id', $request->work_order_id);

        }
        if ($request->color_id !== 'all') {
            $stock = $stock->whereHas('get_product_color', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });
        }

        if ($request->final_product_id !=='all') {
            $stock = $stock->whereHas('get_product_color.get_product', function ($query) use ($request) {
                $query->where('final_product_id', $request->final_product_id);
            });

        }

        if (isset($request->from)) {
                $result=$stock->where('created_at','>=',$request->from);
        }
        if (isset($request->to)) {
                $result=$stock->where('created_at','<=',$request->to.' 23:59:59');
        } 

        // $result=$stock->groupBy('product_id')
        // ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum ,product_id'),'store_id','invimport_export_id','unit_id','supplier_id','customer_id')
        // ->get();
        $result = $stock->select(
            'product_id',
            \DB::raw('SUM(quantity_in) - SUM(quantity_out) as sum'),'store_id','invimport_export_id','unit_id','customer_id'
        )
        ->groupBy('product_id')
        ->get();
    
    $productIds = $result->pluck('product_id');
    
    $suppliers = Inv_controlStock::whereIn('product_id', $productIds)
        ->with('get_supplier:id,name')
        ->get()
        ->groupBy('product_id');
    
    $result = $result->map(function ($item) use ($suppliers) {
        $item->suppliers = isset($suppliers[$item->product_id])
            ? $suppliers[$item->product_id]
                ->pluck('get_supplier.name')
                ->unique()
                ->values()
            : [];
        return $item;
    });
        // return $result;

        if ($request->balance !== 'all') {
            $result = $result->where('sum', '>',0);                                         
        }

// return  $result_final_product;
    return view('reports.total_reports_result')
    ->with(['result'=>$result,
            'request' => $request,
    ]); 
}

}
