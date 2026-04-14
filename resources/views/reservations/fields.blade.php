<!-- Customer Id Field -->
<div class="form-group col-sm-6">
{!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
<div id="customer_id-container">
{{ Form::select('customer_id',$customers,null,['placeholder' => 'اختر  عميل ...','class'=> 'form-control searchable ','id'=>'customer_id',  'data-placeholder'=>"اختر  عميل", 'style'=>"width: 100%", 'onchange' => 'handleProductChange()'],['option'=>'customers']) }}
</div>
<span id="customer_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Product Id Field -->
<div class="form-group col-sm-6">
{!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
<div id="product_id-container">
    {{ Form::select('product_id',$products,null,['placeholder' => 'اختر  الصنف ...','class'=> 'form-control searchable ','id'=>'product_id',  'data-placeholder'=>"اختر  الصنف", 'style'=>"width: 100%", 'onchange' => 'handleProductChange1()'],['option'=>'products']) }}
</div>
<span id="product_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', 'رقم الموديل:') !!}
    {!! Form::text('model', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>

<!-- color_thread Field -->
<div class="form-group col-sm-6">
    {!! Form::label('color_thread', 'لون الخيط:') !!}
    {!! Form::text('color_thread', null, ['class' => 'form-control','id'=>'colorthread']) !!}
</div>

<!-- Product Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('initial_product_count', 'العدد: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('initial_product_count', null, ['class' => 'form-control','id'=>'initial_product_count','step'=>'1']) !!}
    <span id="initial_product_count-error" class="error-message" style="color: red"></span>
</div>


@if(isset($reservation))
<div class="form-group col-sm-6">
    {!! Form::label('reservation_date', 'تاريخ الحجز:') !!}
    {{-- {!! Form::date('reservation_date', $reservation->reservation_date, ['class' => 'form-control', 'id' => 'reservation_date', 'readonly' => 'readonly']) !!} --}}
        <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;"> {{ date('Y-m-d H:i:s') }}</span>
    {!! Form::hidden('reservation_date', $reservation->reservation_date, ['id' => 'reservation_date', 'value' => date('Y-m-d H:i:s')]) !!}
</div>
@else
<!-- Reservation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reservation_date', 'تاريخ الحجز:') !!}
    {{-- {!! Form::date('reservation_date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'reservation_date', 'readonly' => 'readonly']) !!} --}}
        <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;"> {{ date('Y-m-d H:i:s') }}</span>
    {!! Form::hidden('reservation_date', date('Y-m-d H:i:s'), ['id' => 'reservation_date']) !!}
</div>
@endif

<!-- Receivable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receivable_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    <div id="receivables-container">
    {{ Form::select('receivable_id',$receivables,null,['placeholder' => 'اختر جهة التسليم ...','class'=> 'form-control searchable ','id'=>'receivables',  'data-placeholder'=>"اختر جهة التسليم", 'style'=>"width: 100%", 'onchange' => 'handleProductChange2()'],['option'=>'receivables']) }}
 </div>
  <span id="receivables-error" class="error-message" style="color: red"></span>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('old_work_orders', ' غسلة سابقة:') !!}
    {{ Form::select('old_work_orders', $old_work_orders, null, ['placeholder' => 'اختر الغسلة...', 'class' => 'form-control searchable', 'data-placeholder' => 'اختر الغسلة', 'id' => 'old_oreder']) }}
</div>

<div class="form-group col-sm-6">
    {{ Form::label('service_item_id', 'الخدمات: <span style="color: red">*</span>', [], false) }}

    <div id="service_item_id-container">
        <div class="d-flex">
            @if (isset($selectedservice))
                {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), $selectedservice, ['class' => 'form-control searchable', 'id' => 'service_item_id', 'data-placeholder' => 'اختر الخدمات', 'style' => 'width: 100%', 'multiple' => 'multiple', 'onchange' => 'handleProductChange3()']) }}
            @else
                {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), null, ['class' => 'form-control searchable', 'id' => 'service_item_id', 'data-placeholder' => 'اختر الخدمات', 'style' => 'width: 100%', 'multiple' => 'multiple', 'onchange' => 'handleProductChange3()']) }}
            @endif

            @error('service_item_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            @if(Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)
                <!--ومدير النظام /خدمه العملاء-->
                <button id="copy-button" type="button" class="btn btn-primary">نسخ</button>
            @endif
        </div>
    </div>
    <span id="service_item_id-error" class="error-message" style="color: red"></span>
</div>



<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255, 'rows' => 3]) !!}
   
</div>




<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
<script>
        $( document ).ready(function() {

$(document).on('change','#old_oreder',function(){
var order_id=$(this).val();


$.ajax({
   type:'get',
   url:"{!!URL::to('/get_old_order_stages')!!}",
   data:{'order_id':order_id},
   success:function(result){
    console.log(result)
    service_item_id
    for (let index = 0; index < result.length; index++) {
        op=document.createElement("option");
        op.innerText=result[index].name
        op.value=result[index].id
        op.setAttribute('selected', 'selected');
        document.getElementById("service_item_id").append(op)


    }


   }
})
})



});
</script>