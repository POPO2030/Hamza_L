<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'users.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // return $model->newQuery();
          $query = $model->newQuery()->with(['role:name,id'])->with(['teams:name,id']);

             if (auth()->user()->team_id == 11) {
                $query->whereNotIn('team_id', [1, 10, 13]);
            }elseif (auth()->user()->team_id == 13) {
                 $query->whereIn('team_id', [10,13]);
            }elseif (auth()->user()->team_id == 1) {
                return $query; 
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
  
            "الاسم _ بالكامل"=>['name'=>'name','data'=>'name'],
            "اسم _ المستخدم"=>['name'=>'username','data'=>'username'],
            'team_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'القسم', 
                'data' => 'teams.name',
                'name' => 'teams.name'
               ]),
            'role_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصلاحيات', 
                'data' => 'role.name',
                'name' => 'role.name'
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
        return 'users_datatable_' . time();
    }
}
