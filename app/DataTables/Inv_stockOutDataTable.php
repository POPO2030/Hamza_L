<?php

namespace App\DataTables;

use App\Models\inventory\Inv_stockOut;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;



class Inv_stockOutDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_stock_outs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_stockOut $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_stockOut $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->with(['get_user:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('invStockOuts.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invStockOuts.show', 'invStockOuts.edit', 'invStockOuts.destroy'])) {
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
            "الرقم_التسلسلى"=>['name'=>'id','data'=>'id'],
            "تاريخ_الصرف"=>['name'=>'date_out','data'=>'date_out'],
            "الملاحظات"=>['name'=>'comment','data'=>'comment'],
            'user_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم المستلم', 
                'data' => 'get_user.name',
                'name' => 'get_user.name'
               ])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'inv_stock_outs_datatable_' . time();
    }
}
