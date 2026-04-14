<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'اسم الخزينة:') !!}
    <p>{{ $treasury->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $treasury->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $treasury->updated_at }}</p>
</div>

