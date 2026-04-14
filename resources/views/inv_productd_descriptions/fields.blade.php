<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'وصف المنتج:<span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'description_name','onkeyup' => 'replaceChars(this)',
    'oninput' => 'replaceChars(this)','onkeypress'=>'return RestrictSpace()']) !!}

    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
<span id="description_name-error" class="error-message" style="color: red"></span>
</div>


<script src="{{ asset('js/fields_config.js') }}"></script>