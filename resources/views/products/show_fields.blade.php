<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'الصنف:') !!}
    <p>{{ $product->name }}</p>
</div>

<!-- Category Id Field -->
<div class="col-sm-6">
    {!! Form::label('category_id', 'مجموعه الصنف:') !!}
    <p>{{ $product->product_category->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $product->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $product->updated_at }}</p>
</div>

