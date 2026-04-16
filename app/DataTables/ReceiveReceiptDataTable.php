<?php

namespace App\DataTables;

use App\Models\CRM\ReceiveReceipt;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;

class ReceiveReceiptDataTable extends DataTable
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
        ->addColumn('product_details', function ($row) {
            $productName = $row->get_product->name ?? '';
            $productType = $row->product_type ?? '';

            if ($productName && $productType) {
                return $productName . ' (' . $productType . ')';
            } elseif ($productName) {
                return $productName;
            } elseif ($productType) {
                return $productType;
            }
            return 'N/A'; // Handle null cases
        })
        // ->editColumn('branch', function ($row) {
        //     return $row->branch == 1 ? 'جسر السويس' : ($row->branch == 2 ? 'بلقس' : '');
        // })
        ->addColumn('action', 'receive_receipts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReceiveReceipt $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReceiveReceipt $model)
    {
        return $model->newQuery()->with(['get_product:name,id','get_customer:name,id','get_receivables:name,id']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
{
    $buttons = [];

    // if (Auth::user()->team_id == 1) {
    //     $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
    // }

    $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
    $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];


    return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false])
        ->parameters([
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


            "رقم_الاذن"=>['name'=>'id','data'=>'id'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => ' العميل',
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
            "رقم_الموديل"=>['name'=>'model','data'=>'model'],
            // "الماركة"=>['brand'=>'brand','data'=>'brand'],
            //"الصورة"=>['img'=>'img','data'=>'img'],
            //"الوزن-المبدئى"=>['initial_weight'=>'initial_weight','data'=>'initial_weight'],
            "العدد_المبدئى"=>['initial_count'=>'initial_count','data'=>'initial_count'],
            "الوزن_الفعلى"=>['final_weight'=>'final_weight','data'=>'final_weight'],
            "العدد_الفعلى"=>['final_count'=>'final_count','data'=>'final_count'],
            'على _الانتاج'=>['name'=>'is_workOreder','data'=>'is_workOreder'],

            'product_details'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'product_details',
                'name' => 'product_details'
               ]),

            'receivable_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'المستلم',
                'data' => 'get_receivables.name',
                'name' => 'get_receivables.name'
               ]),

            "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],
            // "الفرع"=>['name'=>'branch','data'=>'branch'],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'receive_receipts_datatable_' . time();
    }
}
