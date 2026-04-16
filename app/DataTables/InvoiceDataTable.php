<?php

namespace App\DataTables;

use App\Models\accounting\Invoice;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;

class InvoiceDataTable extends DataTable
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

            return $dataTable
                // ->editColumn('branch', function ($row) {
                //     return $row->branch == 1 ? 'جسر السويس' : ($row->branch == 2 ? 'بلقس' : 'غير معروف');
                // })
                ->addColumn('action', 'invoices.datatables_actions');
        }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        return $model->newQuery()->with('get_customer:name,id','get_user:name,id');
    }



    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('invoices.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
    
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['invoices.show', 'invoices.edit', 'invoices.destroy'])) {
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
            "رقم_الفاتوره"=>['name'=>'id','data'=>'id'],

            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),

            // "المبلغ_الاصلى"=>['name'=>'amount_original','data'=>'amount_original'],
            // "المبلغ_المعدل"=>['name'=>'amount_edit','data'=>'amount_edit'],
            // "الخصم"=>['name'=>'discount','data'=>'discount'],
            "الاجمالى"=>['name'=>'amount_net','data'=>'amount_net'],
            // "الفرع" => ['name' => 'branch', 'data' => 'branch'],

            'creator_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'القائم بالإنشاء', 
                'data' => 'get_user.name',
                'name' => 'get_user.name'
               ]),
            "التاريخ" => ['name' => 'date', 'data' => 'date'],
        ];
    }

    protected function filename()
    {
        return 'invoices_datatable_' . time();
    }
}
