<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\CustomerDataTable;
use App\DataTables\CustomerReceiveReceiptDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateCustomerRequest;
use App\Http\Requests\CRM\UpdateCustomerRequest;
use App\Repositories\CRM\CustomerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CRM\Service;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\Stage;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\Work_order_stage;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\WorkOrder;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\Customer;
use App\Models\CRM\Receivable;

class CustomerController extends AppBaseController
{
    /** @var CustomerRepository $customerRepository*/
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     *
     * @param CustomerDataTable $customerDataTable
     *
     * @return Response
     */
    public function index(CustomerDataTable $customerDataTable)
    {
        return $customerDataTable->render('customers.index');
        
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $input = $request->all();

        $customer = $this->customerRepository->create($input);

        Flash::success('تم إنشاء العميل بنجاح');

        return redirect(route('customers.index'));
    }

    /**
     * Display the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('العميل غير موجود');

            return redirect(route('customers.index'));
        }

        $receiveReceipt=ReceiveReceipt::where('customer_id',$id)->where('status','open')->get();
        $workOrders = WorkOrder::where('customer_id',$id)->where('status','open')->get();
        $workOrders_closed = WorkOrder::where('customer_id',$id)->where('status','closed')->get();
        $ready_store = Deliver_order::where('customer_id',$id)->where('status','open')->with(['get_details','get_final_deliver'])->get();
      
        // ======================================= للرسم البيانى  ============================================
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::THURSDAY);
        
        $firstDayOfWeek = Carbon::now()->startOfWeek();
        $lastDayOfWeek = Carbon::now()->endOfWeek();


        $service_ids= Service::where('service_category_id',1)->pluck('id')->toArray();   // الخدمات المائية
        $service_item_ids= ServiceItem::whereIn('service_id',$service_ids)->pluck('id')->toArray();       //الخدمات  نفسها سواء غسيل او جينز او صباغة
        
        $stage_dyeing_ids=Stage::where('stage_category_id',7)->pluck('id')->toArray();          //المراحل التى تحتوى على صباغة فقط
        $stage_jeans_ids=Stage::whereIn('stage_category_id',[1,2,3,5,6])->pluck('id')->toArray();          //المراحل التى تحتوى على الجينز فقط وليس صباغة
        $stage_washing_ids=Stage::where('stage_category_id',4)->pluck('id')->toArray();          //المراحل التى تحتوى على غسيل فقط 
            
        // ------------------------------------------------------------------------------  بداية كمية صباغة فى الاسبوع  ---------------------------------------------------------------------------------------------
        $service_item_stage_dyeing_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_dyeing_ids)->pluck('id')->toArray();
        $work_order_dyeig_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_dyeing_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
        $work_orders_dyeing = WorkOrder::whereIn('id',$work_order_dyeig_ids)->where('customer_id',$id)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->select('customer_id', \DB::raw('SUM(product_count) as total_count_dyeing'))->with('get_customer:name,id')->first();
        // ------------------------------------------------------------------------------  نهاية كمية صباغة فى الاسبوع  ---------------------------------------------------------------------------------------------
            
        // ------------------------------------------------------------------------------  بداية كمية جينز فى الاسبوع  ---------------------------------------------------------------------------------------------
        $service_item_stage_jeans_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_jeans_ids)->pluck('id')->toArray();
        $work_order_jeans_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_jeans_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
        $work_orders_jeans = WorkOrder::whereIn('id',$work_order_jeans_ids)->where('customer_id',$id)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->select('customer_id', \DB::raw('SUM(product_count) as total_count_jeans'))->with('get_customer:name,id')->first();
        // ------------------------------------------------------------------------------  نهاية كمية جينز فى الاسبوع  ---------------------------------------------------------------------------------------------
            
        // ------------------------------------------------------------------------------  بداية كمية غسيل فى الاسبوع  ---------------------------------------------------------------------------------------------
        $service_item_stage_washing_ids= ServiceItemSatge::whereIn('service_item_id',$service_item_ids)->whereIn('satge_id',$stage_washing_ids)->pluck('id')->toArray();
        $work_order_washing_ids= Work_order_stage::whereIn('service_item_satge_id',$service_item_stage_washing_ids)->select('work_order_id')->distinct()->pluck('work_order_id')->toArray();
        $work_orders_washing = WorkOrder::whereIn('id',$work_order_washing_ids)->where('customer_id',$id)->whereBetween('created_at', [$firstDayOfWeek, $lastDayOfWeek])->select('customer_id', \DB::raw('SUM(product_count) as total_count_washing'))->with('get_customer:name,id')->first();
        // ------------------------------------------------------------------------------  نهاية كمية غسيل فى الاسبوع  ---------------------------------------------------------------------------------------------
       
        $dataArray = [
            'customer_id' => $id,
            'customer' => $customer->name ,
            'total_count_dyeing' => $work_orders_dyeing->total_count_dyeing ?? '0',
            'total_count_jeans' => $work_orders_jeans->total_count_jeans ?? '0',
            'total_count_washing' => $work_orders_washing->total_count_washing ?? '0',
        ];

        // ======================================= للرسم البيانى  ============================================
// return $receive_name;
        return view('customers.show')
        ->with(['customer'=> $customer,
                'receiveReceipt'=>$receiveReceipt,
                'workOrders'=>$workOrders,
                'ready_store'=>$ready_store,
                'workOrders_closed'=>$workOrders_closed,
                'dataArray'=>$dataArray,
            ]);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('العميل غير موجود');

            return redirect(route('customers.index'));
        }

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param int $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('العميل غير موجود');

            return redirect(route('customers.index'));
        }

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('تم تحديث بيانات العميل بنجاح');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('العميل غير موجود');

            return redirect(route('customers.index'));
        }
        $check = ReceiveReceipt::where('customer_id',$id)->get();
        
        if(count($check)>0){
            Flash::error('لا يمكن حذف العميل لوجود اذون استلام له');

            return redirect(route('customers.index'));
        }
        $this->customerRepository->delete($id);

        Flash::success('تم حذف العميل بنجاح');

        return redirect(route('customers.index'));
    }

    public function get_receive_receipt(Request $request,$id){
        
        if ($request->ajax()) {
            $data = ReceiveReceipt::where('customer_id', $id)->with(['get_customer:name,id','get_product:name,id', 'work_order'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($id) {
                    if (auth()->user()->can('get_work_order')) {
                        $btn = '<a href="/get_work_order/'.$row->id.'/'.$id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-eye fa-lg"></i></a>';
                        return $btn;
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $customer_name = Customer::where('id', $id)->pluck('name')->first();

        return view('customers.customerReceiveReceipt')->with(['customer_id'=>$id ,'customer_name'=>$customer_name]);

    }

    public function get_work_order(Request $request,$receiveReceipt_id,$customer_id){
        $product_id=ReceiveReceipt::where('id',$receiveReceipt_id)->first('product_id');

        if ($request->ajax()) {
            $data = WorkOrder::where('receive_receipt_id', $receiveReceipt_id)->with(['get_products:name,id','get_ReceiveReceipt'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('product_details', function ($row) {
                    // Access product_name and product_type from the related ReceiveReceipt
                    $productName = $row->get_ReceiveReceipt->get_product->name ?? '';
                    $productType = $row->get_ReceiveReceipt->product_type ?? '';
    
                    if ($productName && $productType) {
                        return $productName . ' (' . $productType . ')';
                    } elseif ($productName) {
                        return $productName;
                    } elseif ($productType) {
                        return $productType;
                    } else {
                        return 'N/A'; // Or return an empty string ''
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '';
                    
                    if (auth()->user()->can('workOrders.show')) {
                        $btn .= '<a href="/workOrders/'.$row->id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-eye" style="font-size:14px;"></i></a>';
                    }
                    
                    // if (auth()->user()->can('workOrders.print')) {
                    //     $btn .= '<a href="/workOrders_print/'.$row->id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-print" style="font-size:14px;"></i></a>';
                    // }
                    if (auth()->user()->can('workOrders.print_cs')) {
                        $btn .= '<a href="/workOrders_print_cs/'.$row->id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-print" style="font-size:14px;"></i></a>';
                    }
                    if (auth()->user()->can('important_workOrders')) {
                    $btn .= '<a href="/important_workOrders/'.$row->id.'" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-star" style="font-size:14px;"></i></a>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        


        $customer_name = Customer::where('id', $customer_id)->pluck('name')->first();
       
        return view('customers.customer_work_order')->with(['product_id'=>$product_id,'receiveReceipt_id'=>$receiveReceipt_id,'customer_id'=>$customer_id ,'customer_name'=>$customer_name]);
    }
}


