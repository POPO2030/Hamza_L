<?php

namespace App\Http\Controllers\accounting;

use App\DataTables\InvoiceDataTable;
use App\Http\Requests\accounting;
use App\Http\Requests\accounting\CreateInvoiceRequest;
use App\Http\Requests\accounting\UpdateInvoiceRequest;
use App\Repositories\accounting\InvoiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\CRM\Customer;
use App\Models\CRM\FinalDeliver;
use App\Models\CRM\Service;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\WorkOrder;
use App\Models\accounting\Invoice_details;
use App\Models\accounting\Invoice;
use App\Models\accounting\Invoice_service_prices;
use App\Models\sales\Customer_details;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class InvoiceController extends AppBaseController
{
    /** @var InvoiceRepository $invoiceRepository*/
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }



    public function index(InvoiceDataTable $invoiceDataTable)
    {
        return $invoiceDataTable->render('invoices.index');
    }


    public function create()
    {
        $customers = Customer::select('id','name')->get();
        $deliverOrder = FinalDeliver::with([
            'get_deliver_order.get_customer:name,id',
            'get_deliver_order.get_products:name,id',
            'get_deliver_order.get_receivable:name,id',
            'get_receivable_name:name,id',
            'get_deliver_order.get_receive_receipt:model,id'
        ])
        ->get();
        return view('invoices.create')->with(['customers'=>$customers]);
    }

    public function getDeliverOrders(Request $request)
    {
        $customerId = $request->customer_id;
        
        $deliverOrder = FinalDeliver::where('flag_inovice',0)->whereHas('get_deliver_order', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })
        ->join('deliver_orders', 'deliver_orders.id', '=', 'final_deliver_details.deliver_order_id') // Correct table reference
        ->selectRaw('
        
            final_deliver_details.final_deliver_order_id,
            final_deliver_details.deliver_order_id,
            final_deliver_details.receivable_id,
            final_deliver_details.created_at,
            deliver_orders.work_order_id,
            SUM(final_deliver_details.total) as total_sum,
            SUM(final_deliver_details.weight) as weight_sum
        ')
        ->groupBy('final_deliver_details.final_deliver_order_id', 'deliver_orders.work_order_id')
        ->with([
            'get_deliver_order.get_customer:id,name',
            'get_deliver_order.get_products:id,name',
            'get_deliver_order.get_receivable:id,name',
            'get_receivable_name:id,name',
            'get_deliver_order.get_receive_receipt:id,model',
            'get_deliver_order.get_count_product.get_work_order_stage.get_service_item.get_category.get_category'
        ])
        ->get();

 // ==============================================  حساب تكلفة الغسلة  ================================================

                $service_ids_water= Service::where('service_category_id',1)->pluck('id')->toArray();    // الخدمات المائية
                $service_ids_dry= Service::where('service_category_id',2)->pluck('id')->toArray();    // الخدمات الجافة

                foreach ($deliverOrder as $order) {
                    $service_item_ids = Work_order_stage::where('work_order_id', $order->work_order_id)
                        ->pluck('service_item_satge_id')
                        ->toArray();
                
                    $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
                        ->distinct()
                        ->pluck('service_item_id')
                        ->toArray(); // كل الخدمات المختارة 
                
                    $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
                        ->whereIn('service_id', $service_ids_water)
                        ->get();
                
                    $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
                        ->whereIn('service_id', $service_ids_dry)
                        ->get();

                    $total_water = $service_item_with_kilo->sum('money'); // مجموع اسعار الخدمات المائية
                    $total_amount_water = $total_water * ($order->weight_sum ?? 0); // الوزن الإجمالي
                    $total_unit = $service_item_with_unit->sum('money'); // مجموع اسعار الخدمات الجافة
                    $total_amount_unit = $total_unit * ($order->total_sum ?? 0); // عدد القطع الإجمالي  
                    $total_amount_work_order = $total_amount_water + $total_amount_unit;      
                    // Add the calculated amount to the object
                    $order->total_amount_work_order = $total_amount_work_order;             
                }      
    // ==============================================================================================
        return response()->json($deliverOrder);
    }



    public function store(CreateInvoiceRequest $request)
    {
        $newConnection = 'mysql_new'; // Connection for laundry_erp_25
        $currentConnection = 'mysql'; // Current logged-in DB connection
        $currentDatabase = session('database');
    
        // Configure dynamic connection
        config(["database.connections.{$currentConnection}.database" => $currentDatabase]);

        $invoice = null; // To store invoice for redirection

        // Step 1: Create invoice in NEW database (laundry_erp_25)
        DB::connection($newConnection)->beginTransaction();
        try {
            $input = $request->all();
            $input['creator_id'] = Auth::user()->id;
            $input['calculation_method'] = $request->calculation_method;
            $input['date'] = $request->date ?? now();
            $input['discount_notice'] = $request->discount_notice_output;
            $input['tax'] = $request->tax_output;
            $input['season'] = ($currentDatabase == "madco_26") ? "new" : "old";

            // Create invoice directly instead of using repository
            $invoice = new Invoice();
            $invoice->setConnection($newConnection);
            $invoice->fill($input);
            $invoice->save();

            $invoiceDetails = [];

            foreach ($request->final_deliver_order_id as $finalDeliverOrderId) {
                $workOrderIds = $request->work_order_id[$finalDeliverOrderId];
                $totalQtys = $request->total_qty[$finalDeliverOrderId];
                $totalKgs = $request->total_kg[$finalDeliverOrderId];
                $totalAmounts = $request->total_amount[$finalDeliverOrderId];
                $piecePrice = $request->piece_price[$finalDeliverOrderId] ?? null;

                for ($i = 0; $i < count($workOrderIds); $i++) {
                    $invoiceDetail = Invoice_details::on($newConnection)->create([
                        'invoice_id' => $invoice->id,
                        'final_deliver_order_id' => $finalDeliverOrderId,
                        'work_order_id' => $workOrderIds[$i],
                        'piece_price' => $piecePrice[$i] ?? null,
                        'total_qty' => $totalQtys[$i],
                        'total_kg' => $totalKgs[$i],
                        'total_amount' => $totalAmounts[$i],
                        'date' => $request->date ?? now(),
                        'created_at' => now(),
                    ]);

                    $invoiceDetails[$finalDeliverOrderId][$workOrderIds[$i]] = $invoiceDetail;

                    if (isset($request->service_item_ids[$finalDeliverOrderId][$workOrderIds[$i]])) {
                        $serviceItemIds = $request->service_item_ids[$finalDeliverOrderId][$workOrderIds[$i]];
                        $serviceMoneys = $request->service_item_moneys[$finalDeliverOrderId][$workOrderIds[$i]];
                        $serviceCategoryIds = $request->service_category_ids[$finalDeliverOrderId][$workOrderIds[$i]];

                        for ($j = 0; $j < count($serviceItemIds); $j++) {
                            Invoice_service_prices::on($newConnection)->create([
                                'invoice_id' => $invoice->id,
                                'invoice_details_id' => $invoiceDetail->id,
                                'final_deliver_order_id' => $finalDeliverOrderId,
                                'work_order_id' => $workOrderIds[$i],
                                'service_item_id' => $serviceItemIds[$j],
                                'service_id' => $serviceCategoryIds[$j], 
                                'service_price' => $serviceMoneys[$j],
                            ]);
                        }
                    }
                }
            }

            Customer_details::on($newConnection)->create([
                'customer_id' => $request->customer_id,
                'invoice_id' => $invoice->id,
                'cash_balance_debit' => $request->amount_net,
                'flag' => 'invoice',
                'note' => 'فاتورة',
                'date' => $request->date ?? now(),
                'creator_id' => Auth::user()->id,
            ]);

            DB::connection($newConnection)->commit();
        } catch (\Throwable $th) {
            DB::connection($newConnection)->rollBack();
            throw $th;
        }

        // Step 2: Update FinalDeliver in CURRENT database
        DB::connection($currentConnection)->beginTransaction();
        try {
            foreach ($request->final_deliver_order_id as $finalDeliverOrderId) {
                FinalDeliver::on($currentConnection)
                    ->where('final_deliver_order_id', $finalDeliverOrderId)
                    ->update(['flag_inovice' => 1]);
            }
            DB::connection($currentConnection)->commit();
        } catch (\Throwable $th) {
            DB::connection($currentConnection)->rollBack();
            
            // Log error but don't prevent invoice creation
            \Log::error("FinalDeliver update failed for invoice {$invoice->id}: " . $th->getMessage());
            
            return redirect()->route('invoices.show', ['id' => $invoice->id])
                ->with('warning', 'تم إنشاء الفاتورة ولكن حدث خطأ في تحديث حالة التسليم');
        }

        return redirect()->route('invoices.show', ['id' => $invoice->id])
            ->with('success', 'تم انشاء الفاتورة بنجاح');
    }
    public function show($id)
    {
        // $invoice = $this->invoiceRepository->find($id);
        $invoice = Invoice::on('mysql_new')->with(['get_customer:name,id'])->find($id);
        
       // هات الفواتير وعلاقاتها الأساسية
        $invoice_details = Invoice_details::on('mysql_new')
            ->with([
                'get_invoice', // علشان نعرف الseason
                'get_invoice_services.get_service_item:name,id',
            ])
            ->where('invoice_id', $id)
            ->get();

        // لكل تفصيلة فاتورة — حمل الـ WorkOrder بالـ connection المناسب
        foreach ($invoice_details as $detail) {
            $season = $detail->get_invoice->season ?? 'new';

            $workOrderConnection = $season === 'new' ? 'mysql_new' : 'mysql_old';

            // هات الـ WorkOrder وعلاقاته
            $workOrder = \App\Models\CRM\WorkOrder::on($workOrderConnection)
                ->with([
                    'get_products:name,id',
                    'get_receivables:name,id',
                    'get_ReceiveReceipt:product_type,id,model',
                ])
                ->find($detail->work_order_id);

            // اربط العلاقة يدويًا
            $detail->setRelation('get_work_order', $workOrder);
        }


        // $service_ids_water= Service::where('service_category_id',1)->pluck('id')->toArray();    // الخدمات المائية
        // $service_ids_dry= Service::where('service_category_id',2)->pluck('id')->toArray();    // الخدمات الجافة

        // foreach ($invoice_details as $order) {
        //     $service_item_ids = Work_order_stage::where('work_order_id', $order->work_order_id)
        //         ->pluck('service_item_satge_id')
        //         ->toArray();
        
        //     $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
        //         ->distinct()
        //         ->pluck('service_item_id')
        //         ->toArray(); // كل الخدمات المختارة 
        
        //     $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
        //         ->whereIn('service_id', $service_ids_water)
        //         ->get();     // غسيل
        
        //     $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
        //         ->whereIn('service_id', $service_ids_dry)
        //         ->get();   // فاشون

        //     $order->service_item_with_kilo = $service_item_with_kilo;
        //     $order->service_item_with_unit = $service_item_with_unit;
        // }

// return $invoice_details;
        return view('invoices.show')->with(['invoice'=>$invoice,'invoice_details'=>$invoice_details]);
    }


    public function origenal_invoices($id)
    {
        // $invoice = $this->invoiceRepository->find($id);
        $invoice = Invoice::with(['get_customer:name,id'])->find($id);
        
        $invoice_details = Invoice_details::with([
        'get_work_order',
        'get_work_order.get_products:name,id',
        'get_work_order.get_receivables:name,id',
        'get_work_order.get_ReceiveReceipt:product_type,id,model'
        ])->where('invoice_id', $id)->get();


        $service_ids_water= Service::where('service_category_id',1)->pluck('id')->toArray();    // الخدمات المائية
        $service_ids_dry= Service::where('service_category_id',2)->pluck('id')->toArray();    // الخدمات الجافة

        foreach ($invoice_details as $order) {
            $service_item_ids = Work_order_stage::where('work_order_id', $order->work_order_id)
                ->pluck('service_item_satge_id')
                ->toArray();
        
            $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
                ->distinct()
                ->pluck('service_item_id')
                ->toArray(); // كل الخدمات المختارة 
        

            $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
                ->whereIn('service_id', $service_ids_water)
                ->get();     // غسيل
        
            $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
                ->whereIn('service_id', $service_ids_dry)
                ->get();   // فاشون

            $order->service_item_with_kilo = $service_item_with_kilo;
            $order->service_item_with_unit = $service_item_with_unit;
        }

// return $invoice_details;
        return view('invoices.origenal_invoices')->with(['invoice'=>$invoice,'invoice_details'=>$invoice_details]);
    }


    public function edit($id)
    {
        // return $id;
        // $invoice = $this->invoiceRepository->find($id);
 $invoice = Invoice::with(['get_customer:name,id'])->find($id);
        
        $invoice_details = Invoice_details::with([
        'get_work_order',
        'get_work_order.get_products:name,id',
        'get_work_order.get_receivables:name,id',
        'get_work_order.get_ReceiveReceipt:product_type,id,model'
        ])->where('invoice_id', $id)->get();

// return $invoice;

        $service_ids_water= Service::where('service_category_id',1)->pluck('id')->toArray();    // الخدمات المائية
        $service_ids_dry= Service::where('service_category_id',2)->pluck('id')->toArray();    // الخدمات الجافة

        foreach ($invoice_details as $order) {
            $service_item_ids = Work_order_stage::where('work_order_id', $order->work_order_id)
                ->pluck('service_item_satge_id')
                ->toArray();
        
            $selectedservice = ServiceItemSatge::whereIn('id', $service_item_ids)
                ->distinct()
                ->pluck('service_item_id')
                ->toArray(); // كل الخدمات المختارة 
        
            $service_item_with_kilo = ServiceItem::whereIn('id', $selectedservice)
                ->whereIn('service_id', $service_ids_water)
                ->get();     // غسيل
        
            $service_item_with_unit = ServiceItem::whereIn('id', $selectedservice)
                ->whereIn('service_id', $service_ids_dry)
                ->get();   // فاشون

            $order->service_item_with_kilo = $service_item_with_kilo;
            $order->service_item_with_unit = $service_item_with_unit;
        }

        return view('invoices.edit')->with(['invoice'=>$invoice,'invoice_details'=>$invoice_details]);
    }


