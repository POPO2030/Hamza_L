{!! Form::open(['route' => ['users.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('users.show')
    <a href="{{ route('users.show', $id) }}" class="btn btn-link btn-default btn-just-icon show">
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can('users.edit')
    <a href="{{ route('users.edit', $id) }}" class="btn btn-link btn-default btn-just-icon edit">
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('users.destroy')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
   @endcan
</div>
{!! Form::close() !!}
