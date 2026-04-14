
<div class="form-group col-sm-6">
    {!! Form::label('color_code_id', 'كود اللون: <span style="color: red">*</span>', [], false) !!}
    <div id="color_code_id-container">
    {{ Form::select('color_code_id',$color_code,null,['placeholder' => 'اختر كود اللون','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر كود اللون", 'style'=>"width: 100%",'id'=>'color_code_id', 'onchange' => 'handleProductChange1()'],['option'=>'color_code']) }}
</div>
    @error('color_code_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="color_code_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('colorCategory_id', 'مجموعه الالوان: <span style="color: red">*</span>', [], false) !!}
    <div id="colorCategory_id-container">
    {{ Form::select('colorCategory_id',$cats,null,['placeholder' => 'اختر مجموعه الالوان','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر المجموعه", 'style'=>"width: 100%",'id'=>'colorCategory_id', 'onchange' => 'handleProductChange1()'],['option'=>'cats']) }}
</div>
    @error('colorCategory_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="colorCategory_id-error" class="error-message" style="color: red"></span>
</div>


<script src="{{ asset('js/fields_config.js') }}"></script>
