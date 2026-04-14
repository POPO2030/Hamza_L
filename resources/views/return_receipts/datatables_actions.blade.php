{!! Form::open(['route' => ['returnReceipts.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("returnReceipts.show")
    <a href="{{ route('returnReceipts.show', $id) }}" class='btn btn-link btn-default btn-just-icon print'>
        <i class="fa fa-print"></i>
    </a>
    @endcan
    @can("returnReceipts.edit")
    <a href="{{ route('returnReceipts.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("returnReceipts.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل متأكد من حذف إذن استلام المرتجع ؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
