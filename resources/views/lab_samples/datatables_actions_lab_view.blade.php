<div class="text-center">
    <div class='btn-group'>
     
        
        @if ($model->status == 'open')

        {!! Form::open(['route' => ['labRecieveCheck'], 'method' => 'post']) !!}
        <input type="hidden" name="sample_id" value="{{ $model->sample_id }}">
            {!! Form::button('<i class="fas fa-check"></i>', [
                'type' => 'submit',
                'class' => 'btn btn-link btn-success btn-just-icon',
                'title' => 'استلام العينة',
            ]) !!}
        {!! Form::close() !!}

        @elseif ($model->status == 'checked')

       <p><span class="badge badge-info">تم الاستلام</span></p> 

        {!! Form::open(['route' => ['labCloseSample'], 'method' => 'post']) !!}
            <input type="hidden" name="sample_id" value="{{ $model->sample_id }}">
            {!! Form::button('<i class="fas fa-flask"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link btn-default btn-just-icon',
            'title' => 'بدء تشغيل العينة',
        ]) !!}
        {!! Form::close() !!}
       @elseif ($model->status == 'progressing')
       <p><span class="badge badge-info" style="font-size: 8px;">تم الاستلام</span></p>&nbsp;
       <p><span class="badge badge-info" style="font-size: 8px;">تم التشغيل</span></p>
       <button onclick="add_id({{ $model->sample_id }})" class="btn btn-link btn-default btn-just-icon open-ready-modal" data-toggle="modal" data-target="#readyModal" ><i class="fas fa-store"></i></button>
       
       @endif

       @can('lab_samples.show')
       <a href="{{ route('lab_samples.show', $model->sample_id) }}" class='btn btn-link btn-default btn-just-icon' >
           <i class="fa fa-eye"></i>
       </a>
       @endcan
    </div>
    {!! Form::close() !!}
    </div>
    
    
                   <!-- Modify your modal -->
                   <div class="modal fade" id="readyModal" tabindex="-1" role="dialog" aria-labelledby="readyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="readyModalLabel">تفاصيل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form id="readyForm" method="post" action="{{ URL('labReadySample') }}">
                        @csrf <!-- Add CSRF token field if needed -->
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group col-sm-8">
                                {!! Form::label('receive_name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
                                {!! Form::text('receive_name', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                </div>
                              
                                <input id="sample_id" type="hidden" name="sample_id" value="{{ $model->sample_id }}">
                                <div class="form-group col-sm-12">
                                    {!! Form::label('note', 'ملحوظات:') !!}
                                    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 3]) !!}
                                
                                </div>
                               
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">تأكيد</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>

                <script>
                    function add_id(id){
                        document.getElementById('sample_id').value=id
                    }
            
            
                    
                </script>                