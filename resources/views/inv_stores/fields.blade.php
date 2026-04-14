<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'اسم المخزن: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'stores_name','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
     
    </span>
@endif
    <span id="stores_name-error" class="error-message" style="color: red"></span>
</div>

<!-- category_id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('category_id', 'مجموعة المنتجات: <span style="color: red">*</span>', [], false) !!}
    <div id="category_id-container">
    {{ Form::select('category_id',$category_ids,null,['placeholder' => 'اختر وصف المنتج','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر مجموعة المنتجات", 'style'=>"width: 100%",'id'=>'category_id'],['option'=>'category_ids']) }}
    </div>
    @if ($errors->has('category_id'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('category_id') }}</strong>
     
    </span>
@endif
    <span id="category_id-error" class="error-message" style="color: red"></span>
</div> --}}


<script src="{{ asset('js/fields_config.js') }}"></script>