<?php

namespace App\DataTables;

use App\Models\CRM\WorkOrder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;
use Gate;
class WorkOrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
        ->addColumn('product_details', function ($row) {
            $productName = $row->get_ReceiveReceipt->get_product->name ?? '';
            $productType = $row->get_ReceiveReceipt->product_type ?? '';

            if ($productName && $productType) {
                return $productName . ' (' . $productType . ')';
            } elseif ($productName) {
                return $productName;
            } elseif ($productType) {
                return $productType;
            }
            return 'N/A'; // Handle null cases
        })
        ->addColumn('action', 'work_orders.datatables_actions');
         // return $dataTable->addColumn('action', 'work_orders.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrder $model)
    {
        return $model->newQuery()->with(['get_customer:name,id','get_products:name,id','get_receivables:name,id' ,'get_places:name,id','get_ReceiveReceipt']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        // if (Auth::user()->team_id == 1) {
        //     $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        // }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];
        // ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['workOrders.show', 'workOrders.edit', 'workOrders.destroy','workOrders.print'])) {
            $dataTable->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false]);
        }

        return $dataTable->parameters([
            'dom'       => 'Bfrtip',
            'stateSave' => true,
            'order'     => [[0, 'desc']],
            'buttons'   => $buttons,
            'language'  => ['url' => 'js/translate_data_table.json']
        ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // "الحالة"=>['name'=>'status','data'=>'status'],
            "رقم_الغسلة"=>['name'=>'id','data'=>'id'],
            "ايصال-الاضافة"=>['name'=>'receive_receipt_id','data'=>'receive_receipt_id'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
       
            'product_details'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'product_details',
                'name' => 'product_details'
               ]),
            
            "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],
         
            "العدد"=>['name'=>'product_count','data'=>'product_count'],
            "الوزن"=>['name'=>'product_weight','data'=>'product_weight'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'work_orders_datatable_' . time();
    }
}
