<div class="text-center">
{!! Form::open(['route' => ['productCategories.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("productCategories.show")
    <a href="{{ route('productCategories.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("productCategories.edit")
    <a href="{{ route('productCategories.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("productCategories.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف مجموعه الاصناف')"
    ]) !!}
        @endcan
</div>
{!! Form::close() !!}
</div>
