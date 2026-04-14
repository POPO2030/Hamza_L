<div class="text-center">
    {!! Form::open(['route' => ['customers.destroy', $id], 'method' => 'delete']) !!}
 
    <div class="btn-group">
        @can("get_receive_receipt")
        <a href="{{ URL('get_receive_receipt', $id) }}" class="btn btn-link btn-default btn-just-icon get_receive_receipt">
            <i class="fa fa-plus"></i>
        </a>
        @endcan
        @can("customers.show")
        <a href="{{ route('customers.show', $id) }}" class="btn btn-link btn-default btn-just-icon show">
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("customers.edit")
        <a href="{{ route('customers.edit', $id) }}" class="btn btn-link btn-default btn-just-icon edit">
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("customers.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف العميل؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
</div>

