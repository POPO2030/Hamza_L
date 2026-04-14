
<div class="text-center">
{!! Form::open(['route' => ['invStores.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("invStores.show")
    <a href="{{ route('invStores.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("invStores.edit")
    <a href="{{ route('invStores.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("invStores.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف المخازن؟')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
</div>

