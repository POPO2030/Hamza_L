<?php

namespace App\DataTables;

use App\Models\CRM\FinalDeliver;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class Deliver_orderDataTable_final_deliver extends DataTable
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
            $productName = $row->get_deliver_order->get_receive_receipt->get_product->name ?? '';
            $productType = $row->get_deliver_order->get_receive_receipt->product_type ?? '';

            if ($productName && $productType) {
                return $productName . ' (' . $productType . ')';
            } elseif ($productName) {
                return $productName;
            } elseif ($productType) {
                return $productType;
            }
            return 'N/A'; // Handle null cases
        })
        ->addColumn('action', 'deliver_orders.datatables_actions_final_deliver');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FinalDeliver $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinalDeliver $model)
    {
        return $model->newQuery()->with([
            'get_deliver_order.get_customer:name,id',
            'get_deliver_order.get_products:name,id',
            'get_deliver_order.get_receivable:name,id',
            'get_deliver_order.get_receive_receipt'
        ])
        ->select('final_deliver_order_id','deliver_order_id','created_at')
        ->where('created_at', '>', date("Y-m-d", strtotime("-4 month")))
        ->distinct();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->addAction(['title'=>'الاجراءات','width' => '120px', 'printable' => false])
        ->parameters([
            'dom'       => 'Bfrtip',
            'stateSave' => true,
            'order'     => [[0, 'desc']],
            'buttons'   => [
                // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create',],
                ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
            ],
            'language' => ['url' => 'js/translate_data_table.json']
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [

            // "م"=>['name'=>'id','data'=>'id'],
            "رقم_الاذن"=>['name'=>'final_deliver_order_id','data'=>'final_deliver_order_id'],

            'work_order_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الغسلة', 
                'data' => 'get_deliver_order.work_order_id',
                'name' => 'get_deliver_order.work_order_id'
               ]),

            'receipt_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'ايصال اضافة', 
                'data' => 'get_deliver_order.receipt_id',
                'name' => 'get_deliver_order.receipt_id'
               ]),

           
      
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_deliver_order.get_customer.name',
                'name' => 'get_deliver_order.get_customer.name'
               ]),
       
            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'product_details',
                'name' => 'product_details'
               ]),
           
            
               "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],
        ];

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'deliver_orders_datatable_' . time();
    }

    
}
