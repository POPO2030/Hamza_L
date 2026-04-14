<?php

namespace App\DataTables;

use App\Models\inventory\invImportOrders_returns;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class invImportOrders_returnsDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_import_orders_returns.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\invImportOrders_returns $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(invImportOrders_returns $model)
    {
        // return $model->newQuery();
          return $model->newQuery()->with(['get_supplier:name,id','get_user:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
        
    public function html()
    {
        if (Gate::allows(['invImportOrdersReturns.create'])) {
        $buttonHtml = '<div class="button-container" >';
        $buttonHtml .= '<button type="button" class="btn btn-primary btn-sm no-corner" data-toggle="modal" data-target="#myModal" >';
        $buttonHtml .= '<i class="fas fa-plus"></i> اضافه';
        $buttonHtml .= '</button>';
        $buttonHtml .= '</div>';
    }else{
        $buttonHtml = '';
    }
        $buttons = [
            ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'],
            ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'],
        ];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['invImportOrdersReturns.show', 'invImportOrdersReturns.edit', 'invImportOrdersReturns.destroy'])) {
            $dataTable->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false]);
        }

        return $dataTable->parameters([
            'dom'       => 'Bfrtip',
            'stateSave' => true,
            'order'     => [[0, 'desc']],
            'buttons'   => [$buttonHtml,$buttons],
            'language'  => ['url' => 'js/translate_data_table.json'],
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
            "تاريخ_الصرف"=>['name'=>'date_out','data'=>'date_out'],
            "الملاحظات"=>['name'=>'comment','data'=>'comment'],
            // 'customer_id'=>new \Yajra\DataTables\Html\Column([
            //     'title' => 'اسم العميل', 
            //     'data' => 'get_customer.name',
            //     'name' => 'get_customer.name'
            // ]),
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
        return 'inv_import_orders_returns_datatable_' . time();
    }
}
