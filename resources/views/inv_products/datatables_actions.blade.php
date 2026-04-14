
    {!! Form::open(['route' => ['invProducts.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invProducts.show")

        <a href="{{ route('invProducts.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>

            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("invProducts.edit")

        <a href="{{ route('invProducts.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>

            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("invProducts.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف المنتج؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}