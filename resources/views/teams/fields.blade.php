<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'اسم القسم:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
