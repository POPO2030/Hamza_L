<!-- Name Field -->
<div class="form-group col-sm-6">
   {!! Form::label('name', 'اسم المرحلة: <span style="color: red">*</span>', [], false) !!}
   {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'required','oninvalid'=>"setCustomValidity('يجب ادخال اسم المرحله وان لا تقل عن 2 حرف ولا تزيد عن 50 حرف')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50"
   ,'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
   @if ($errors->has('name'))
   <span class="invalid-feedback" role="alert">
       <strong>{{ $errors->first('name') }}</strong>
   </span>
   @endif
</div>

<div class="form-group col-sm-6">
    {!! Form::label('stage_category_id', 'مجموعة المراحل:') !!}
    {{ Form::select('stage_category_id', $cats, null, ['placeholder' => 'اختر مجموعة...', 'class' => 'form-control searchable', 'data-placeholder' => 'اختر مجموعة', 'style' => 'width: 100%']) }}
</div>