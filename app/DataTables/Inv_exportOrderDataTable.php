<?php

namespace App\DataTables;

use App\Models\inventory\Inv_exportOrder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\inventory\Inv_category;
use Gate;


class Inv_exportOrderDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_export_orders.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_exportOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_exportOrder $model)
    {
        // return $model->newQuery()->with(['get_user:name,id']);
        $query = $model->newQuery()->with(['get_user:name,id']);
        $inv_category=Inv_category::pluck('id')->toArray();

        if (request()->has('product_category_id') && in_array(request()->product_category_id, $inv_category)) {
            $query->where('product_category_id', request()->product_category_id);
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
        $buttons = [];
    
        // if (Gate::allows('invExportOrders.create')) {
        //     $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        // }
        if (Gate::allows('invExportOrders.create')) {
            $buttons[] = [
                'extend'    => 'create',
                'className' => 'btn btn-default btn-sm no-corner create',
                'text'      => ' <i class="fas fa-plus"></i> اضافه',
                'action'    => 'function() { window.location.href = "' . route('invExportOrders.create') . '"; }',
                'attr'      => ['id' => 'new_create']
            ];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invExportOrders.show', 'invExportOrders.edit', 'invExportOrders.destroy'])) {
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
            "م"=>['name'=>'id','data'=>'id'],
            "رقم_المستند"=>['name'=>'manual_id','data'=>'manual_id'],
            "تاريخ_الصرف"=>['name'=>'date_out','data'=>'date_out'],
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
        return 'inv_export_orders_datatable_' . time();
    }
}
