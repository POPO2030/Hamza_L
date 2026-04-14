<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRM\Stage;
use App\Models\CRM\Activity;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\FinalDeliver;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\satge_category;
use App\Models\CRM\Service;
use App\Models\CRM\ServiceItemSatge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
{
       

    Carbon::setWeekStartsAt(Carbon::SATURDAY);
    Carbon::setWeekEndsAt(Carbon::THURSDAY);
    
    $firstDayOfWeek = Carbon::now()->startOfWeek();
    $lastDayOfWeek = Carbon::now()->endOfWeek();


   $service_ids= Service::where('service_category_id',1)->pluck('id')->toArray();   // الخدمات المائية
   $service_item_ids= ServiceItem::whereIn('service_id',$service_ids)->pluck('id')->toArray();       //الخدمات  نفسها سواء غسيل او جينز او صباغة
   
   $stage_dyeing_ids=Stage::where('stage_category_id',7)->pluck('id')->toArray();          //المراحل التى تحتوى على صباغة فقط
   $stage_jeans_ids=Stage::whereIn('stage_category_id',[1,2,3,5,6])->pluck('id')->toArray();          //المراحل التى تحتوى على الجينز فقط وليس صباغة
   $stage_washing_ids=Stage::where('stage_category_id',4)->pluck('id')->toArray();          //المراحل التى تحتوى على غسيل فقط 
    
   $stage_ids=Stage::whereIn('stage_category_id',[1,2,3,4,5,6,7])->pluck('id')->toArray();  // المراحل التى تحتوى على غسيل وصباغة وجينز
   $service_item_stage_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_ids)->pluck('id')->toArray();
   $work_order_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();

//    $total_count_of_workOrders = WorkOrder::whereIn('id', $work_order_ids)->select(\DB::raw('SUM(product_count) as total'))->first()->total;

    $ideal_customer = WorkOrder::whereIn('id', $work_order_ids)
    ->with('get_customer:name,id')
    ->select('customer_id', \DB::raw('SUM(product_count) as total_count'))
    ->groupBy('customer_id')
    ->havingRaw('COUNT(*) > 1')
    ->orderByDesc('total_count')
    ->limit(1)
    ->first();

    if(isset($ideal_customer)){
        $ideal_customer= $ideal_customer->total_count;
    }else{
        $ideal_customer=0;
    }

   $top_ten_customer = WorkOrder::whereIn('id', $work_order_ids)
   ->with('get_customer:name,id')
   ->select('customer_id', \DB::raw('SUM(product_count) as total_count'))
   ->groupBy('customer_id')
   ->havingRaw('COUNT(*) > 1')
   ->orderByDesc('total_count')
   ->limit(10)
   ->get();

   $ratios_customers = [];
   foreach ($top_ten_customer as $customer) {
       $customer_total = $customer->total_count;
       if($customer_total == 0){
        $ratios_customers[$customer->get_customer->name] = 0;
       }else{
        $customer_ratio = ($customer_total / $ideal_customer)*100;
       
        $ratios_customers[$customer->get_customer->name] = round($customer_ratio,2);
       }
   }
   
//    return $ratios_customers;

// ------------------------------------------------------------------------------  بداية متوسط عدد الوجبات صباغة فى الاسبوع  ---------------------------------------------------------------------------------------------
   $service_item_stage_dyeing_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_dyeing_ids)->pluck('id')->toArray();
   $work_order_dyeig_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_dyeing_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
   $work_orders_dyeig = WorkOrder::whereIn('id',$work_order_dyeig_ids)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->get();

   $totalQuantity_dyeing = $work_orders_dyeig->sum('product_count');
   $workOrderCount_dyenig = $work_orders_dyeig->count();
   $averageQuantity_dyeing = $workOrderCount_dyenig > 0 ? $totalQuantity_dyeing / $workOrderCount_dyenig : 0;   //متوسط كمية الصباغة اسبوعيا

   $top_ten_customer_dyeing = WorkOrder::whereIn('id', $work_order_dyeig_ids)
   ->with('get_customer:name,id')
   ->select('customer_id', \DB::raw('SUM(product_count) as total_count'))
   ->groupBy('customer_id')
   ->havingRaw('COUNT(*) > 1')
   ->orderByDesc('total_count')
   ->limit(10)
   ->get();
    // return $top_ten_customer_dyeing;
