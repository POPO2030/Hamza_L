<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    <div id="customer_id-container">
    {{ Form::select('customer_id',$customers,null,['placeholder' => 'اختر  اسم العميل  ...','class'=> 'form-control searchable ','id'=>'customer_id','data-placeholder'=>"اختر اسم العميل", 'style'=>"width: 100%" , 'onchange' => 'handleCustomerChange()'],['option'=>'customers']) }}
</div>
@error('customer_id')
<div class="text-danger">{{ $message }}</div>
@enderror
<span id="customer_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'اسم الصنف: <span style="color: red">*</span>', [], false) !!}
    <div id="product_id-container">
    {{ Form::select('product_id',$products,null,['placeholder' => 'اختر نوع الصنف ...','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر نوع الصنف", 'style'=>"width: 100%",'id'=>'product_id', 'onchange' => 'handleProductChange()'],['option'=>'products']) }}
</div>
    @error('product_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="product_id-error" class="error-message" style="color: red"></span>
</div>


<!-- Fabric Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fabric_id', 'الخامة: <span style="color: red">*</span>', [], false) !!}
    <div id="fabric_id-container">
    {{ Form::select('fabric_id',$fabrics,null,['placeholder' => 'اختر اسم الخامة','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر اسم الخامة", 'style'=>"width: 100%",'id'=>'fabric_id', 'onchange' => 'handleFabricsChange()'],['option'=>'fabrics']) }}
    </div>
    @error('fabric_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="fabric_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Fabric Source Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fabric_source_id', 'مصدر القماش: <span style="color: red">*</span>', [], false) !!}
    <div id="fabric_source_id-container">
    {{ Form::select('fabric_source_id',$fabric_sources,null,['placeholder' => 'اختر مصدر القماش','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر مصدر القماش", 'style'=>"width: 100%",'id'=>'fabric_source_id', 'onchange' => 'handleFabric_sourcesChange()'],['option'=>'fabric_sources']) }}
    </div>
    @error('fabric_source_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="fabric_source_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Serial Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('serial', 'رقم العينة:') !!}
    {!! Form::text('serial', $serial, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
</div> --}}


<!-- Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('count', 'عدد القطع: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('count', null, ['class' => 'form-control' . ($errors->has('model') ? ' is-invalid' : ''),'id'=>'count']) !!}
    @error('count')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="count-error" class="error-message" style="color: red"></span>
</div>

{{-- <div class="form-group col-sm-6">
    {!! Form::label('service_item_id', 'الخدمات:') !!}
    
    <div id="service_item_id-container">
        <div class="d-flex">
            @if (isset($selectedservice))
                {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), $selectedservice, ['class' => 'form-control searchable', 'id' => 'service_item_id', 'data-placeholder' => 'اختر الخدمات', 'style' => 'width: 100%', 'multiple' => 'multiple']) }}
            @else
                {{ Form::select('service_item_id[]', $service_items->pluck('name', 'id'), null, ['class' => 'form-control searchable', 'id' => 'service_item_id', 'data-placeholder' => 'اختر الخدمات', 'style' => 'width: 100%', 'multiple' => 'multiple']) }}
            @endif
            @error('service_item_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <span id="service_item_id-error" class="error-message" style="color: red"></span>
</div> --}}

<div class="form-group col-sm-6">
    {!! Form::label('as_sample', 'مثل العينة:') !!}
    @if (isset($selectedsample))
    {!! Form::checkbox('as_sample',$selectedsample, true) !!}
    @else
    {!! Form::checkbox('as_sample', true) !!}
    @endif
    {!! Form::number('sample_original_count', null, ['class' => 'form-control' , 'placeholder' => 'عدد العينات الاصلية ', ]) !!}
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

<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 3]) !!}
   
</div>
