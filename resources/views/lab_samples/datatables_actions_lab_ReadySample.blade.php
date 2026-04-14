<div class="text-center">
    <div class='btn-group'>
     
        
        @if ($model->status == 'pre_finish')

        {!! Form::open(['route' => ['labConfirmSample'], 'method' => 'post']) !!}
        <input type="hidden" name="sample_id" value="{{ $model->id }}">
            {!! Form::button('<i class="fas fa-check"></i>', [
                'type' => 'submit',
                'class' => 'btn btn-link btn-default btn-just-icon',
                'title' => 'تأكيد استلام العينة',
            ]) !!}
        {!! Form::close() !!}
        @can('return_sample_to_lab')
         <a href="{{ URL('return_sample_to_lab/'.$model->id) }}"  class="btn btn-link btn-primary btn-just-icon" style="height: max-content;" title="عودة العينة الى المعمل"><i class="fas fa-redo"></i></a>
        @endcan
        

       @elseif ($model->status == 'finish')
       <p><span class="badge badge-success" style="font-size: 8px;">تم التأكيد</span></p>

       <button onclick="add_id({{ $model->id }})" class="btn btn-link btn-default btn-just-icon open-ready-modal" data-toggle="modal" data-target="#readyModal"><i class="fas fa-truck"></i></button>
    
            @can('return_sample_to_lab')
            <a href="{{ URL('return_sample_to_lab/'.$model->id) }}"  class="btn btn-link btn-primary btn-just-icon" style="height: max-content;" title="عودة العينة الى المعمل"><i class="fas fa-redo"></i></a>
            @endcan
       @endif
    </div>
    {!! Form::close() !!}
    </div>
    
    
                   <!-- Modify your modal -->
                   <div class="modal fade" id="readyModal" tabindex="-1" role="dialog" aria-labelledby="readyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="readyModalLabel">تأكيد استلام العينة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form id="readyForm" method="post" action="{{ URL('labDeliverSample') }}">
                        @csrf <!-- Add CSRF token field if needed -->
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group col-sm-8">
                                {!! Form::label('receivable_name', 'اسم المستلم: <span style="color: red">*</span>', [], false) !!}
                                {!! Form::text('receivable_name', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                </div>
                              
                                <input id="sample_id" type="hidden" name="sample_id" value="{{ $model->id }}">
                               
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-link btn-primary btn-just-icon">تأكيد</button>
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