// ------------------------------------------------------------------------------  نهاية متوسط عدد الوجبات صباغة فى الاسبوع  ---------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------  بداية متوسط عدد الوجبات جينز فى الاسبوع  ---------------------------------------------------------------------------------------------
   $service_item_stage_jeans_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_jeans_ids)->pluck('id')->toArray();
   $work_order_jeans_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_jeans_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
   $work_orders_jeans = WorkOrder::whereIn('id',$work_order_jeans_ids)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->get();


   $totalQuantity_jeans = $work_orders_jeans->sum('product_count');
   $workOrderCount_jeans = $work_orders_jeans->count();
   $averageQuantity_jeans = $workOrderCount_jeans > 0 ? $totalQuantity_jeans / $workOrderCount_jeans : 0;   //متوسط كمية الجينز اسبوعيا

   $top_ten_customer_jeans = WorkOrder::whereIn('id',$work_order_jeans_ids)
   ->with('get_customer:name,id')
   ->select('customer_id', \DB::raw('SUM(product_count) as total_count'))
   ->groupBy('customer_id')
   ->havingRaw('COUNT(*) > 1')
   ->orderByDesc('total_count')
   ->limit(10)
   ->get();
    // return $top_ten_customer_jeans;
// ------------------------------------------------------------------------------  نهاية متوسط عدد الوجبات جينز فى الاسبوع  ---------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------  بداية متوسط عدد الوجبات الغسيل فى الاسبوع  ---------------------------------------------------------------------------------------------
   $service_item_stage_washing_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_washing_ids)->pluck('id')->toArray();
   $work_order_washing_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_washing_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
   $work_orders_washing = WorkOrder::whereIn('id',$work_order_washing_ids)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->get();


   $totalQuantity_washing = $work_orders_washing->sum('product_count');
   $workOrderCount_washing = $work_orders_washing->count();
   $averageQuantity_washing = $workOrderCount_washing > 0 ? $totalQuantity_washing / $workOrderCount_washing : 0;   //متوسط كمية الغسيل اسبوعيا

   
   $top_ten_customer_washing = WorkOrder::whereIn('id',$work_order_washing_ids)
   ->with('get_customer:name,id')
   ->select('customer_id', \DB::raw('SUM(product_count) as total_count'))
   ->groupBy('customer_id')
   ->havingRaw('COUNT(*) > 1')
   ->orderByDesc('total_count')
   ->limit(10)
   ->get();
    // return $top_ten_customer_washing;
// ------------------------------------------------------------------------------  نهاية متوسط عدد الوجبات الغسيل فى الاسبوع  ---------------------------------------------------------------------------------------------


    $result_day = [];
    $result_night = [];

    $satge_category = Cache::remember('satge_category', 28800, function () {
        return satge_category::with('get_stage.get_shift_activity_day.get_work_order')->get();
    });
    
   
    foreach ($satge_category as $stage_cat) {
        $count_day = 0; // Reset count_day for each stage category
        foreach ($stage_cat->get_stage as $stage) {
            foreach ($stage->get_shift_activity_day as $activity) {
                if($activity->get_work_order){                                         //عند حذف الغسلة الكمية مابتجيش
                $count_day += $activity->get_work_order->product_count;
              }
            }
        }
        $result_day[$stage_cat->name] = $count_day;
    }
