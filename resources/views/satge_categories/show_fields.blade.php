<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'مجموعات مراحل الانتاج:') !!}
    <p>{{ $satgeCategory->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $satgeCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $satgeCategory->updated_at }}</p>
</div>

