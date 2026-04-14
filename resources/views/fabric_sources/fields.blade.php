<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'fabric_source_name','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
    <span id="name-error" class="error-message" style="color: red"></span>
</div>