//    return $result_day;

    $satge_category_2 = Cache::remember('satge_category_2', 28800, function () {
        return satge_category::with('get_stage.get_shift_activity_night.get_work_order')->get();
    });
        foreach ($satge_category_2 as $stage_cat) {
            $count_night = 0; // Reset count_night for each stage category
            foreach ($stage_cat->get_stage as $stage) {
                foreach ($stage->get_shift_activity_night as $activity) {
                    if($activity->get_work_order){
                    $count_night += $activity->get_work_order->product_count;
                    }
                }
            }
            $result_night[$stage_cat->name] = $count_night;
        }


// ----------------------------------------------------------التغليف ------------------------------------


        $day = Cache::remember('day', 28800, function () {
            return Deliver_order::with(['get_details_dashboard','get_work_order','get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
            ->select('id','work_order_id')
            ->get();
        });



        $fashionDeliver_ready_day = Cache::remember('fashionDeliver_ready_day', 28800, function () {
            return Deliver_order::with(['get_details_dashboard','get_work_order','get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
            ->select('id', 'work_order_id')
            ->whereHas('get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
                $query->where('price', '>', 0);
            })
            ->get();
        });

     


        $night = Cache::remember('night', 28800, function () {
            return  Deliver_order::with(['get_details_dashboard','get_work_order','get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where(function($query) {
            $query->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
            })
            ->orWhere(function($query) {
            $query->where('created_at', '>=', date("Y-m-d").' 00:00:00')
            ->where('created_at', '<=', date("Y-m-d").' 07:59:59');
            })
            ->select('id','work_order_id')
            ->get();
        });
        




        $fashionDeliver_ready_night = Cache::remember('fashionDeliver_ready_night', 28800, function () {
            return Deliver_order::with(['get_details_dashboard','get_work_order','get_work_order_stage.get_sevice_item_stage.get_service_item'])
        ->where(function($query) {
        $query->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
        ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
        })
        ->whereHas('get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
            $query->where('price', '>', 0);
        })
        ->orWhere(function($query) {
        $query->where('created_at', '>=', date("Y-m-d").' 00:00:00')
        ->where('created_at', '<=', date("Y-m-d").' 07:59:59');
        })
        ->whereHas('get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
            $query->where('price', '>', 0);
        })
        ->select('id','work_order_id')
        ->get();
        });


//    --------------------------------------------------------------------------------------------------------------------     
// ----------------------------------------------------------التسليم ------------------------------------

        $final_deliver_day = Cache::remember('final_deliver_day', 28800, function () {
            return FinalDeliver::with(['get_deliver_order.get_work_order','get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item'])
                ->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
                ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
                ->select('id','deliver_order_id','total')
                ->get();
        });




        $fashionDeliver_day = Cache::remember('fashionDeliver_day', 28800, function () {
            return  FinalDeliver::select('deliver_order_id', \DB::raw('SUM(total) as total'))
            ->groupBy('deliver_order_id')
            ->with(['get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
            ->whereHas('get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
                $query->where('price', '>', 0);
            })
            ->get();
        });


  
        $final_deliver_night = Cache::remember('final_deliver_night', 28800, function () {
            return FinalDeliver::with(['get_deliver_order.get_work_order','get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where(function($query) {
            $query->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
            })
            ->orWhere(function($query) {
            $query->where('created_at', '>=', date("Y-m-d").' 00:00:00')
            ->where('created_at', '<=', date("Y-m-d").' 07:59:59');
            })
            ->select('id','deliver_order_id','total')
            ->get();
        });




        $fashionDeliver_night = Cache::remember('fashionDeliver_night', 28800, function () {
            return FinalDeliver::select('deliver_order_id', \DB::raw('SUM(total) as total'))
            ->groupBy('deliver_order_id')
            ->with(['get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item'])
            ->where(function($query) {
                $query->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
                ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
                })
                ->whereHas('get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
                    $query->where('price', '>', 0);
                })
                ->orWhere(function($query) {
                $query->where('created_at', '>=', date("Y-m-d").' 00:00:00')
                ->where('created_at', '<=', date("Y-m-d").' 07:59:59');
                })
                ->whereHas('get_deliver_order.get_work_order_stage.get_sevice_item_stage.get_service_item', function ($query) {
                    $query->where('price', '>', 0);
                })
                ->get();
        });

   
// ----------------------------------------------------------------------------------------------------------------------
    // ----------------------------------------------------------الفاشون------------------------------------

    $shift_day = Cache::remember('shift_day', 28800, function () {
        return Activity::where('owner_stage_id', 48)
        ->where('status', 'closed')
        ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
        ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
        ->select('id', 'work_order_id', 'owner_stage_id')
        ->with('get_work_order.get_work_order_stage.get_service_item:id,name,price')->get();
    });
    

    $fashion_shift_day = Cache::remember('fashion_shift_day', 28800, function () {
        return Activity::where('owner_stage_id', 48)
        ->where('status', 'closed')
        ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
        ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
        ->with('get_work_order.get_work_order_stage.get_service_item:id,name,price')
        ->whereHas('get_work_order.get_work_order_stage.get_service_item', function ($query) {
            $query->where('price', '>', 0);
        })
        ->select('id', 'work_order_id', 'owner_stage_id')
       ->get();
    });

// return $fashion_shift_day;    
    $shift_night = Cache::remember('shift_night', 28800, function () {
        return Activity::with('get_work_order.get_stage.get_work_order_service:id,name,price')
        ->where('status', 'closed')
        ->where('owner_stage_id', 48)
        ->where(function($query) {
            // Conditions for the previous day's night shift (8 PM to 11:59 PM)
            $query->where('owner_stage_id', 48)
                ->where('status', 'closed')
                ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:01:00')
                ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
        })
        ->orWhere(function($query) {
            // Conditions for the current day's early morning shift (12:00 AM to 8 AM)
            $query->where('owner_stage_id', 48)
            ->where('status', 'closed')
            ->where('updated_at', '>=', date("Y-m-d").' 00:00:00')
            ->where('updated_at', '<=', date("Y-m-d").' 07:59:59');
        })
        ->select('id', 'work_order_id', 'owner_stage_id')
        ->get();
    });

    
// return $shift_night;


$fashion_shift_night = Cache::remember('fashion_shift_night',28800, function () {
    return Activity::with('get_work_order.get_stage.get_work_order_service:id,name,price')
    ->where('status', 'closed')
    ->where('owner_stage_id', 48)
    ->where(function($query) {
        // Conditions for the previous day's night shift (8 PM to 11:59 PM)
        $query->where('owner_stage_id', 48)
            ->where('status', 'closed')
            ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
            ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59')
            ->whereHas('get_work_order.get_work_order_stage.get_service_item', function ($query) {
                $query->where('price', '>', 0);
            });
    })
    ->orWhere(function($query) {
        // Conditions for the current day's early morning shift (12:00 AM to 8 AM)
        $query->where('owner_stage_id', 48)
        ->where('status', 'closed')
        ->where('updated_at', '>=', date("Y-m-d").' 00:00:00')
        ->where('updated_at', '<=', date("Y-m-d").' 07:59:59')
        ->whereHas('get_work_order.get_work_order_stage.get_service_item', function ($query) {
            $query->where('price', '>', 0);
        });
    })
    ->select('id', 'work_order_id', 'owner_stage_id')
    ->get();
});


    // return $fashion_shift_night;
    // ----------------------------------------------------------------------------------------------------
    return view('home')->with([
        'result_day' => $result_day,
        'result_night' => $result_night,
        'night'=>$night,//91
        'day'=>$day, //121
        'fashionDeliver_ready_day'=>$fashionDeliver_ready_day,//51
        'fashionDeliver_ready_night'=>$fashionDeliver_ready_night,//51
        'final_deliver_day'=>$final_deliver_day,//220
        'final_deliver_night'=>$final_deliver_night,//170
        'fashionDeliver_day'=>$fashionDeliver_day,//48
        'fashionDeliver_night'=>$fashionDeliver_night,//45
        'shift_day' => $shift_day,
        'shift_night' => $shift_night,
        'fashion_shift_day' => $fashion_shift_day,
        'fashion_shift_night' => $fashion_shift_night,
        
        'averageQuantity_dyeing'=>round($averageQuantity_dyeing),
        'averageQuantity_jeans'=>round($averageQuantity_jeans),
        'averageQuantity_washing'=>round($averageQuantity_washing),

        'top_ten_customer_dyeing'=>$top_ten_customer_dyeing,
        'top_ten_customer_jeans'=>$top_ten_customer_jeans,
        'top_ten_customer_washing'=>$top_ten_customer_washing,

        'top_ten_customer'=>$top_ten_customer,
        'ratios_customers'=>$ratios_customers,
        ]);
}

    public function result_balance(){
       
        $balance_shift_day=Activity::where('owner_stage_id', 48)
                        ->where('status', 'closed')
                        ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 08:00:00')
                        ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 20:00:00')
                        ->select('id', 'work_order_id', 'owner_stage_id','updated_at')
                        ->with('get_workOrders.get_ReceiveReceipt:id,model','get_workOrders.get_products:id,name','get_workOrders.get_customer:id,name','get_workOrders.get_receivables:id,name','get_workOrders.get_stage.get_sevice_item_stage.get_service_item:id,name,price')
                        ->orderBy('updated_at', 'asc')
                        ->get();
                        
        $balance_shift_night=Activity::with('get_workOrders.get_ReceiveReceipt:id,model','get_workOrders.get_products:id,name','get_workOrders.get_customer:id,name','get_workOrders.get_receivables:id,name','get_workOrders.get_stage.get_sevice_item_stage.get_service_item:id,name,price')
                                ->where('status', 'closed')
                                ->where('owner_stage_id', 48)
                                ->where(function($query) {
                                    // Conditions for the previous day's night shift (8 PM to 11:59 PM)
                                    $query->where('owner_stage_id', 48)
                                        ->where('status', 'closed')
                                        ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 20:01:00')
                                        ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
                                })
                                ->orWhere(function($query) {
                                    // Conditions for the current day's early morning shift (12:00 AM to 8 AM)
                                    $query->where('owner_stage_id', 48)
                                    ->where('status', 'closed')
                                    ->where('updated_at', '>=', date("Y-m-d").' 00:00:00')
                                    ->where('updated_at', '<=', date("Y-m-d").' 07:59:59');
                                })
                                ->select('id', 'work_order_id', 'owner_stage_id','updated_at')
                                ->orderBy('updated_at', 'asc')
                                ->get();

        // return $balance_shift_day;

        return view('crm_views.result_balance')->with([

            'balance_shift_day' => $balance_shift_day,
            'balance_shift_night' => $balance_shift_night,
            ]);
    }


    public function result_balance_all(Request $request){
// return $request;
        $result=Activity::where('owner_stage_id', 48)
        ->where('status', 'closed')
        ->select('id', 'work_order_id', 'owner_stage_id','updated_at')
        ->with('get_workOrders.get_ReceiveReceipt:id,model','get_workOrders.get_products:id,name','get_workOrders.get_customer:id,name','get_workOrders.get_receivables:id,name','get_workOrders.get_stage.get_sevice_item_stage.get_service_item:id,name,price')
        ->orderBy('updated_at', 'asc');
        
        if (isset($request->from)) {
            $result=$result->where('updated_at','>=',$request->from);
            }
        if (isset($request->to)) {
            $result=$result->where('updated_at','<=',$request->to);
            }
            

        $result = $result->get();

        // return $result;
        return view('crm_views.result_balance_all')->with([
            'request' => $request,
            'result' => $result,
            ]);
    }


    public function index_without_dashboard(){

        return view('home_without_dashboard');
    }
}



