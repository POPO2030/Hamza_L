<?php

namespace App\DataTables;

use App\Models\inventory\Color;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class ColorDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'colors.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Color $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Color $model)
    {
        return $model->newQuery()->with('invcolor_category:name,id','get_color_code:name,id');
    }


    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('colors.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['colors.show', 'colors.edit', 'colors.destroy'])) {
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
            "مسلسل"=>['name'=>'id','data'=>'id'],
            // "كود اللون"=>['name'=>'name','data'=>'name'],
            'color_code_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'كود اللون', 
                'data' => 'get_color_code.name',
                'name' => 'get_color_code.name'
               ]),
            'colorCategory_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الالوان', 
                'data' => 'invcolor_category.name',
                'name' => 'invcolor_category.name'
               ]),


        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'colors_datatable_' . time();
    }
}
