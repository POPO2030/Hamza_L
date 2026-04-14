{!! Form::open(['route' => ['createSamples.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("createSamples.show")
    <a href="{{ route('createSamples.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("createSamples.edit")
    <a href="{{ route('createSamples.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("createSamples.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
