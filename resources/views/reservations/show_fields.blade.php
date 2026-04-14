<input type="hidden" name="reservation_id" value="{{$reservation->id}}">
<!-- Receive Receipt Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receive_receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    <div id="receipts-container">
    {{ Form::select('receive_receipt_id',$receipts,null,['placeholder' => 'اختر رقم الاذن ...','class'=> 'form-control searchable ','id'=>'receipts',  'data-placeholder'=>"اختر رقم الاذن", 'style'=>"width: 100%", 'onchange' => 'handleProductChange()'],['option'=>'receipts']) }}
</div>
<span id="receipts-error" class="error-message" style="color: red"></span>
</div>

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('customer_id',$customers,null,['placeholder' => 'اختر  عميل ...','class'=> 'form-control searchable ','id'=>'customer_id',  'data-placeholder'=>"اختر  عميل", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('العميل مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customers']) }}
    </div>
    
    <!-- Product Id Field -->
    <div class="form-group col-sm-6">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
        {{ Form::select('product_id',$products,null,['placeholder' => 'اختر  الصنف ...','class'=> 'form-control searchable ','id'=>'products',  'data-placeholder'=>"اختر  الصنف", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity(' الصنف مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'products']) }}
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

<!-- Initial Product Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('initial_product_count', ' العدد المبدئى: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('initial_product_count', null, ['class' => 'form-control','id'=>'initial_product_count','step'=>'1']) !!}
    <span id="initial_product_count-error" class="error-message" style="color: red"></span>
</div>


<div class="form-group col-sm-6">

    
    @if(isset($reservation))
    {!! Form::label('service_item_id', 'الخدمات: <span style="color: red">*</span>', [], false) !!}
    <div id="service_item_id-container">
    {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), $selectedservice, [
            'class' => 'form-control searchable','id' => 'service_item_id','data-placeholder' => 'اختر الخدمات','style' => 'width: 100%','multiple' => 'multiple', 'onchange' => 'handleProductChange1()'])}}
     </div>
     <span id="service_item_id-error" class="error-message" style="color: red"></span>
    @else
    {!! Form::label('service_item_id', 'الخدمات: <span style="color: red">*</span>', [], false) !!}
    <div id="service_item_id-container">
    {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), null, [
            'class' => 'form-control searchable','id' => 'service_item_id','data-placeholder' => 'اختر الخدمات','style' => 'width: 100%','multiple' => 'multiple', 'onchange' => 'handleProductChange1()'])}}
       </div>
       <span id="service_item_id-error" class="error-message" style="color: red"></span>
    @endif
    </div>

<!-- Receivable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receivable_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receivable_id',$receivables,null,['placeholder' => 'اختر جهة التسليم ...','class'=> 'form-control searchable ','id'=>'receivables',  'data-placeholder'=>"اختر جهة التسليم", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('جهة التسليم مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receivables']) }}
</div>



<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255, 'rows' => 3]) !!}
   
</div>