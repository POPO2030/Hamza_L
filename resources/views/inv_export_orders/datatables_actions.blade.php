<div class="row justify-content-center">
    {!! Form::open(['route' => ['invExportOrders.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invExportOrders.show")
        <a href="{{ route('invExportOrders.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan

        @can("invExportOrders.edit")
        <a href="{{ route('invExportOrders.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        {{-- @can("invExportOrders.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف اذن صرف بضاعه؟')"
        ]) !!}
        @endcan --}}
        @can("invExportOrders.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف اذن صرف البضاعه؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>