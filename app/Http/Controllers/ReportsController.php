<?php

namespace App\Http\Controllers;

use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\CRM\WorkOrder;
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

        if ($request->color_id !== 'all') {
            $stock = $stock->whereHas('get_product_color', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });
        }

        // if (isset($request->from)) {
        //         $result=$stock->where('created_at','>=',$request->from);
        // }
        // if (isset($request->to)) {
        //         $result=$stock->where('created_at','<=',$request->to.' 23:59:59');
        // } 
        if ($request->filled('from')) {
            $stock->where('created_at', '>=', $request->from);
        }
        
        if ($request->filled('to')) {
            $stock->where('created_at', '<=', $request->to . ' 23:59:59');
        }

        // $result=$stock->groupBy('product_id')
        // ->select(\DB::raw('sum(quantity_in)-sum(quantity_out) as sum ,product_id'),'store_id','invimport_export_id','unit_id','supplier_id','customer_id')
        // ->get();
        $result = $stock->select('product_id',\DB::raw('SUM(quantity_in) - SUM(quantity_out) as sum'),'unit_id')->groupBy('product_id')->get();
      
        $productIds = $result->pluck('product_id');
        
        $suppliers = Inv_controlStock::whereIn('product_id', $productIds)->with('get_supplier:id,name')->get()->groupBy('product_id');
        
        $result = $result->map(function ($item) use ($suppliers) {
            $item->suppliers = isset($suppliers[$item->product_id])? $suppliers[$item->product_id]->pluck('get_supplier.name')->unique()->values(): [];
            $item->stores = isset($suppliers[$item->product_id])? $suppliers[$item->product_id]->pluck('get_store.name')->unique()->values(): [];
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


public function wash_chemical_report()
{
    $workorder = WorkOrder::select('id','customer_id')->with([
        'get_customer:name,id',
        ])
    ->get();

// return $products ;

    return view('reports.wash_chemical_report')->with([
        'workorder'=>$workorder,
    ]);
}

public function wash_chemical_report_result(Request $request)
{
    // return $request;
    // تأكد إن رقم الغسلة موجود
    if (empty($request->work_order_id)) {
        return back()->with('error', 'من فضلك ادخل رقم الغسلة');
    }

    $stockQuery = Inv_controlStock::with([
        'get_product_color.get_color.invcolor_category',
        'get_product_color.get_color.get_color_code',
        'get_product_color.get_product',
        'get_unit:id,name',
        'get_supplier:id,name',
        'get_store:id,name',
    ])

    // 🔥 أهم شرطين
    ->where('flag', 2) // صرف فقط
    ->where('work_order_id', $request->work_order_id)
    ->where('quantity_out', '>', 0); // استبعاد أي صفر

    // فلاتر إضافية (اختياري)
    if (!empty($request->supplier_id) && $request->supplier_id !== 'all') {
        $stockQuery->where('supplier_id', $request->supplier_id);
    }

    if (!empty($request->store_id) && $request->store_id !== 'all') {
        $stockQuery->where('store_id', $request->store_id);
    }

    if (!empty($request->from)) {
        $stockQuery->whereDate('created_at', '>=', $request->from);
    }

    if (!empty($request->to)) {
        $stockQuery->whereDate('created_at', '<=', $request->to);
    }

    $stocks = $stockQuery->get();

    // 🔥 تجهيز تحويل الوحدات مرة واحدة
    $productIds = $stocks->pluck('product_id')->unique();

    $unitsContent = Inv_ProductUnit::whereIn('product_id', $productIds)
        ->pluck('unitcontent', 'unit_id');

    $totalQuantityOut = 0;

    foreach ($stocks as $item) {

        $unitContent = $unitsContent[$item->unit_id] ?? 1;

        if ($unitContent == 0) {
            $unitContent = 1;
        }

        // تحويل للوحدة الكبيرة
        $item->quantity_out = $item->quantity_out / $unitContent;

        $totalQuantityOut += $item->quantity_out;
    }

    return view('reports.wash_chemical_report_result', [
        'stocks' => $stocks,
        'totalQuantityOut' => $totalQuantityOut,
        'request' => $request,
    ]);
}



// public function model_reports()
// {
//     $model = Model_name::select('model_code','id')->get();

//     return view('reports.model_reports')->with([
//         'model'=>$model,
//     ]);
// }

// public function model_reports_result(Request $request)
// {
//     // return $request;
//         $model_code= Model_name::where('id',$request->model_id)->select('model_code')->first();
//         $model = Model_name::select('model_code','id')->get();
//         $result=Inv_controlStock::
//         with([
//             'get_store:name,id',
//             'get_unit:name,id',
//             'get_model:model_code,id',
//             'get_Inv_importOrder.get_supplier:name,id',
//             // 'get_Inv_exportOrder.get_customer:name,id',
//             // 'get_Inv_exportOrder.get_spendto:name,id',
//             'get_product_color.get_color_categories:name,id',
//             'get_product_color.get_color:name,id,colorCategory_id',
//             'get_product_color.get_product:name,id,size_id,weight_id,category_id,product_price',
//             'get_product_color.get_product.get_size:name,id',
//             'get_product_color.get_product.get_weight:name,id',
//             'get_product_color.get_product.invproduct_category:name,id'
//         ]);

//         if($request->model_id !=='all'){
//             $result=$result->where('model_id',$request->model_id);
//         }       
//         $result = $result->get();
//         // return $result;

        
//         // return $model_name;
//         $result_cloth=Inv_stockOut::
//         with([
//             'get_stock_out_details.get_store:name,id',
//             'get_stock_out_details',
//             // 'get_customer:name,id',
//             'get_stock_out_details.get_product.get_color.invcolor_category:name,id',
//             'get_control_stock_to',
//         ]);

//         if($request->model_id !=='all'){
//             $result_cloth=$result_cloth->where('model_name_id',$request->model_id);
//         }       
//         $result_cloth = $result_cloth
//         ->get();
//         // return $result_cloth;

//     return view('reports.model_reports_result')
//     ->with([ 
//     'result' => $result,
//     'result_cloth' => $result_cloth,
//     'model' => $model,
//     'model_code' => $model_code,
//     ]); 


    
// }

// public function total_cloth_report()
// {
//     $inv_stores = Inv_store::select('name','id')->get();
//     $customers = Customer::select('name','id')->get();
//     $suppliers = suppliers::select('name','id')->get();

//     $colors = Color::with(['invcolor_category','product_color_cloth'])->get();
//     // return $colors;
//     $model_name = Model_name::select('model_code','id')->get();
//     $size = Size::select('name','id')->get();
//     $weight = Weight::select('name','id')->get();
//     $product = product_color:: 
//     with([
//         'get_product:name,id,category_id',
//         'get_color:name,id,colorCategory_id',
//         'get_product.invproduct_category:name,id',
//         'get_color.invcolor_category:name,id'
//     ])
//     ->get();

// // return $product ;

//     return view('reports.total_cloth_report')->with([
//         'inv_stores'=>$inv_stores,
//         'customers'=>$customers,
//         'suppliers'=>$suppliers,
//         'colors'=>$colors,
//         'model_name'=>$model_name,
//         'size'=>$size,
//         'weight'=>$weight,
//         'product'=>$product,
//     ]);
// }

public function total_cloth_report_result(Request $request)
{
if ($request->type =='with') {
 $result = Inv_stockControl::with([
    'get_store:name,id',
    'get_product.get_product',
    'get_color.get_color.invcolor_category',
    // 'get_inv_stockin_details',
    'get_inv_stockin.get_inv_stockIndetails',
    'get_customer:name,id'
    ]);

    $result=$result->groupBy('product_id','customer_id')
     ->select(\DB::raw('sum(height) AS height_sum ,count(CASE WHEN height > 0 THEN 1 ELSE NULL END) AS height_count'),'product_id','store_id','customer_id','invStock_id','supplier_id')
    ->get();
// return $result;
        if ($request->store_id !=='all') {
            $result=$result->where('store_id',$request->store_id);
        }
        if ($request->product_id !=='all') {
            $result=$result->where('product_id',$request->product_id);
        }
        if ($request->customer_id !=='all') {
            $result=$result->where('customer_id',$request->customer_id);
        }

        if ($request->supplier_id !== 'all') {
            $result = $result->where('supplier_id', $request->supplier_id);
      
        }
        if ($request->color_id !== 'all') {
            $result = $result->whereIn('get_color', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });
        }

        if ($request->colorCategory_id !== 'all') {
            $result = $result->whereIn('get_color.get_color.colorCategory_id', [$request->colorCategory_id]);

        }
        if (isset($request->from)) {
            $result=$result->where('created_at','>=',$request->from);
            }

        if (isset($request->to)) {
            $result=$result->where('created_at','<=',$request->to.' 23:59:59');
            }    
        //   return $result;
    return view('reports.total_cloth_report_result')
    ->with(['result' => $result]); 
    // =========================================================
        }else{
// ===================================================================
            $result_without = Inv_stockControl::with([
                'get_store:name,id',
                'get_product.get_product',
                'get_color.get_color.invcolor_category',
                // 'get_inv_stockin_details',
                'get_inv_stockin.get_inv_stockIndetails',
                'get_customer:name,id'
            ]);

                $result_without=$result_without->where('height', Null)
                ->select('invStock_id','product_id','store_id','customer_id','supplier_id')->distinct()
                ->get();
            // return $result_without;
            if ($request->store_id !=='all') {
                $result_without=$result_without->where('store_id',$request->store_id);
            }
            if ($request->product_id !=='all') {
                $result_without=$result_without->where('product_id',$request->product_id);
            }
            if ($request->customer_id !=='all') {
                $result_without=$result_without->where('customer_id',$request->customer_id);
            }
    
            if ($request->supplier_id !== 'all') {
                $result_without = $result_without->where('supplier_id', $request->supplier_id);
          
            }
            if ($request->color_id !== 'all') {
                $result_without = $result_without->whereIn('get_color', function ($query) use ($request) {
                    $query->where('color_id', $request->color_id);
                });
            }
    
            if ($request->colorCategory_id !== 'all') {
                $result_without = $result_without->whereIn('get_color.get_color.colorCategory_id', [$request->colorCategory_id]);
    
            }
            if (isset($request->from)) {
                $result_without=$result_without->where('created_at','>=',$request->from);
                }
    
            if (isset($request->to)) {
                $result_without=$result_without->where('created_at','<=',$request->to.' 23:59:59');
                }    

            return view('reports.total_cloth_report_result')
            ->with(['result_without' => $result_without]); 

        }
    
}

// public function residual_reports()
// {
//     // $cloth_residual = Cloth_residual::select('name','id')->get();
//     $model = Model_name::select('model_code','id')->get();

//     return view('reports.residual_reports')->with([
//         'model'=>$model,
//     ]);
 
// }

// public function residual_reports_result(Request $request)
// {
//     $cloth_residual = Cloth_residual::with(['get_model_name:model_code,id','get_color_id:name,id',
//     'get_product_color.get_product.invproduct_category:name,id',
//     'get_product_color.get_color.invcolor_category:name,id',
//     'get_thread_out.get_product.invproduct_category:name,id',
//     'get_thread_out.get_color.invcolor_category:name,id',
//     ])
//     ->where('model_id', $request->model_id)->get();

//     // return $cloth_residual;
//     return view('reports.residual_reports_result')->with([
//         'cloth_residual'=>$cloth_residual,
//     ]);

// }

}
