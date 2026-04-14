<div class="text-center">
{!! Form::open(['route' => ['reservations.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("reservations.show")
    <a href="{{ route('reservations.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("reservations.edit")
    <a href="{{ route('reservations.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan

    <a href="{{ URL('reservation_print', $id) }}" class='btn btn-link btn-default btn-just-icon print'>
        <i class="fa fa-print"></i>
    </a>

    @can("reservations.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد الحذف؟')"
    ]) !!}
      @endcan
</div>
{!! Form::close() !!}
</div>
