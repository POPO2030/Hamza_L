<?php

namespace App\DataTables;

use App\Models\CRM\ProductCategory;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class ProductCategoryDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'product_categories.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProductCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProductCategory $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('productCategories.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['productCategories.show', 'productCategories.edit', 'productCategories.destroy'])) {
            $dataTable->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false]);
        }

        return $dataTable->parameters([
            'dom'       => 'Bfrtip',
            'stateSave' => true,
            'order'     => [[0, 'desc']],
            'buttons'   => $buttons,
            'language'  => ['url' => 'js/translate_data_table.json']
        ]);
        
        // return $this->builder()
        //     ->columns($this->getColumns())
        //     ->minifiedAjax()
        //     ->addAction(['title'=>'الاجراءات','width' => '120px', 'printable' => false])
        //     ->parameters([
        //         'dom'       => 'Bfrtip',
        //         'stateSave' => true,
        //         'order'     => [[0, 'desc']],
        //         'buttons'   => [
        //             ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create',],

        //             ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
        //             ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
        //             // ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
        //             // ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
        //         ],
        //         'language' => ['url' => 'js/translate_data_table.json']
        //     ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            "مجموعه _ الاصناف"=>['name'=>'name','data'=>'name'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'product_categories_datatable_' . time();
    }
}
