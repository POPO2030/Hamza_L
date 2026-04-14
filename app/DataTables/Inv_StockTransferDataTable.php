<?php

namespace App\DataTables;

use App\Models\inventory\Inv_StockTransfer;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class Inv_StockTransferDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv__stock_transfers.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_StockTransfer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_StockTransfer $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->with(['get_user:name,id','get_store_in:name,id','get_store_out:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('invStockTransfers.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invStockTransfers.show', 'invStockTransfers.edit', 'invStockTransfers.destroy'])) {
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
            // "من_مخزن"=>['name'=>'store_out','data'=>'store_out'],
            'store_out'=>new \Yajra\DataTables\Html\Column([
                'title' => 'من_مخزن', 
                'data' => 'get_store_out.name',
                'name' => 'get_store_out.name'
            ]),
            'store_in'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الى_مخزن', 
                'data' => 'get_store_in.name',
                'name' => 'get_store_in.name'
            ]),
            // "الى_مخزن"=>['name'=>'store_in','data'=>'store_in'],
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
        return 'inv__stock_transfers_datatable_' . time();
    }
}
