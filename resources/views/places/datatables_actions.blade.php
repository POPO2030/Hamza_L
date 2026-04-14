<div class="text-center">
{!! Form::open(['route' => ['places.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("places.show")
    <a href="{{ route('places.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("places.edit")
    <a href="{{ route('places.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("places.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
