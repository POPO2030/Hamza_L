<?php

namespace App\DataTables;

use App\Models\CRM\Stage;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class StageDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'stages.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Stage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Stage $model)
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
    
        if (Gate::allows('stages.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['stages.show', 'stages.edit', 'stages.destroy'])) {
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
            "مرحله _ الانتاج"=>['name'=>'name','data'=>'name'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'stages_datatable_' . time();
    }
}
