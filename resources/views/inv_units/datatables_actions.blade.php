
<div class="text-center">
{!! Form::open(['route' => ['invUnits.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("invUnits.show")
    <a href="{{ route('invUnits.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("invUnits.edit")
    <a href="{{ route('invUnits.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("invUnits.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف وحده القياس؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
</div>
