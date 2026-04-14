<div class="text-center">
{!! Form::open(['route' => ['services.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("services.show")
    <a href="{{ route('services.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan
    @can("services.edit")
    <a href="{{ route('services.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("services.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'تأكيد',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل تريد حذف الخدمه؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
