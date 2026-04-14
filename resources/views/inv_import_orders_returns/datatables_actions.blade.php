
<div class="row justify-content-center">
    {!! Form::open(['route' => ['invImportOrdersReturns.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invImportOrdersReturns.show")
        <a href="{{ route('invImportOrdersReturns.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan

        @can("invImportOrdersReturns.edit")
        <a href="{{ route('invImportOrdersReturns.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("invImportOrdersReturns.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف اذن مرتجع البضاعه؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>