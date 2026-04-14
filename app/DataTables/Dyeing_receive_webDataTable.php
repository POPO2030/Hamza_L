<?php

namespace App\DataTables;

use App\Models\CRM\Dyeing_receive;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Dyeing_receive_webDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'dyeing_receive_webs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Dyeing_receive $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dyeing_receive $model)
    {
        return $model->newQuery()
        ->select('*')
        ->selectRaw('sum(quantity) AS quantities ')
        ->groupBy('unique_key');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('dyeingReceiveWebs.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
    
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['get_receive_receipt', 'dyeingReceiveWebs.show', 'dyeingReceiveWebs.edit', 'dyeingReceiveWebs.destroy'])) {
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
            "العميل"=>['name'=>'customer_name','data'=>'customer_name'],
            "الموديل"=>['name'=>'model','data'=>'model'],
            'الخامة'=>['name'=>'cloth_name','data'=>'cloth_name'],
            'النوع'=>['name'=>'product_name','data'=>'product_name'],
            'الكمية'=>['name'=>'quantities','data'=>'quantities'],
            'ملاحظات_المصنع'=>['name'=>'note_elsham2','data'=>'note_elsham2'],
            'ملاحظات_المغسلة'=>['name'=>'note_elsham1','data'=>'note_elsham1'],
            'التاريخ'=>['name'=>'created_at','data'=>'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'dyeing_receive_webs_datatable_' . time();
    }
}
