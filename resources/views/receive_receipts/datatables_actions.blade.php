<div class="text-center">
{!! Form::open(['route' => ['receiveReceipts.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("receiveReceipts.show")
    <a href="{{ route('receiveReceipts.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-print"></i>
    </a>
    @endcan
    @can("receiveReceipts.edit")
    <a href="{{ route('receiveReceipts.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("receiveReceipts.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف اذن اضافة؟')"
    ]) !!}
      @endcan
</div>
{!! Form::close() !!}
</div>
