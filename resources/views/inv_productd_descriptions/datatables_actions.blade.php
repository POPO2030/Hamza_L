
<div class="row justify-content-center">
    {!! Form::open(['route' => ['invProductdDescriptions.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invProductdDescriptions.show")
        <a href="{{ route('invProductdDescriptions.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("invProductdDescriptions.edit")
        <a href="{{ route('invProductdDescriptions.edit', $id) }}" class='btn btn-default btn-sm edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("invProductdDescriptions.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف وصف المنتج؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>
