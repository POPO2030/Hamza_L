<!-- Name Field -->
<div class="form-group col-sm-6">
{!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'autofocus'=>'autofocus','required','oninvalid'=>"setCustomValidity('يجب ادخال اسم المستلم وان لا تقل عن 2 حرف ولا تزيد عن 50 حرف')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50",'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'رقم التليفون:') !!}
    {!! Form::number('phone', null, ['class' => 'form-control',]) !!}
    {{-- @error('phone')
    <div class="text-danger">{{ $message }}</div>
@enderror --}}
</div>