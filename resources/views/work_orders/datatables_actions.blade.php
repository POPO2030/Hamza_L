<div class="text-center">
{!! Form::open(['route' => ['workOrders.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can("workOrders.show")
    <a href="{{ route('workOrders.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
        <i class="fa fa-eye"></i>
    </a>
    @if (Auth::user()->team_id == 3 ||Auth::user()->team_id == 15)
    <a href="{{ URL('workOrders_print', $id) }}" class='btn btn-link btn-default btn-just-icon print'>
        <i class="fa fa-print"></i>
    </a>
    @else
    <a href="{{ URL('workOrders_print_cs', $id) }}" class='btn btn-link btn-default btn-just-icon print'>
        <i class="fa fa-print"></i>
    </a>
    @endif
  
    @endcan
    @can("workOrders.edit")
    <a href="{{ route('workOrders.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan
    @can("important_workOrders")
    <a href="{{ URL('important_workOrders', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-star"></i>
    </a>
    @endcan
    @can("workOrders.destroy")
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
     @endcan
</div>
{!! Form::close() !!}
</div>
