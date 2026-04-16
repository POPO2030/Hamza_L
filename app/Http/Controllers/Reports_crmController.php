<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRM\Model_name;
use App\Models\inventory\product_color;
use App\Models\inventory\InvFinalProductStock;
use App\Models\inventory\final_product;
use App\Models\CRM\Line;
use App\Models\CRM\Stages;
use App\Models\CRM\Cartila_accessory;
use App\Models\CRM\Model_cloth_thread;
use App\Models\CRM\Customer;
use App\Models\CRM\suppliers;
use App\Models\CRM\ProductionActivity;
use App\Models\CRM\Quality_defects;
use App\Models\CRM\ProductionQualityControl;
use App\Models\CRM\Service;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\WorkOrder;
use App\Models\sales\Customer_details;
use App\Models\sales\Supplier_details;
use App\Models\sales\Treasury_details;
use App\Models\accounting\Invoice_details;
use App\Models\accounting\Invoice;
use App\Models\accounting\Invoice_service_prices;
use App\Models\sales\Seller;
use App\Models\sales\Region;
use App\Models\sales\Shop;
use Illuminate\Support\Collection;
use Flash;
use DB;
use Carbon\Carbon;

class Reports_crmController extends Controller
{

public function customer_account_report()
{
    $customer = Customer::select('name','id','customer_code')->get();

    return view('reports_crm.customer_account_report')->with([
        'customer'=>$customer,
    ]);
}

public function customer_account_result(Request $request)
{

    $customer_name= Customer::where('id',$request->customer_id)->select('name','id')->first();
    // $customer_account_credit = Customer_details::where('customer_id', $request->customer_id)->sum('cash_balance_credit');
    // $customer_account_debit = Customer_details::where('customer_id', $request->customer_id)->sum('cash_balance_debit');
    // $customer_credit_debit = $customer_account_credit - $customer_account_debit ;
    $balance_before_period_query = Customer_details::where('customer_id', $request->customer_id)->orderBy('date');

    if (isset($request->from)) {
        $balance_before_period_query->whereDate('date', '<', $request->from);
    }
    
    $balance_before_period = $balance_before_period_query
        ->selectRaw('SUM(cash_balance_credit) as credit, SUM(cash_balance_debit) as debit')
        ->first();
    
        if (!isset($request->from)){
            $check=Customer_details::where('customer_id', $request->customer_id)->where('payment_type_id',4)->first();
            if($check){
                $customer_balance_first_period = ($check->cash_balance_debit ?? 0) - ($check->cash_balance_credit ?? 0);
            }else{
                $customer_balance_first_period = 0;
            }
        }else{
            $customer_balance_first_period = ($balance_before_period->debit ?? 0) - ($balance_before_period->credit ?? 0);
        }


        $customer_all_details = Customer_details::where('customer_id', $request->customer_id);

        // Check if we should ignore payment_type_id filter
        $shouldIgnorePaymentFilter = false;
        
        if (isset($request->from)) {
            // Check if any record with payment_type_id = 4 has date >= $request->from
            $hasPaymentType4AfterFromDate = Customer_details::where('customer_id', $request->customer_id)
                ->where('payment_type_id', 4)
                ->whereDate('date', '>=', $request->from)
                ->exists();
        
            // If such a record exists, ignore the payment_type_id filter
            $shouldIgnorePaymentFilter = $hasPaymentType4AfterFromDate;
        }
        
        // Apply payment_type_id filter only if we shouldn't ignore it
        if (!$shouldIgnorePaymentFilter) {
            $customer_all_details = $customer_all_details->where(function($query) {
                $query->where('payment_type_id', '!=', 4)
                      ->orWhereNull('payment_type_id');
            });
        }
        
        // Continue with the rest of the query
        $customer_all_details = $customer_all_details->with([
            'get_customer:name,id',
            'get_invoice_details' => function ($query) use ($request) {
                if (isset($request->from)) {
                    $query->whereDate('date', '>=', $request->from);
                }
                if (isset($request->to)) {
                    $query->whereDate('date', '<=', $request->to);
                }
                $query->with([
                    'get_work_order.get_products:name,id',
                    'get_work_order.get_receivables:name,id',
                    'get_work_order.get_ReceiveReceipt:product_type,id,model'
                ]);
            }
        ]);
        
        // Apply date filters to main query
        if (isset($request->from)) {
            $customer_all_details = $customer_all_details->whereDate('date', '>=', $request->from);
        }
        
        if (isset($request->to)) {
            $customer_all_details = $customer_all_details->whereDate('date', '<=', $request->to);
        }
        
        // Sort by date ascending
        $customer_details = $customer_all_details->orderBy('date', 'asc')->get();

// return  $customer_details;
    return view('reports_crm.customer_account_result')
    ->with([ 
        'customer_name' => $customer_name,
        'customer_balance_first_period' => $customer_balance_first_period,
        'customer_details' => $customer_details,
        'request' => $request,
        ]); 
}


public function  redirect_customer_account_result($customer_id,$from=null,$to=null){


    $customer_name= Customer::where('id',$customer_id)->select('name','id')->first();
    $balance_before_period_query = Customer_details::where('customer_id', $customer_id)->orderBy('date');

    if (isset($from)) {
        $balance_before_period_query->whereDate('date', '<', $from);
    }
    
    $balance_before_period = $balance_before_period_query
        ->selectRaw('SUM(cash_balance_credit) as credit, SUM(cash_balance_debit) as debit')
        ->first();
    
        if (!isset($from)){
            $check=Customer_details::where('customer_id', $customer_id)->where('payment_type_id',4)->first();
            if($check){
                $customer_balance_first_period = ($check->cash_balance_debit ?? 0) - ($check->cash_balance_credit ?? 0);
            }else{
                $customer_balance_first_period = 0;
            }
        }else{
            $customer_balance_first_period = ($balance_before_period->debit ?? 0) - ($balance_before_period->credit ?? 0);
        }

        $customer_all_details = Customer_details::where('customer_id', $customer_id);

        // Check if we should ignore payment_type_id filter
        $shouldIgnorePaymentFilter = false;
        
        if (isset($from)) {
            // Check if any record with payment_type_id = 4 has date >= $request->from
            $hasPaymentType4AfterFromDate = Customer_details::where('customer_id', $customer_id)
                ->where('payment_type_id', 4)
                ->whereDate('date', '>=', $from)
                ->exists();
        
            // If such a record exists, ignore the payment_type_id filter
            $shouldIgnorePaymentFilter = $hasPaymentType4AfterFromDate;
        }
        
        // Apply payment_type_id filter only if we shouldn't ignore it
        if (!$shouldIgnorePaymentFilter) {
            $customer_all_details = $customer_all_details->where(function($query) {
                $query->where('payment_type_id', '!=', 4)
                      ->orWhereNull('payment_type_id');
            });
        }
        
        // Continue with the rest of the query
        $customer_all_details = $customer_all_details->with([
            'get_customer:name,id',
            'get_invoice_details' => function ($query) use ($from , $to) {
                if (isset($from)) {
                    $query->whereDate('date', '>=', $from);
                }
                if (isset($to)) {
                    $query->whereDate('date', '<=', $to);
                }
                $query->with([
                    'get_work_order.get_products:name,id',
                    'get_work_order.get_receivables:name,id',
                    'get_work_order.get_ReceiveReceipt:product_type,id,model'
                ]);
            }
        ]);
        
        // Apply date filters to main query
        if (isset($from)) {
            $customer_all_details = $customer_all_details->whereDate('date', '>=', $from);
        }
        
        if (isset($to)) {
            $customer_all_details = $customer_all_details->whereDate('date', '<=', $to);
        }
        
        // Sort by date ascending
        $customer_details = $customer_all_details->orderBy('date', 'asc')->get();


    $from_to=[
        'from'=>$from,
        'to'=>$to,
    ];
    // $customer_details= Customer_details::with(['get_customer:name,id','get_payment_type:name,id'])->where('customer_id', $customer_id)->get();
    return view('reports_crm.customer_account_result')
    ->with([ 
        'customer_name' => $customer_name,
        'customer_balance_first_period' => $customer_balance_first_period,
        'customer_details' => $customer_details,
        'request' => $from_to,
        ]); 
}


public function  customer_account_report_detail(Request $request){

    $balance_before_period_query = Customer_details::where('customer_id', $request->customer_id)->orderBy('date');

    if (isset($request->from)) {
        $balance_before_period_query->whereDate('date', '<', $request->from);
    }
    
    $balance_before_period = $balance_before_period_query
        ->selectRaw('SUM(cash_balance_credit) as credit, SUM(cash_balance_debit) as debit')
        ->first();

    if (!isset($request->from)){
        $check=Customer_details::where('customer_id', $request->customer_id)->where('payment_type_id',4)->first();
        if($check){
            $customer_balance_first_period = ($check->cash_balance_debit ?? 0) - ($check->cash_balance_credit ?? 0);
        }else{
            $customer_balance_first_period = 0;
        }
    }else{
        $customer_balance_first_period = ($balance_before_period->debit ?? 0) - ($balance_before_period->credit ?? 0);
    }
   


    // Get customer name
    $customer_id = $request->customer_id;
    $customer_name = Customer_details::where('customer_id', $customer_id)
        ->with('get_customer:name,id')
        ->first();

    if ($customer_name) {
        $customer_name = $customer_name->get_customer->name;
    }

    // Main customer details query

    $customer_all_details = Customer_details::where('customer_id', $customer_id);

    // Check if we should ignore payment_type_id filter
    $shouldIgnorePaymentFilter = false;
    
    if (isset($request->from)) {
        // Check if any record with payment_type_id = 4 has date >= $request->from
        $hasPaymentType4AfterFromDate = Customer_details::where('customer_id', $customer_id)
            ->where('payment_type_id', 4)
            ->whereDate('date', '>=', $request->from)
            ->exists();
    
        // If such a record exists, ignore the payment_type_id filter
        $shouldIgnorePaymentFilter = $hasPaymentType4AfterFromDate;
    }
    
    // Apply payment_type_id filter only if we shouldn't ignore it
    if (!$shouldIgnorePaymentFilter) {
        $customer_all_details = $customer_all_details->where(function($query) {
            $query->where('payment_type_id', '!=', 4)
                  ->orWhereNull('payment_type_id');
        });
    }
    
    // Continue with the rest of the query
    $customer_all_details = $customer_all_details->with([
        'get_customer:name,id',
        'get_invoice',
        'get_invoice_details' => function ($query) use ($request) {
            if (isset($request->from)) {
                $query->whereDate('date', '>=', $request->from);
            }
            if (isset($request->to)) {
                $query->whereDate('date', '<=', $request->to);
            }
           
            // $query->with([
            //     'get_work_order.get_products:name,id',
            //     'get_work_order.get_receivables:name,id',
            //     'get_work_order.get_ReceiveReceipt:product_type,id,model'
            // ]);
        },
        'get_invoice_details.get_invoice_services.get_service_item:name,id',
    ]);
    
    // Apply date filters to main query
    if (isset($request->from)) {
        $customer_all_details = $customer_all_details->whereDate('date', '>=', $request->from);
    }
    
    if (isset($request->to)) {
        $customer_all_details = $customer_all_details->whereDate('date', '<=', $request->to);
    }


    // Sort by date ascending before getting
    $customer_all_details = $customer_all_details->orderBy('date', 'asc')->get();

    // بعدها نحمل علاقات work_order يدويًا حسب season
    foreach ($customer_all_details as $detail) {
        foreach ($detail->get_invoice_details as $invoice_detail) {
            $season = $invoice_detail->get_invoice->season ?? 'new';
            $connection = $season === 'new' ? 'mysql_new' : 'mysql_old';

            $workOrder = \App\Models\CRM\WorkOrder::on($connection)
                ->with([
                    'get_products:name,id',
                    'get_receivables:name,id',
                    'get_ReceiveReceipt:product_type,id,model',
                ])
                ->find($invoice_detail->work_order_id);

            $invoice_detail->setRelation('get_work_order', $workOrder);
        }
    }

// return $customer_all_details;
    // Get service categories
    // $service_ids_water = Service::where('service_category_id', 1)->pluck('id')->toArray(); // الخدمات المائية
    // $service_ids_dry = Service::where('service_category_id', 2)->pluck('id')->toArray();   // الخدمات الجافة

    // // Enrich each item with service details
    // foreach ($customer_all_details as $order) {
    //     if ($order->get_invoice_details != null) {
    //         foreach ($order->get_invoice_details as $item) {
    //             $work_order = $item->get_work_order;

    //             if ($work_order) {
    //                 $service_item_ids = Work_order_stage::where('work_order_id', $work_order->id)
    //                     ->pluck('service_item_satge_id')
    //                     ->toArray();

    //                 $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
    //                     ->distinct()
    //                     ->pluck('service_item_id')
    //                     ->toArray();

    //                 $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
    //                     ->whereIn('service_id', $service_ids_water)
    //                     ->get(); // غسيل

    //                 $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
    //                     ->whereIn('service_id', $service_ids_dry)
    //                     ->get(); // فاشون

    //                 // Attach to current item
    //                 $item->service_item_with_kilo = $service_item_with_kilo;
    //                 $item->service_item_with_unit = $service_item_with_unit;
    //             }
    //         }
    //     }
    // }
       
        // return $customer_all_details;
 
    return view('reports_crm.customer_account_report_detail')
    ->with([ 
        'customer_all_details' => $customer_all_details,
        'request' => $request,
        'customer_balance_first_period' => $customer_balance_first_period,
        'customer_name' => $customer_name,

        ]); 
}


public function customer_account_report_discount(Request $request)
{
    $query = Customer_details::with(['get_customer:id,name,phone'])
        ->where('payment_type_id', 10);

    if (!empty($request->from)) {
        $query->whereDate('date', '>=', $request->from);
    }

    if (!empty($request->to)) {
        $query->whereDate('date', '<=', $request->to);
    }

    if (!empty($request->customer_id) && $request->customer_id !== 'all') {
        // عميل محدد
        $discounts = $query->where('customer_id', $request->customer_id)
                           ->orderBy('date')
                           ->get();
        $customer_name = $discounts->first()?->get_customer ?? null;

        return view('reports_crm.customer_account_report_discount')
            ->with([
                'discounts' => $discounts,
                'customer_name' => $customer_name,
                'request' => $request,
            ]);

    } else {
        // البحث على الكل
        $discounts = $query->orderBy('customer_id')
                           ->orderBy('date')
                           ->get()
                           ->groupBy('customer_id');

        return view('reports_crm.customer_account_report_discount')
            ->with([
                'discounts' => $discounts,
                'request' => $request,
            ]);
    }
}



public function customer_statement_result(Request $request)
{
    // return $request;
    $result = Customer_details::with(['get_customer:name,phone,id'])
        ->select('customer_id')
        ->selectRaw('SUM(cash_balance_credit) as sum_cash_balance_credit')
        ->selectRaw('SUM(cash_balance_debit) as sum_cash_balance_debit')
        ->havingRaw('SUM(cash_balance_credit) > 0 OR SUM(cash_balance_debit) > 0')
        ->groupBy('customer_id');

        if (isset($request->from)) {
            $result = $result->whereDate('date', '>=', $request->from);
        }
        
        if (isset($request->to)) {
            $result = $result->whereDate('date', '<=', $request->to);
        }

        $result = $result->get();
// return  $result;
    return view('reports_crm.customer_statement_result')->with(['result' => $result]); 
}

// public function customer_account_client_payments_result(Request $request,$id)
// {
    
//     $customer_detail = Customer_details::with('get_treasury_details')->where('customer_id', $id)->get();
//     $customer_name = Customer_details::with('get_customer:name,id','get_payment_type:name,id')->where('customer_id', $id)->first();
// return $customer_name;
//     return view('reports_crm.customer_account_client_payments_result')
//     ->with([ 'customer_detail' => $customer_detail,'customer_name' => $customer_name,]); 
// }

public function supplier_account_report()
{
    $supplier = suppliers::select('name','id')->get();
    return view('reports_crm.supplier_account_report')->with([
        'supplier'=>$supplier,
    ]);
}

public function supplier_account_result(Request $request)
{
    $supplier_name= suppliers::where('id',$request->supplier_id)->select('name')->first();
    $supplier_account_credit = Supplier_details::where('supplier_id', $request->supplier_id)->sum('cash_balance_credit');
    $supplier_account_debit = Supplier_details::where('supplier_id', $request->supplier_id)->sum('cash_balance_debit');
    $supplier_credit_debit = $supplier_account_credit - $supplier_account_debit ;
    $supplier_detail = Supplier_details::with(['get_treasury_details','get_payment_type'])->where('supplier_id', $request->supplier_id)->get();

// return  $supplier_detail;
    return view('reports_crm.supplier_account_result')
    ->with([ 
        'supplier_name' => $supplier_name,
        'supplier_account_credit' => $supplier_account_credit,
        'supplier_account_debit' => $supplier_account_debit,
        'supplier_credit_debit' => $supplier_credit_debit,
        'supplier_detail' => $supplier_detail,
        ]); 
}

public function treasuries_report()
{
    $treasury_details = Treasury_details::select('created_at','id')->get();
    return view('reports_crm.treasuries_report')
    ->with(['treasury_details'=>$treasury_details]);
}

public function treasuries_report_result(Request $request)
{
    $result = Treasury_details::with(['get_treasury:name,id'])->where('payment_type_id', 2);
    if (isset($request->from)) {
        $result=$result->where('created_at','>=',$request->from);
        }
    if (isset($request->to)) {
        $result=$result->where('created_at','<=',$request->to.' 23:59:59');
        }    

    $result = $result->get();
// return $result;
    return view('reports_crm.treasuries_report_result')
    ->with([ 
        'result' => $result,
        'date_from' => $request->from,
        'date_to' => $request->to,
        ]); 
}


public function invoice_report()
{

    $invoices = Invoice::select('id')->get();
    $customers = Customer::select('name','id')->get();
// return $invoices ;
    return view('reports_crm.invoice_report')->with(['customers'=>$customers,'invoices'=>$invoices]);
}

public function invoice_report_result(Request $request)
{

    // return $request;

    $result = Invoice::with([
        'get_invoice_details.get_work_order_count',
        'get_customer:name,id',
        'get_invoice_details.get_invoice_services.get_service_item:name,id',
    ]);
    

    // if ($request->branch !=='all') {
    //     $result=$result->where('branch',$request->branch);
    // }

    if ($request->customer_id !=='all') {
        $result = $result->where('customer_id', $request->customer_id);
    }

    if (isset($request->from)) {
        $result = $result->whereDate('date', '>=', $request->from);
    }
    
    if (isset($request->to)) {
        $result = $result->whereDate('date', '<=', $request->to);
    }

    $result = $result->get();

    $totalWashing = 0;
    $totalFashion = 0;
    $totalDiscounts = 0;
    $totalTax = 0;
    $totalDiscountNotice = 0;
    $totalNetAmount = 0;
    
    foreach ($result as $invoice) {
        // Add invoice-level values
        $totalDiscounts += $invoice->amount_minus;
        $totalTax += $invoice->tax;
        $totalDiscountNotice += $invoice->discount_notice;
        $totalNetAmount += $invoice->amount_net;
        
        // Calculate service-specific totals
        foreach ($invoice->get_invoice_details as $detail) {
            foreach ($detail->get_invoice_services as $service) {
                if ($service->service_id == 1) {
                    $totalWashing += ($service->service_price * $detail->total_kg);
                } elseif ($service->service_id == 2) {
                    $totalFashion += ($service->service_price * $detail->total_qty);
                }
            }
        }
    }
   
// return $result;

//    try {
//     DB::beginTransaction();

//     $x = Invoice_details::with('get_work_order_count')->get();

//     $service_ids_water = Service::where('service_category_id', 1)->pluck('id')->toArray(); // Water services
//     $service_ids_dry = Service::where('service_category_id', 2)->pluck('id')->toArray();   // Dry services
    
//     foreach($x as $item) {
//         $work_order = $item->get_work_order_count;

//         if ($work_order) {
//             $service_item_ids = Work_order_stage::where('work_order_id', $work_order->id)
//                 ->pluck('service_item_satge_id')
//                 ->toArray();

//             $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
//                 ->distinct()
//                 ->pluck('service_item_id')
//                 ->toArray();

//             $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
//                 ->whereIn('service_id', $service_ids_water)
//                 ->get(); // Washing

//             $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
//                 ->whereIn('service_id', $service_ids_dry)
//                 ->get(); // Fashion

//             $item->service_item_with_kilo = $service_item_with_kilo;
//             $item->service_item_with_unit = $service_item_with_unit;
//         }
//     }

//     foreach($x as $data) {
//         // Check if service_item_with_kilo exists and has items
//         if (isset($data->service_item_with_kilo) && count($data->service_item_with_kilo)) {
//             foreach($data->service_item_with_kilo as $item) {
//                 Invoice_service_prices::create([
//                     'invoice_id' => $data->invoice_id,
//                     'invoice_details_id' => $data->id,
//                     'final_deliver_order_id' => $data->final_deliver_order_id,
//                     'work_order_id' => $data->work_order_id,
//                     'service_item_id' => $item->id,
//                     'service_id' => 1,
//                     'service_price' => $item->money,
//                 ]);
//             }
//         }

//         // Check if service_item_with_unit exists and has items
//         if (isset($data->service_item_with_unit) && count($data->service_item_with_unit)) {
//             foreach($data->service_item_with_unit as $item) {
//                 Invoice_service_prices::create([
//                     'invoice_id' => $data->invoice_id,
//                     'invoice_details_id' => $data->id,
//                     'final_deliver_order_id' => $data->final_deliver_order_id,
//                     'work_order_id' => $data->work_order_id,
//                     'service_item_id' => $item->id,
//                     'service_id' => 2,
//                     'service_price' => $item->money,
//                 ]);
//             }
//         }
//     }
   
//     DB::commit();
// } catch (\Throwable $th) {
//     DB::rollBack();
//     throw $th;
// }

// return 'done';
    
    return view('reports_crm.invoice_report_result')->with([ 
        'result' => $result,
        'request' => $request,
        'totalWashing' => $totalWashing,
        'totalFashion' => $totalFashion,
        'totalDiscounts' => $totalDiscounts,
        'totalTax' => $totalTax,
        'totalDiscountNotice' => $totalDiscountNotice,
        'totalNetAmount' => $totalNetAmount,
    ]); 
}

