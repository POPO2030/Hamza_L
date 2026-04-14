<?php

namespace App\DataTables;

use App\Models\CRM\Fabric;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class FabricDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'fabrics.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fabric $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Fabric $model)
    {
        return $model->newQuery()->with(['get_fabric_source:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('fabrics.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
    
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['fabrics.show', 'fabrics.edit', 'fabrics.destroy'])) {
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
            "الاسم"=>['name'=>'name','data'=>'name'],
            // 'fabric_source_id'=>new \Yajra\DataTables\Html\Column([
            //     'title' => 'مصدر القماش', 
            //     'data' => 'get_fabric_source.name',
            //     'name' => 'get_fabric_source.name'
            //    ]),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fabrics_datatable_' . time();
    }
}
