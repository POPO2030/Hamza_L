<?php

namespace App\DataTables;

use App\Models\inventory\Inv_product;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\inventory\Inv_category;
use Gate;

class Inv_productDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'inv_products.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inv_product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inv_product $model)
    {
        // return $model->newQuery()->with(['invproduct_category:name,id','get_user:name,id']);
        $query = $model->newQuery()->with(['invproduct_category:name,id','get_user:name,id']);
        $inv_category=Inv_category::pluck('id')->toArray();

        if (request()->has('category_id') && in_array(request()->category_id, $inv_category)) {
            $query->where('category_id', request()->category_id);
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
    
        // if (Gate::allows('invProducts.create')) {
        //     $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        // }

        if (Gate::allows('invProducts.create')) {
            $buttons[] = [
                'extend'    => 'create',
                'className' => 'btn btn-default btn-sm no-corner create',
                'text'      => ' <i class="fas fa-plus"></i> اضافه',
                'action'    => 'function() { window.location.href = "' . route('invProducts.create') . '"; }',
                'attr'      => ['id' => 'new_create']
            ];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['invProducts.show', 'invProducts.edit', 'invProducts.destroy'])) {
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
            // "system_code"=>['name'=>'system_code','data'=>'system_code'],
            "كود_المنتج"=>['name'=>'manual_code','data'=>'manual_code'],
            'category_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'مجموعه المنتجات', 
                'data' => 'invproduct_category.name',
                'name' => 'invproduct_category.name'
               ]),
            "المنتج"=>['name'=>'name','data'=>'name'],
               'creator_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'القائم بالانشاء', 
                'data' => 'get_user.name',
                'name' => 'get_user.name'
               ]),
               "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],
               "تاريخ_التعديل"=>['name'=>'updated_at','data'=>'updated_at'],
        ];
    }

    

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'inv_products_datatable_' . time();
    }
}
