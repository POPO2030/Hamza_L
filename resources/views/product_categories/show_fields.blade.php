<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'مجموعه الاصناف:') !!}
    <p>{{ $productCategory->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $productCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $productCategory->updated_at }}</p>
</div>

