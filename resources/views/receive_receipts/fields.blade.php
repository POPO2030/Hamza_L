<style>
    .theme-light .modal-content {
        width: 65rem
    }
</style>
@if(isset($redirect))
    <input type="hidden" name="redirect" value={{$redirect}}>
@endif

<!-- customer Field -->
@if(isset($customer_data))
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل:') !!}
    {{ Form::select('customer_id',$customer_data,null,['class'=> 'form-control','id'=>'customer_id','style'=>"width: 100%;height: 38px; font-size: medium;",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customer_data']) }}
    @error('customer_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل:') !!}
    {{ Form::select('customer_id',$customers,null,['placeholder' => '...','class'=> 'form-control searchable ','id'=>'customer_id', 'data-placeholder'=>"...", 'style'=>"width: 100%;height: 38px; font-size: medium;",'required', 'oninvalid'=>"setCustomValidity('اختر عميل')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customers']) }}
    @error('customer_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
@endif

<!-- Product Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'اسم الصنف: <span style="color: red">*</span>', [], false) !!}
    <div id="product_id-container">
    {{ Form::select('product_id',$products,null,['placeholder' => '...','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'id'=>'product_id', 'onchange' => 'handleProductChange()'],['option'=>'products']) }}
</div>
    @error('product_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="product_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Product Type Field -->
@if (isset($receiveReceipt))
    <div class="form-group col-sm-2">
        {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
        <div id="product_type-container">
        {{ Form::select('product_type', [
        'رجالى' => 'رجالى',
        'اولادى' => 'اولادى',
        'حريمى' => 'حريمى',
        'بناتى' => 'بناتى',
        'محير' => 'محير',
        ],$receiveReceipt->product_type,['placeholder' => '...','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'id'=>'product_type', 'onchange' => 'handleProductTypeChange()']) }}
    </div>
        @error('product_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="product_type-error" class="error-message" style="color: red"></span>
    </div>
@else
    <div class="form-group col-sm-2">
        {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
        <div id="product_type-container">
        {{ Form::select('product_type', [
        'رجالى' => 'رجالى',
        'اولادى' => 'اولادى',
        'حريمى' => 'حريمى',
        'بناتى' => 'بناتى',
        'محير' => 'محير',
        ],null,['placeholder' => '...','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'id'=>'product_type', 'onchange' => 'handleProductTypeChange()']) }}
    </div>
        @error('product_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="product_type-error" class="error-message" style="color: red"></span>
    </div>
@endif


<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', 'رقم الموديل:') !!}
    {!! Form::text('model', null, ['class' => 'form-control','id'=>'model_number','minlength' => 2,'maxlength' => 50]) !!}
</div>

<!-- Brand Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand', 'الماركة:') !!}
    {!! Form::text('brand', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>


<!-- Initial Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('initial_count', 'العدد المبدئى: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('initial_count', null, ['class' => 'form-control' . ($errors->has('model') ? ' is-invalid' : ''),'id'=>'initial_count']) !!}
    @error('initial_count')
    <div class="text-danger">{{ $message }}</div>
@enderror
<span id="initial_count-error" class="error-message" style="color: red"></span>
</div>

{{-- 
<!-- Final Count Field -->
<div class="form-group col-sm-6" id='final_count'>
    {!! Form::label('final_count', 'العدد الفعلى:') !!}
    {!! Form::number('final_count', null, ['class' => 'form-control', 'id' => 'final_ncount', 'readonly' => 'readonly']) !!}
    @error('final_count')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Final Weight Field -->
<div class="form-group col-sm-6" id='final_weight'>
    {!! Form::label('final_weight', 'الوزن الفعلى:') !!}
    {!! Form::number('final_weight', null, ['class' => 'form-control', 'id' => 'final_nweight', 'readonly' => 'readonly']) !!}
    @error('final_weight')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div> --}}

<!-- Receivable Id Field -->
@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4 || Auth::user()->team_id == 3|| Auth::user()->team_id == 15)

<div class="form-group col-sm-6">
    {!! Form::label('receivable_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    <div id="receivables-container">
    {{ Form::select('receivable_id',$receivables,null,['placeholder' => 'اختر جهة التسليم ...','class'=> 'form-control searchable ','id'=>'receivables',  'data-placeholder'=>"اختر جهة التسليم", 'style'=>"width: 100%", 'onchange' => 'handleProductChange1()'],['option'=>'receivables']) }}
</div>
<span id="receivables-error" class="error-message" style="color: red"></span>
</div>
@else
@if(isset($workOrder))
<div class="form-group col-sm-6">
    {!! Form::label('receivable_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('receivable_id', $workOrder->get_receivables->name, ['class' => 'form-control','id'=>'receivables','step'=>'1','required','oninvalid'=>"setCustomValidity('اضف عميل')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
    {!! Form::hidden('receivable_id', $workOrder->get_receivables->id, ['class' => 'form-control','id'=>'receivable_id','step'=>'1','required','oninvalid'=>"setCustomValidity('اضف عميل')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}</div>
</div>
@endif
@endif

<!-- color_thread Field -->
<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255, 'rows' => 3]) !!}
   
</div>

<!-- Img Field -->
<div class="form-group col-sm-6">
    {!! Form::label('img', 'الصور:') !!}
    {!! Form::file('img[]', ['multiple' => true, 'class' => 'form-control', 'id' => 'img', 'data-browse' => 'اختر الصور']) !!}
    <div class="preview">
        @if (!empty($temp))
            @foreach ($temp as $image)
                <div class="col-sm-10">
                    <img class="img-thumbnail" src="{{ asset($image) }}" alt="preview" style="height: 200px;">
                </div>
            @endforeach
        @endif
    </div>
    @error('img')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="errorSpan" class="error" style="color: red;font-weight:bold"></span>
</div>

<div class="form-group col-sm-3">
    {!! Form::label('branch', 'الفرع:') !!}
    {!! Form::select('branch', ['1' => 'جسر السويس','2' => 'بلقس'], null, ['class' => 'form-control', 'id' => 'branch']) !!}
</div>


{{-- ==========================start Modal =================== --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">الموديلات المرسلة من المغسلة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered" id="customer_orders">
                <tr>
                    <td>رقم الموديل</td>
                    <td>الصنف</td>
                    <td>الكمية</td>
                    <td>اختر</td>
                </tr>
              </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
          <button type="button" class="btn btn-primary" id="save_orders">تأكيد</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="dyeing_receives_id" id="dyeing_receives_id">
  <input type="hidden" name="unique_key" id="unique_key">
{{-- ==========================end Modal =================== --}}



<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script>
    $( document ).ready(function() {
        var customer_id = document.getElementById('customer_id').value
        
    $.ajax({
        type:'get',
        url:"{!!URL::to('/get_customer_orders')!!}",
        data:{'customer_id':customer_id},
        success: function(data){
            console.log(data)
            if(data && data.length>0){
                for(item of data){
                row = document.createElement("tr")

                td1 = document.createElement("td")
                input1 = document.createElement("input")
                input1.setAttribute('disabled','disabled')
                input1.value =item.model 
                td1.append(input1)

                td2 = document.createElement("td")
                input2 = document.createElement("input")
                input2.setAttribute('disabled','disabled')
                input2.value =item.product_name + ' ' + item.cloth_name
                td2.append(input2)

                td3 = document.createElement("td")
                input3 = document.createElement("input")
                input3.setAttribute('disabled','disabled')
                input3.value =item.quantities
                td3.append(input3)

                td4 = document.createElement("td")
                input4 = document.createElement("input")
                input4.setAttribute('type','radio')
                input4.setAttribute('value',item.id)
                input4.classList.add('radio')
                input4.setAttribute('name','check')
                td4.append(input4)

                input5 = document.createElement("input")
                input5.setAttribute('type','hidden')
                input5.setAttribute('value',item.dyeing_requests_ids)
                input5.classList.add('dyeing_receives_id')
                td4.append(input5)

                input6 = document.createElement("input")
                input6.setAttribute('type','hidden')
                input6.setAttribute('value',item.unique_key)
                // input6.setAttribute('name','unique_key')
                input6.classList.add('unique_key')
                td4.append(input6)


                row.append(td1 , td2 , td3 ,td4)

                document.getElementById('customer_orders').append(row)
            }

            $('#exampleModal').modal('show');
            }
 
            
        }
    });

    $('#save_orders').click(function(){
        var radios = document.getElementsByClassName('radio')
        for(radio of radios){
            if(radio.checked){
                var model = radio.parentNode.parentNode.children[0].children[0].value
                var quantity = radio.parentNode.parentNode.children[2].children[0].value
                var ids = radio.parentNode.parentNode.children[3].children[1].value
                var unique_key = radio.parentNode.parentNode.children[3].children[2].value
                // var ids_array=ids.split('0')
               
                document.getElementById('model_number').value=model
                document.getElementById('model_number').setAttribute('readonly','readonly')
                document.getElementById('initial_count').value=quantity
                document.getElementById('dyeing_receives_id').value=ids
                document.getElementById('unique_key').value=unique_key

                $('#exampleModal').modal('hide');
            }
        }
    })

})

</script>


