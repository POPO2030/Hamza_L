<?php

namespace App\DataTables;

use App\Models\CRM\Create_sample;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\CRM\LabSample;
use Auth;
use Gate;

class Create_sampleDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'create_samples.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Create_sample $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LabSample $model)
    {
        $ids=Create_sample::pluck('sample_id')->toArray();
        
        return $model->newQuery()->with(['get_customer:name,id','get_products:name,id'])
        ->whereIn('id',$ids)
        ->orderBy('created_at', 'DESC')
        ->orderBy('updated_at', 'DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $customButton = [
            'text' => '<i class="fas fa-plus"></i> اضافه',
            'className' => 'btn btn-primary btn-sm no-corner',
            'attr' => [
                'class' => 'btn btn-primary btn-sm no-corner', // Set the class attribute without relying on automatic assignment
            ],
            'action' => "function () {
                // Add the logic you want to execute when the button is clicked
                // For example, you can open a modal here
                $('#myModal').modal('show');
            }",
        ];
    
        $buttons = [
            $customButton, // Your custom button comes first
            ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'],
            ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'],
            ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner'],
            ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner'],
        ];
    
        $dataTable = $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax();
    
        if (Gate::any(['createSamples.show', 'createSamples.edit', 'createSamples.destroy'])) {
            $dataTable->addAction(['title' => 'الاجراءات', 'width' => '120px', 'printable' => false]);
        }
    
        return $dataTable->parameters([
            'dom'       => 'Bfrtip',
            'stateSave' => true,
            'order'     => [[0, 'desc']],
            'buttons'   => $buttons, // Combine the custom button with DataTables buttons
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
            "م"=>['name'=>'id','data'=>'id'],
            "رقم_العينة"=>['name'=>'serial','data'=>'serial'],
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

            "عدد_القطع"=>['name'=>'count','data'=>'count'],
            "تاريخ_الانشاء"=>['name'=>'created_at','data'=>'created_at'],
            // "الحالة"=>['name'=>'status','data'=>'status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'lab_samples_datatable_' . time();
    }
}
