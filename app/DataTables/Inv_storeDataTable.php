<?php

namespace App\DataTables;

use App\Models\inventory\Inv_store;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Inv_storeDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_stores.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_store $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_store $model)
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
    
        if (Gate::allows('invStores.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invStores.show', 'invStores.edit', 'invStores.destroy'])) {
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
            "اسم_المخزن"=>['name'=>'name','data'=>'name']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'inv_stores_datatable_' . time();
    }
}
