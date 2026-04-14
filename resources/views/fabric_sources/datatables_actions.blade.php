{!! Form::open(['route' => ['fabricSources.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("fabricSources.show")
    <a href="{{ route('fabricSources.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("fabricSources.edit")
    <a href="{{ route('fabricSources.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("fabricSources.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
