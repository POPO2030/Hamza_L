<?php

namespace App\DataTables;

use App\Models\inventory\Color_code;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Color_codeDataTable extends DataTable
{

    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'color_codes.datatables_actions');
    }

    public function query(Color_code $model)
    {
        return $model->newQuery();
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


    protected function getColumns()
    {
        return [
            "كود_اللون"=>['name'=>'name','data'=>'name'],
        ];
    }

    protected function filename()
    {
        return 'color_codes_datatable_' . time();
    }
}
