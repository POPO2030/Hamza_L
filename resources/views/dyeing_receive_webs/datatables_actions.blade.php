{{-- {!! Form::open(['route' => ['dyeingReceiveWebs.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('dyeingReceiveWebs.show', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('dyeingReceiveWebs.edit', $id) }}" class='btn btn-link btn-default btn-just-icon'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!} --}}
<div class='btn-group'>
    @if ($status == 'open')
        <button onclick="add_unique_key({{ $unique_key }})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-check"></i>
        </button>
    @elseif($status == 'checked')
    <span class="badge badge-primary">تم التحقق</span>
    @elseif($status == 'received')
    <span class="badge badge-success">تم الاضافة</span>
    @else
    <span class="badge badge-danger">تم الارسال</span>
    @endif
    
</div>



 

<script>
    function add_unique_key(unique_key){
        document.getElementById('unique_key').value=unique_key
    } 
</script>                