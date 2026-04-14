<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'اسم البنك: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'customer_name','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
<span id="name-error" class="error-message" style="color: red"></span>
</div>

{{-- <!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'الرصيد: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('amount', null, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''),'id'=>'amount','minlength' => 7,'maxlength' => 12]) !!}

    @if ($errors->has('amount'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('amount') }}</strong>
    </span>
    @endif
    <span id="amount-error" class="error-message" style="color: red"></span>
</div> --}}