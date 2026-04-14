{!! Form::open(['route' => ['roles.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('roles.show')
    <a href="{{ route('roles.show', $id) }}" class="btn btn-link btn-default btn-just-icon show">
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can('roles.edit')
    <a href="{{ route('roles.edit', $id) }}" class="btn btn-link btn-default btn-just-icon edit">
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('roles.destroy')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
