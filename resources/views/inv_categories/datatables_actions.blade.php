
<div class="text-center">
{!! Form::open(['route' => ['invCategories.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("invCategories.show")
    <a href="{{ route('invCategories.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("invCategories.edit")
    <a href="{{ route('invCategories.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("invCategories.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف مجموعه المنتجات؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
