<div class="text-center">
{!! Form::open(['route' => ['receivables.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("receivables.show")
    <a href="{{ route('receivables.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("receivables.edit")
    <a href="{{ route('receivables.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("receivables.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
        @endcan
</div>
{!! Form::close() !!}
</div>
