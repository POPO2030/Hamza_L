
<div class="text-center">
    {!! Form::open(['route' => ['suppliers.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("suppliers.show")
        <a href="{{ route('suppliers.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can("suppliers.edit")
        <a href="{{ route('suppliers.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("suppliers.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف بيانات المورد؟')"
        ]) !!}
        @endcan
    </div>
    {!! Form::close() !!}
    </div>