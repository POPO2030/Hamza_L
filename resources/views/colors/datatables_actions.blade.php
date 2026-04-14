
<div class="row justify-content-center">
    {!! Form::open(['route' => ['colors.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("colors.show")
        <a href="{{ route('colors.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("colors.edit")
        <a href="{{ route('colors.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("colors.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف اللون')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>