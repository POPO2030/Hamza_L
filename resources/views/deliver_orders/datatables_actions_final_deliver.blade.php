
<div class="text-center">
    {!! Form::open(['route' => ['delete_final_deliver_all', $final_deliver_order_id], 'method' => 'post']) !!}
<div class='btn-group'>
    <a href="{{ URL('show_final_deliver', $final_deliver_order_id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-print"></i>
    </a>


    <input type="hidden" name="final_deliver_order_id" value="{{ $final_deliver_order_id }}">
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل انت متأكد من حذف إذن التسليم؟')"
    ]) !!}
</div>
{!! Form::close() !!}
</div>
