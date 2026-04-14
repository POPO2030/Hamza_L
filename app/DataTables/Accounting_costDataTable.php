<?php

namespace App\DataTables;

use App\Models\accounting\Accounting_cost;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Accounting_costDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'accounting_costs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Accounting_cost $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Accounting_cost $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('accountingCosts.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['accountingCosts.show', 'accountingCosts.edit', 'accountingCosts.destroy'])) {
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
    protected function getColumns()
    {
        return [
            'رقم_الغسلة' => ['name' => 'work_order_id', 'data' => 'work_order_id'],
            // 'work_order_id'=>new \Yajra\DataTables\Html\Column([
            //     'title' => 'رقم الأوردر', 
            //     'data' => 'get_work_order.id',
            //     'name' => 'get_work_order.id'
            // ]),
            // 'final_product_id'=>new \Yajra\DataTables\Html\Column([
            //     'title' => 'نوع الأوردر', 
            //     'data' => 'get_model.get_finalproduct.name',
            //     'name' => 'get_model.get_finalproduct.name'
            // ]),
            'اجمالي_تكلفة_الغسلة' => ['name' => 'model_price', 'data' => 'model_price'],
            'كمية_الغسلة' => ['name' => 'total_contract_quantity', 'data' => 'total_contract_quantity'],
            'ملاحظات' => ['name' => 'notes', 'data' => 'notes'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'accounting_costs_datatable_' . time();
    }
}
