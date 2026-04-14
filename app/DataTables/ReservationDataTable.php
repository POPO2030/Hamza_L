<?php

namespace App\DataTables;

use App\Models\CRM\Reservation;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Gate;
class ReservationDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'reservations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model)
    {
        return $model->newQuery()->with(['get_customer:name,id','get_products:name,id'])->where('status','open');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
    
        if (Gate::allows('reservations.create')) {
            $buttons[] = ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner create'];
        }
        
        $buttons[] = ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'];
        $buttons[] = ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'];

        $dataTable = $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax();


        if (Gate::any(['reservations.show', 'reservations.edit', 'reservations.destroy'])) {
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
            "كود"=>['name'=>'id','data'=>'id'],
            'customer_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'العميل', 
                'data' => 'get_customer.name',
                'name' => 'get_customer.name'
               ]),
       
            'product_id'=>new \Yajra\DataTables\Html\Column([
                'title' => 'الصنف', 
                'data' => 'get_products.name',
                'name' => 'get_products.name'
               ]),
               "رقم_الموديل"=>['name'=>'model','data'=>'model'],
               "الخيط"=>['name'=>'color_thread','data'=>'color_thread'],
            "العدد_المبدئي"=>['name'=>'initial_product_count','data'=>'initial_product_count'],
            "تاريخ_الحجز"=>['name'=>'reservation_date','data'=>'reservation_date'],
            // "الحاله"=>['name'=>'status','data'=>'status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'reservations_datatable_' . time();
    }
}
