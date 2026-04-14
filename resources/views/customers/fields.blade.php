<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'customer_name','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
<span id="name-error" class="error-message" style="color: red"></span>
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'التليفون: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('phone', null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''),'id'=>'phone','minlength' => 7,'maxlength' => 12]) !!}

    @if ($errors->has('phone'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('phone') }}</strong>
    </span>
    @endif
    <span id="phone-error" class="error-message" style="color: red"></span>
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-6">
{!! Form::label('mobile', 'المحمول:') !!}
{!! Form::number('mobile', null, ['class' => 'form-control','minlength' => 7,'maxlength' => 12]) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'العنوان:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
    @error('address')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'البريد الألكترونى:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
    @error('email')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
