
@if(isset($redirect))
    <input type="hidden" name="redirect" value={{$redirect}}>
@endif

<!-- customer Field -->
@if(isset($customer_data))
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل:') !!}
    <div id="customer_id-container">
    {{ Form::select('customer_id',$customer_data,null,['class'=> 'form-control', 'style'=>"width: 100%;height: 38px; font-size: medium;",'id'=>'customer_id','onchange' => 'handleCustomerChange()'],['option'=>'customer_data']) }}
    </div>
    @error('customer_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="customer_id-error" class="error-message" style="color: red"></span>
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل:') !!}
    <div id="customer_id-container">
    {{ Form::select('customer_id',$customers,null,['placeholder' => '...','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%;height: 38px; font-size: medium;" ,'id'=>'customer_id','onchange' => 'handleCustomerChange()'],['option'=>'customers']) }}
    </div>
    @error('customer_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="customer_id-error" class="error-message" style="color: red"></span>
</div>
@endif

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'اسم الصنف: <span style="color: red">*</span>', [], false) !!}
    <div id="product_id-container">
    {{ Form::select('product_id',$products,null,['placeholder' => '...','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'id'=>'product_id', 'onchange' => 'handleProductChange()'],['option'=>'products']) }}
</div>
    @error('product_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="product_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', 'رقم الموديل:') !!}
    {!! Form::text('model', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>

<!-- Brand Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand', 'الماركة:') !!}
    {!! Form::text('brand', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>


<!-- Initial Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('final_count', 'العدد : <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('final_count', null, ['class' => 'form-control' . ($errors->has('model') ? ' is-invalid' : ''),'id'=>'final_count']) !!}
    @error('final_count')
    <div class="text-danger">{{ $message }}</div>
@enderror
<span id="final_count-error" class="error-message" style="color: red"></span>
</div>

<!-- Receivable Id Field -->
@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4 || Auth::user()->team_id == 3)

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

<div class="form-group col-sm-6">
    {!! Form::label('workOrder_id', 'رقم الغسلة:<span style="color: red">*</span>', [], false) !!}
    <div id="workOrder_id-container">
    {{ Form::select('workOrder_id', $old_work_orders, null, ['placeholder' => 'اختر الغسلة...', 'class' => 'form-control searchable', 'data-placeholder' => 'اختر الغسلة', 'id' => 'workOrder_id', 'onchange' => 'handleWorkOrdersChange()']) }}
</div>
<span id="workOrder_id-error" class="error-message" style="color: red"></span>
</div>
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






