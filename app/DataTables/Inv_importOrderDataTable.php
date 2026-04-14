<?php

namespace App\DataTables;

use App\Models\inventory\Inv_importOrder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\inventory\Inv_category;
use Gate;

class Inv_importOrderDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_import_orders.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_importOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_importOrder $model)
    {
        // return $model->newQuery()->with(['get_supplier:name,id','get_user:name,id']);
        $query = $model->newQuery()->with(['get_supplier:name,id','get_user:name,id']);
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
    
        // if (Gate::allows('invImportOrders.create')) {
        //     $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        // }
        if (Gate::allows('invImportOrders.create')) {
            $buttons[] = [
                'extend'    => 'create',
                'className' => 'btn btn-default btn-sm no-corner create',
                'text'      => ' <i class="fas fa-plus"></i> اضافه',
                'action'    => 'function() { window.location.href = "' . route('invImportOrders.create') . '"; }',
                'attr'      => ['id' => 'new_create']
            ];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invImportOrders.show', 'invImportOrders.edit', 'invImportOrders.destroy'])) {
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
            "الرقم_التسلسلى"=>['name'=>'id','data'=>'id'],
            "تاريخ_الاستلام"=>['name'=>'date_in','data'=>'date_in'],
            'supplier_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم المورد', 
                'data' => 'get_supplier.name',
                'name' => 'get_supplier.name'
            ]),
            'user_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم المستلم', 
                'data' => 'get_user.name',
                'name' => 'get_user.name'
            ]),
            "الملاحظات"=>['name'=>'comment','data'=>'comment']
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'inv_import_orders_datatable_' . time();
    }
}
