<div class="text-center">
    {!! Form::open(['route' => ['colorCategories.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("colorCategories.show")
        <a href="{{ route('colorCategories.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("colorCategories.edit")
        <a href="{{ route('colorCategories.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("colorCategories.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف مجموعه الالوان')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>