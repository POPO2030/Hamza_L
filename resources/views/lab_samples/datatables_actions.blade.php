{{-- MODIFY: removed the outer Form::open/close that used to wrap the ENTIRE btn-group.
     That caused the labViewfollow form below to be nested inside the delete form,
     which is invalid HTML — browsers then submit the outer (delete) form instead
     of the inner one when you click the paper-plane button. --}}
     <div class='btn-group'>
        @can('labSamples.index')
            @if ($status == 'open')
            {!! Form::open(['route' => ['labViewfollow'], 'method' => 'post']) !!}
            <input type="hidden" name="sample_id" value="{{ $id }}">
                {!! Form::button('<i class="fas fa-paper-plane"></i>', [
                    'type' => 'submit',
                    'class' => 'btn btn-link btn-default btn-just-icon',
                    'title' => 'ارسال العينه الي المعمل',
                    'onclick' => "return confirm('سيتم ارسال العينة الى المعمل')"
                    
                ]) !!}
            {!! Form::close() !!}
            @elseif ($status == 'pre_checked')
            {!! Form::button('<i class="fas fa-check"></i>', 
            ['type' => 'button', 'class' => 'btn btn-link btn-default btn-just-icon', 'style' => 'height: fit-content;','title' => 'العينه قيد انتظار تأكيد الاستلام في المعمل' ]) !!}
            @elseif ($status == 'checked')
            {!! Form::button('<i class="fas fa-flask"></i>', 
            ['type' => 'button', 'class' => 'btn btn-link btn-default btn-just-icon', 'style' => 'height: fit-content;','title' => 'العينه قيد انتظار التشغيل في المعمل' ]) !!}
            @elseif ($status == 'progressing')
            {!! Form::button('<i class="fas fa-flask"></i>', 
            ['type' => 'button', 'class' => 'btn btn-link btn-info btn-just-icon', 'style' => 'height: fit-content;','title' => 'العينه تحت التشغيل في المعمل' ]) !!}
            @elseif ($status == 'pre_finish')
            {!! Form::button('<i class="fas fa-store"></i>',
            ['type' => 'button', 'class' => 'btn btn-link btn-default btn-just-icon', 'style' => 'height: fit-content;' ,'title' => 'متواجده الان في مخزن العينات خدمه العملاء قيد التأكيد']) !!}
            @elseif ($status == 'finish')
            {!! Form::button('<i class="fas fa-store"></i>',
            ['type' => 'button', 'class' => 'btn btn-link btn-warning btn-just-icon', 'style' => 'height: fit-content;' ,'title' => 'متواجده الان في مخزن العينات  للتسليم الي العميل']) !!}
            @else
            {!! Form::button('<i class="fas fa-check"></i>', 
            ['type' => 'button', 'class' => 'btn btn-link btn-success btn-just-icon', 'style' => 'height: fit-content;','title' => 'تم التسليم الي العميل']) !!}
            @endif
        @endcan
    
    
        @can('lab_samples.show')
        <a href="{{ route('lab_samples.show', $id) }}" class='btn btn-link btn-default btn-just-icon'>
            <i class="fa fa-eye"></i>
        </a>
        @endcan
        @can('labSamples.print')
        <a href="{{ route('labSamples.print', $id) }}" class='btn btn-link btn-default btn-just-icon'>
            <i class="fa fa-print"></i>
        </a>
        @endcan
        @can('labSamples.edit')
        <a href="{{ route('labSamples.edit', $id) }}" class='btn btn-link btn-default btn-just-icon'>
            <i class="fa fa-edit"></i>
        </a>
        @endcan
        @can('labSamples.destroy')
        {{-- ADD: Form::open/close moved here so it wraps ONLY the delete button,
             instead of the whole btn-group. Same route/method/logic as before. --}}
        {!! Form::open(['route' => ['labSamples.destroy', $id], 'method' => 'delete']) !!}
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-danger btn-just-icon',
            'onclick' => "return confirm('هل أنت متأكد?')"
        ]) !!}
        {!! Form::close() !!}
     @endcan
    </div>