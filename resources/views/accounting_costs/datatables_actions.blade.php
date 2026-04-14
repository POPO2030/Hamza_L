{!! Form::open(['route' => ['accountingCosts.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('accountingCosts.show')
        <a href="{{ route('accountingCosts.show', $id) }}" class='btn btn-link btn-default btn-just-icon'>
            <i class="fa fa-eye"></i>
        </a>
    @endcan
   
    @can('accountingCosts.edit')
        <a href="{{ route('accountingCosts.edit', $id) }}" class='btn btn-link btn-default btn-just-icon'>
            <i class="fa fa-edit"></i>
        </a>
    @endcan

    @can('accountingCosts.destroy')
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endcan
    
</div>
{!! Form::close() !!}
