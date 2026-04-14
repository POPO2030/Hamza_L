{!! Form::open(['route' => ['satgeCategories.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('satgeCategories.show', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('satgeCategories.edit', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف مجموعه المراحل؟')"
    ]) !!}
</div>
{!! Form::close() !!}
