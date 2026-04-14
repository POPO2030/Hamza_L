<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'اسم مجموعه الاصناف: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'required','oninvalid'=>"setCustomValidity('يجب ادخال اسم مجموعه الانتاج وان لا تقل عن 2 حرف ولا تزيد عن 50 حرف')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50",'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
</div>