<div class="text-center">
{!! Form::open(['route' => ['serviceCategories.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("serviceCategories.show")
    <a href="{{ route('serviceCategories.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("serviceCategories.edit")
    <a href="{{ route('serviceCategories.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("serviceCategories.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف مجموعه الخدمات؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
