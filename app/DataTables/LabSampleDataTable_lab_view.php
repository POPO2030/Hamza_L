<?php

namespace App\DataTables;

use App\Models\CRM\LabActivity;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;
use Gate;
class LabSampleDataTable_lab_view extends DataTable
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

        
        return $dataTable->addColumn('action', 'lab_samples.datatables_actions_lab_view');


    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LabActivity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LabActivity $model)
    {
        
        return $model->newQuery()->with(['get_sample.get_customer:name,id','get_sample.get_products:name,id'])->where(function ($query) {
                $query->where('sample_stage_id', 52)
                      ->where(function ($innerQuery) {
                          $innerQuery->where('status', 'open')
                                     ->orWhere('status', 'checked')
                                     ->orWhere('status', 'progressing');
                      });
            });
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
            "م"=>['name'=>'sample_id','data'=>'sample_id'],
            "رقم_العينة"=>['name'=>'get_sample.serial','data'=>'get_sample.serial'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_sample.get_customer.name',
                'name' => 'get_sample.get_customer.name'
               ]),
       
            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'get_sample.get_products.name',
                'name' => 'get_sample.get_products.name'
               ]),

            "عدد_القطع"=>['name'=>'get_sample.count','data'=>'get_sample.count'],
            "عدد_القطع_الاصلية"=>['name'=>'get_sample.sample_original_count','data'=>'get_sample.sample_original_count'],
            "الملاحظات"=>['name'=>'get_sample.note','data'=>'get_sample.note'],
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
