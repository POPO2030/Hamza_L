<div class="text-center">
{!! Form::open(['route' => ['serviceItems.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("serviceItems.show")
    <a href="{{ route('serviceItems.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("serviceItems.edit")
    <a href="{{ route('serviceItems.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("serviceItems.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف عنصر الخدمه؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
