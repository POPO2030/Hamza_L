<?php

namespace App\Http\Controllers\accounting;

use App\DataTables\Accounting_costDataTable;
use App\Http\Requests\accounting;
use App\Http\Requests\accounting\CreateAccounting_costRequest;
use App\Http\Requests\accounting\UpdateAccounting_costRequest;
use App\Repositories\accounting\Accounting_costRepository;
use App\Models\CRM\WorkOrder;
use App\Models\accounting\Accounting_cost;
use App\Models\accounting\Accounting_costs_details;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Inv_importorder_details;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Accounting_costController extends AppBaseController
{
    /** @var Accounting_costRepository $accountingCostRepository*/
    private $accountingCostRepository;

    public function __construct(Accounting_costRepository $accountingCostRepo)
    {
        $this->accountingCostRepository = $accountingCostRepo;
    }

    /**
     * Display a listing of the Accounting_cost.
     *
     * @param Accounting_costDataTable $accountingCostDataTable
     *
     * @return Response
     */
    public function index(Accounting_costDataTable $accountingCostDataTable)
    {
        return $accountingCostDataTable->render('accounting_costs.index');
    }


    public function create()
    {
        $accounting_cost=Accounting_cost::pluck('work_order_id');
        $work_order = WorkOrder::select('id','id')->whereNotIn('id',$accounting_cost)->get();

        return view('accounting_costs.create')->with([
            'work_order'=>$work_order ,
         ]);
    }


    public function store(CreateAccounting_costRequest $request)
    {
        // return $request;
        if(isset($request->product_id)){
            $input = $request->all();

            $accountingCost = $this->accountingCostRepository->create($input);
    
    
            for ($i = 0; $i < count($request->product_id); $i++) {
                $data[] = [
                    'accounting_costs_id' => $accountingCost->id,
                    'product_id' => $request->product_id[$i],
                    'unit_id' => $request->unit_id[$i],
                    'average_cost' => $request->average_cost[$i],
                    'product_quantity' => $request->product_quantity[$i],
                    'created_at' => now(),
    
                ];
            }
    
                Accounting_costs_details::insert($data);
        }else{
            return redirect(route('accountingCosts.index'))->with('error', trans('عفوا ... لا يوجد اصناف مصروفة على هذة الغسلة.'));
        }
        

        return redirect(route('accountingCosts.index'))->with('success', trans('تنبيه...تم الحفظ بنجاح'));
    }


    public function show($id)
    {
        // $accountingCost = $this->accountingCostRepository->find($id);
        $accountingCost = Accounting_cost::with(['get_details.product_color.get_product:name,id','get_details.get_unit:name,id','get_work_order'])->find($id);

        if (empty($accountingCost)) {
            Flash::error('Accounting Cost not found');

            return redirect(route('accountingCosts.index'));
        }

        return view('accounting_costs.show')->with('accountingCost', $accountingCost);
    }


    public function edit($id)
    {
        $accountingCost = $this->accountingCostRepository->find($id);
        $work_order = WorkOrder::select('id','id')->get();
        return view('accounting_costs.edit')->with(['accountingCost'=> $accountingCost,'work_order'=> $work_order,]);
    }


    public function update($id, UpdateAccounting_costRequest $request)
    {
        $accountingCost = $this->accountingCostRepository->find($id);

        if (empty($accountingCost)) {
            Flash::error('Accounting Cost not found');

            return redirect(route('accountingCosts.index'));
        }

        $accountingCost = $this->accountingCostRepository->update($request->all(), $id);

        Flash::success('Accounting Cost updated successfully.');

        return redirect(route('accountingCosts.index'));
    }


    public function destroy($id)
    {
        $accountingCost = $this->accountingCostRepository->find($id);

        if (empty($accountingCost)) {
            Flash::error('Accounting Cost not found');

            return redirect(route('accountingCosts.index'));
        }

        $this->accountingCostRepository->delete($id);

        Accounting_costs_details::where('accounting_costs_id',$id)->delete();


        // Flash::success('تم حذف التكاليف بنجاح');

        return redirect(route('accountingCosts.index'))->with('success', trans('تنبيه...تم الحذف بنجاح'));
    }


    public function get_costs_model_quantity(Request $request)
    {
        // return $request;
        // $total_contract_quantity = Model_name::select('total_contract_quantity')->where('id',$request->model_id)->first()->total_contract_quantity;
        $total_contract_quantity = WorkOrder::select('product_count')->where('id',$request->work_order_id)->first()->product_count;
       
        $inv_controlStock_data = Inv_controlStock::select('product_id', 'unit_id','quantity_out')->with([
            'get_product_color:id,product_id,color_id',
            'get_product_color.get_product:id,name',
            // 'get_product_color.get_product.invproduct_category:name,id',
            // 'get_product_color.get_product.get_product_description:name,id',
            // 'get_product_color.get_product.get_size:name,id',
            // 'get_product_color.get_product.get_weight:name,id',
            'get_product_color.get_color:id,color_code_id,colorCategory_id',
            'get_product_color.get_color.get_color_code:name,id',
            'get_product_color.get_color.invcolor_category:name,id',
            'get_unit:name,id',
            ])->where('work_order_id', $request->work_order_id)->get();

            $average_costs = [];

            // Calculate average cost for each product_id
            foreach ($inv_controlStock_data as $stock) {
                $product_id = $stock->product_id;
        
                // Get all import order details for the product
                $import_orders = Inv_importorder_details::select('invimport_id', 'product_id', 'quantity', 'product_price')
                    ->where('product_id', $product_id)
                    ->get();
        
                $total_cost = 0;
                $total_rows = $import_orders->count();
        
                foreach ($import_orders as $order) {
                    $total_cost += $order->product_price;
                }
        
                $average_cost = $total_rows > 0 ? $total_cost / $total_rows : 0;
                $average_costs[$product_id] = $average_cost;
            }
        
            // Merge average cost into inv_controlStock_data
            foreach ($inv_controlStock_data as $stock) {
                $product_id = $stock->product_id;
                $stock->average_cost = isset($average_costs[$product_id]) ? $average_costs[$product_id] : 0;
            }
        
            return [
                'inv_controlStock_data' => $inv_controlStock_data,
                'total_contract_quantity' => $total_contract_quantity,
            ];
    }
}
