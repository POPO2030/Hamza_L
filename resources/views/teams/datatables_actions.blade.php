{!! Form::open(['route' => ['teams.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('teams.show')
    <a href="{{ route('teams.show', $id) }}" class="btn btn-link btn-default btn-just-icon show">
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can('teams.edit')
    <a href="{{ route('teams.edit', $id) }}" class="btn btn-link btn-default btn-just-icon edit">
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can('teams.destroy')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف القسم؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
