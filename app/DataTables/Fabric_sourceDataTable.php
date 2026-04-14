<?php

namespace App\DataTables;

use App\Models\CRM\Fabric_source;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Fabric_sourceDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'fabric_sources.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fabric_source $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Fabric_source $model)
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
    
        if (Gate::allows('fabricSources.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
    
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['fabricSources.show', 'fabricSources.edit', 'fabricSources.destroy'])) {
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
            "مصدر_القماش"=>['name'=>'name','data'=>'name'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fabric_sources_datatable_' . time();
    }
}
