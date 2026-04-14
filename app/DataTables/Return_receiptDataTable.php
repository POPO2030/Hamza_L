<?php

namespace App\DataTables;

use App\Models\CRM\Return_receipt;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;

class Return_receiptDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'return_receipts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Return_receipt $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Return_receipt $model)
    {
        return $model->newQuery()->with(['get_product:name,id','get_customer:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];

    if (Auth::user()->team_id == 1) {
        $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
    }

    $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
    $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];


    return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false])
        ->parameters([
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
            "رقم-الاذن"=>['name'=>'id','data'=>'id'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم-العميل',
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
            "رقم-الموديل"=>['name'=>'model','data'=>'model'],
            "الماركة"=>['brand'=>'brand','data'=>'brand'],
            // "العدد-المبدئى"=>['initial_count'=>'initial_count','data'=>'initial_count'],
            "الوزن-الفعلى"=>['final_weight'=>'final_weight','data'=>'final_weight'],
            "العدد-الفعلى"=>['final_count'=>'final_count','data'=>'final_count'],

            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم-الصنف',
                'data' => 'get_product.name',
                'name' => 'get_product.name'
               ]),

            "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'return_receipts_datatable_' . time();
    }
}
