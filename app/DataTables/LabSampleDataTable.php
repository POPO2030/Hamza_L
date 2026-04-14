<?php

namespace App\DataTables;

use App\Models\CRM\LabSample;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;
use Gate;
class LabSampleDataTable extends DataTable
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

        
        return $dataTable->addColumn('action', 'lab_samples.datatables_actions');


    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LabSample $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LabSample $model)
    {
        
        return $model->newQuery()->with(['get_customer:name,id','get_products:name,id']);
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
                ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create',],
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
            "م"=>['name'=>'id','data'=>'id'],
            "رقم_العينة"=>['name'=>'serial','data'=>'serial'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
       
            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'get_products.name',
                'name' => 'get_products.name'
               ]),

            "عدد_القطع"=>['name'=>'count','data'=>'count'],
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
        return 'lab_samples_datatable_' . time();
    }
}
