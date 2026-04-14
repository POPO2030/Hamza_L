<div class="text-center">
{!! Form::open(['route' => ['deliverOrders.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ URL('print_barcode', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-barcode"></i>
    </a>
    <a href="{{ route('deliverOrders.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-print"></i>
    </a>
    <a href="{{ route('deliverOrders.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    {{-- <a href="{{ route('show_final_deliver', $deliver_order_id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-print">2</i>
    </a> --}}
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
</div>

