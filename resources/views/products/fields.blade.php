<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'oninvalid'=>"setCustomValidity('يجب ادخال اسم الصنف وان لا تقل عن 2 حرف ولا تزيد عن 50 حرف')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50",'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'مجموعه الاصناف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('category_id',$cats,null,['placeholder' => 'اختر مجموعه الاصناف','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر المجموعه", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('يجب اختيار مجموعه الاصناف')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'cats']) }}
    @error('category_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
</div>