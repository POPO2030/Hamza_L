<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'fabric_name','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
    <span id="name-error" class="error-message" style="color: red"></span>
</div>

{{-- <!-- Fabric Source Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fabric_source_id', 'مصدر القماش: <span style="color: red">*</span>', [], false) !!}
    <div id="fabric_source_id-container">
    {{ Form::select('fabric_source_id',$fabric_sources,null,['placeholder' => 'اختر مصدر القماش','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر مصدر القماش", 'style'=>"width: 100%",'id'=>'fabric_source_id', 'onchange' => 'handleFabric_sourcesChange()'],['option'=>'fabric_sources']) }}
    </div>
    @error('fabric_source_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="fabric_source_id-error" class="error-message" style="color: red"></span>
</div> --}}

