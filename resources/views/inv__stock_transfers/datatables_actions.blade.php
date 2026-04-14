
<div class="text-center">
    {!! Form::open(['route' => ['invStockTransfers.destroy', $id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can("invStockTransfers.show")
            @if ($status == 'pending')
                <a href="{{ route('invStockTransfers.show', $id) }}" class='btn btn-link btn-primary btn-just-icon rounded'>
                    <i class="fas fa-thumbs-up"></i>
                </a>
            @else
                <a href="{{ route('invStockTransfers.show', $id) }}" class='btn btn-link btn-default btn-just-icon show'>
                    <i class="fa fa-eye"></i>
                </a>
            @endif
        @endcan
        @can("invStockTransfers.edit")
        <a href="{{ route('invStockTransfers.edit', $id) }}" class='btn btn-link btn-default btn-just-icon edit'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can("invStockTransfers.destroy")
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon destroy',
            'onclick' => "return confirm('هل تريد حذف مجموعه المنتجات؟')"
        ]) !!}
         @endcan
    </div>
    {!! Form::close() !!}
    </div>
    