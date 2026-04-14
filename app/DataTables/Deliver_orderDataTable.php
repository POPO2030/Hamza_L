<?php

namespace App\DataTables;

use App\Models\CRM\Deliver_order;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class Deliver_orderDataTable extends DataTable
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
            $productName = $row->get_receive_receipt->get_product->name ?? '';
            $productType = $row->get_receive_receipt->product_type ?? '';

            if ($productName && $productType) {
                return $productName . ' (' . $productType . ')';
            } elseif ($productName) {
                return $productName;
            } elseif ($productType) {
                return $productType;
            }
            return 'N/A'; // Handle null cases
        })
        ->addColumn('action', 'deliver_orders.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Deliver_order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Deliver_order $model)
    {
        return $model->newQuery()->with(['get_customer:name,id','get_products:name,id','get_receivable:name,id','get_receive_receipt'])
        ->withSum('get_details', 'total'); 
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
        return [

            "اذن_ التغليف"=>['name'=>'id','data'=>'id'],
            "الغسلة"=>['name'=>'work_order_id','data'=>'work_order_id'],
            "ايصال-الاضافة"=>['name'=>'receipt_id','data'=>'receipt_id'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
       
            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'product_details',
                'name' => 'product_details'
               ]),
            'receive_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'المستلم', 
                'data' => 'get_receivable.name',
                'name' => 'get_receivable.name'
               ]),
            
               "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],

            //    'total' => new \Yajra\DataTables\Html\Column([
            //     'title' => 'إجمالي الكمية',
            //     'data' => 'get_details_sum_total',
            //     'name' => 'get_details_sum_total'
            // ])
        ];
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
