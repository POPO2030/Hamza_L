
<div class="row justify-content-center">
    {!! Form::open(['route' => ['invImportOrders.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invImportOrders.show")
            @if ($status == 'pending')
                <a href="{{ route('invImportOrders.show', $id) }}" class='btn btn-link btn-primary btn-just-icon rounded'>
                    <i class="fas fa-thumbs-up"></i>
                </a>
            @else
                <a href="{{ route('invImportOrders.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
                    <i class="fa fa-eye"></i>
                </a>
            @endif
        @endcan
        @can("invImportOrdersReturns.create")
        @if ($model->product_category_id != 3)
        <a href="{{ route('invImportOrdersReturns.create', $id) }}" class='btn btn-link btn-warning btn-just-icon rounded' title ='انشاء مرتجع'>
            <i class="fa fa-undo"></i>
        </a>
        @endif
       @endcan
        @can("invImportOrders.edit")
        <a href="{{ route('invImportOrders.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("product_price.edit_final_product_price")
            @if ($model->product_category_id != 3)
                <a href="{{ route('invImportOrders.edit_product_pricing', $id) }}" class='btn btn-link btn-default btn-just-icon edit' title="التسعير">
                    <i class="fas fa-dollar-sign"></i>
                </a>
            @endif
        @endcan
        @can("invImportOrders.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف اذن اضافة البضاعه؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>