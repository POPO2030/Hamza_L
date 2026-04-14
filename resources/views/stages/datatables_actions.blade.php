<div class="text-center">
{!! Form::open(['route' => ['stages.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("stages.show")
    <a href="{{ route('stages.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("stages.edit")
    <a href="{{ route('stages.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("stages.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف مرحله الانتاج?')"
    ]) !!}
        @endcan
</div>
{!! Form::close() !!}
</div>