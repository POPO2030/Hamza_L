{!! Form::open(['route' => ['fabrics.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("fabrics.show")
    <a href="{{ route('fabrics.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("fabrics.edit")
    <a href="{{ route('fabrics.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("fabrics.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