public function update($id, UpdateInvoiceRequest $request)
{
    // return $request;
    $invoice = $this->invoiceRepository->find($id);

    if (!$invoice) {
        Flash::error('الفاتورة غير موجودة');
        return redirect(route('invoices.index'));
    }

    // تحديث الفاتورة نفسها
    $invoice->update([
        'branch'       => $request->input('branch'),
        'date'         => $request->input('date'),
        'amount_minus' => $request->input('amount_minus'),
        'amount_net'   => $request->input('amount_net'),
        'tax'          => $request->input('tax'),
        'discount_notice'   => $request->input('discount_notice'),
        'updated_at'   => now(),
    ]);

    if($request->piece_price){
         // تحديث invoice_details عبر العلاقة
        foreach ($invoice->get_invoice_details as $index => $detail) {
            $detail->update([
                'date'         => $request->input('date'),
                'updated_at'   => now(),

                // نأخذ العنصر المناسب من المصفوفة حسب رقم السطر
                'piece_price'  => $request->input('piece_price')[$index] ?? 0,
                'total_amount' => $request->input('total_amount')[$index] ?? 0,
            ]);
        }
    }else{
         // تحديث invoice_details عبر العلاقة
        foreach ($invoice->get_invoice_details as $index => $detail) {
            $detail->update([
                'date'         => $request->input('date'),
                'updated_at'   => now(),
            ]);
        }

    }


    // تحديث invoice_service_prices عبر العلاقة
    foreach ($invoice->get_invoice_services as $servicePrice) {
        $servicePrice->update([
            'updated_at' => now(),
        ]);
    }
        Customer_details::where('invoice_id',$id)->update([
            'cash_balance_debit'=>$request->input('amount_net'),
            'date'=>$request->input('date'),
            'updated_by'=>Auth::user()->id,
        ]);

    return redirect(route('invoices.index'))->with('success', 'تم تعديل الفاتورة بنجاح');
}


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
        $invoice = $this->invoiceRepository->find($id);
        
        $finalDeliverOrderId = Invoice_details::where('invoice_id',$id)->select('final_deliver_order_id')->distinct()->pluck('final_deliver_order_id')->toArray();
            if(count($finalDeliverOrderId)){
                if($invoice->season == "new"){
                    FinalDeliver::whereIn('final_deliver_order_id',$finalDeliverOrderId)->update(['flag_inovice'=>0]);
                }else {
                    FinalDeliver::on('mysql_old')->whereIn('final_deliver_order_id',$finalDeliverOrderId)->update(['flag_inovice'=>0]);
                }
                Invoice_details::where('invoice_id',$id)->delete();
                Invoice_service_prices::where('invoice_id',$id)->delete();
            }
            Customer_details::where('invoice_id',$id)->delete();
        
            $this->invoiceRepository->delete($id);
   
        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }


        return redirect(route('invoices.index'))->with('success', 'تم حذف الفاتورة');;
    }


    public function check_date_available(Request $request){

        // return $request;
        $check_date_available = Customer_details::on('mysql_new')->where('customer_id', $request->customer_id)
        ->where('payment_type_id', 4)
        ->where('date', '>=', $request->date)
        ->exists(); 

        if ($check_date_available) {
            return response()->json([
                'valid' => false,
                'message' => 'عفوا.... التاريخ المطلوب قبل تاريخ اول المدة'
            ]);
        }

        return response()->json([
            'valid' => true
        ]);

    }
}