    public function service_prices_report()
    {
        $customers = Customer::select('name','id')->get();
        $services = ServiceItem::select('name','id')->get();

        return view('reports_crm.service_prices_report')->with(['customers'=>$customers,'services'=>$services]);
    }



    public function service_prices_report_result(Request $request)
    {
        
        $withRelations = [
            'get_customer:name,id',
        ];

        if ($request->has('service_item_id') && $request->service_item_id !== 'all') {
            $withRelations['get_invoice_details'] = function ($detailQuery) use ($request) {
                $detailQuery->whereHas('get_invoice_services', function ($serviceQuery) use ($request) {
                    $serviceQuery->where('service_item_id', $request->service_item_id);
                })->with(['get_invoice_services' => function ($serviceQuery) use ($request) {
                    $serviceQuery->where('service_item_id', $request->service_item_id)->with('get_service_item:name,id');
                }]);
            };
        } else {
            $withRelations[] = 'get_invoice_details.get_invoice_services.get_service_item:name,id';
        }

        $query = Invoice::with($withRelations);


        // if ($request->branch !== 'all') {
        //     $query->where('branch', $request->branch);
        // }

        if ($request->customer_id !== 'all') {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('service_item_id') && $request->service_item_id !== 'all') {
            $query->whereHas('get_invoice_details', function ($detailQuery) use ($request) {
                $detailQuery->whereHas('get_invoice_services', function ($serviceQuery) use ($request) {
                    $serviceQuery->where('service_item_id', $request->service_item_id);
                });
            });
        }

        if (isset($request->from)) {
            $query->whereDate('date', '>=', $request->from);
        }

        if (isset($request->to)) {
            $query->whereDate('date', '<=', $request->to);
        }

        // if ($request->has('service_item_id') && $request->service_item_id !== 'all') {
            // $query->orderBy('date', 'asc'); 
        // }

        $results = $query->orderBy('date', 'asc')->get();
        $output = [];
        $counter = 1;
        $grandTotal = 0;
        
        foreach ($results as $invoice) {
            $serviceItems = [];
        
            foreach ($invoice->get_invoice_details as $detail) {
                // Precompute water service count and additional services sum PER DETAIL
                $countWaterServices = 0;
                $additionalServicesSum = 0;
                $servicesInDetail = $detail->get_invoice_services;
                
                foreach ($servicesInDetail as $s) {
                    if ($s->service_id == 1) {
                        $countWaterServices++;
                    } elseif ($s->service_id == 2) {
                        $additionalServicesSum += $s->service_price;
                    }
                }
                
                foreach ($servicesInDetail as $service) {
                    $serviceItemId = $service->service_item_id;
                    $itemKey = $invoice->calculation_method === 'piece' ? $service->id : $serviceItemId;
        
                    if (!isset($serviceItems[$itemKey])) {
                        $serviceItems[$itemKey] = [
                            'counter' => $counter++,
                            'service_item' => $service->get_service_item,
                            'service_id' => $service->service_id,
                            'total_qty' => 0,
                            'total_kg' => 0,
                            'total' => 0,
                            'price' => $service->service_price,
                            'repetition' => 0,
                            'invoice_id' => $invoice->id,
                            // 'branch' => $invoice->branch == 1 ? 'جسر السويس' : 
                            //             ($invoice->branch == 2 ? 'بلقس' : 'غير معروف'),
                            'customer_name' => $invoice->get_customer->name,
                            'date' => $invoice->date->format('Y-m-d'),
                            'calculation_method' => $invoice->calculation_method
                        ];
                    }
        
                    $serviceItems[$itemKey]['repetition']++;
        
                    if ($invoice->calculation_method === 'kilo') {
                        if ($service->service_id == 1) {
                            $serviceItems[$itemKey]['total_kg'] += $detail->total_kg;
                            $serviceItems[$itemKey]['total'] += $detail->total_kg * $service->service_price;
                        } else {
                            $serviceItems[$itemKey]['total_qty'] += $detail->total_qty;
                            $serviceItems[$itemKey]['total'] += $detail->total_qty * $service->service_price;
                        }
                    } else { 
                        $serviceItems[$itemKey]['total_qty'] = $detail->total_qty;
                        
                        // FIXED: Properly handle multiple water services
                        if ($service->service_id == 1) {
                            $basePrice = $detail->piece_price - $additionalServicesSum;
                            $pricePerService = $countWaterServices > 0 ? ($basePrice / $countWaterServices) : 0;
                            $serviceItems[$itemKey]['price'] = $pricePerService;
                            $serviceItems[$itemKey]['total'] = $detail->total_qty * $pricePerService;
                        } else {
                            $serviceItems[$itemKey]['price'] = $service->service_price;
                            $serviceItems[$itemKey]['total'] = $detail->total_qty * $service->service_price;
                        }
                    }
        
                    if ($invoice->calculation_method === 'kilo') {
                        $serviceItems[$itemKey]['quantity'] = ($service->service_id == 1) 
                            ? $serviceItems[$itemKey]['total_kg'] 
                            : $serviceItems[$itemKey]['total_qty'];
                    } else {
                        $serviceItems[$itemKey]['quantity'] = $serviceItems[$itemKey]['total_qty'];
                    }
                }
            }
        
            // Calculate grand total
            foreach ($serviceItems as $item) {
                $grandTotal += $item['total'];
            }
        
            $output = array_merge($output, array_values($serviceItems));
        }
        
        return view('reports_crm.service_prices_report_result', [
            'processedResults' => $output,
            'grandTotal' => $grandTotal
        ]);
    }







}







