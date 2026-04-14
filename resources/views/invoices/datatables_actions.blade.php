{!! Form::open(['route' => ['invoices.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('invoices.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-print"></i>
    </a>
    {{-- <a href="{{ route('invoices.origenal_invoices', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-receipt"></i>
    </a> --}}
    <a href="{{ route('invoices.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
</div>
{!! Form::close() !!}
