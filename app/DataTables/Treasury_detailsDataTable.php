<?php

namespace App\DataTables;

use App\Models\sales\Treasury_details;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class Treasury_detailsDataTable extends DataTable
{

    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
    
        return $dataTable
            ->addColumn('action', 'treasury_details.datatables_actions')
            ->editColumn('get_customer_details.get_customer.name', function ($row) {
                return optional(optional($row->get_customer_details)->get_customer)->name ?? '---';
            })
            ->editColumn('get_banks.name', function ($row) {
                return optional($row->get_banks)->name ?? '---';
            });
    }

    public function query(Treasury_details $model)
    {
        return $model->newQuery()->with('get_treasury:name,id')->with('get_payment_type:name,id','get_customer_details.get_customer:name,id','get_banks:name,id');
    }


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
                // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create',],
                ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
            ],
            'language' => ['url' => 'js/translate_data_table.json']
        ]);
    }

    protected function getColumns()
    {
        return [
            "م"=>['name'=>'id','data'=>'id'],
            'treasury_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'اسم_الخزينة', 
                'data' => 'get_treasury.name',
                'name' => 'get_treasury.name'
               ]),
            "يوميه_الخزينة"=>['name'=>'treasury_journal','data'=>'treasury_journal'],
            'payment_type_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'نوع الدفع', 
                'data' => 'get_payment_type.name',
                'name' => 'get_payment_type.name'
               ]),
            "دائن"=>['name'=>'credit','data'=>'credit'],
            "مدين"=>['name'=>'debit','data'=>'debit'],

       
            'treasury_details_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer_details.get_customer.name',
                'name' => 'get_customer_details.get_customer.name'
               ]),

            'bank_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'البنك', 
                'data' => 'get_banks.name',
                'name' => 'get_banks.name'
               ]),



            "تفاصيل"=>['name'=>'details','data'=>'details'],
            "تاريخ_الانشاء"=>['name'=>'date','data'=>'date'],
        ];
    }

    protected function filename()
    {
        return 'treasury_details_datatable_' . time();
    }
}
