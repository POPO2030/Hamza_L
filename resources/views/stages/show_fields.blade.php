<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'اسم المرحله:') !!}
    <p>{{ $stage->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $stage->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $stage->updated_at }}</p>
</div>

