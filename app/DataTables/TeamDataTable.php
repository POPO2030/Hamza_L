<?php

namespace App\DataTables;

use App\Models\CRM\Team;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class TeamDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'teams.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Team $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Team $model)
    {
        // return $model->newQuery();
             $query = $model->newQuery();

        if (auth()->check()) {
            $teamId = auth()->user()->team_id;
            if ($teamId == 11) {
                return $query->whereNotIn('id', [1, 10, 11,13]);
            } elseif ($teamId == 13) {
             return $query->whereIn('id', [1, 10, 13]);
            } elseif ($teamId == 1) {
                return $query; 
            }
        }

        return $query;
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
            "القسم"=>['name'=>'name','data'=>'name']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'teams_datatable_' . time();
    }
}
