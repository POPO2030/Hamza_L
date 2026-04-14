<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الاسم:') !!}
    <p>{{ $serviceItem->name }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'السعر:') !!}
    <p>{{ $serviceItem->price }}</p>
</div>

<!-- Service Id Field -->
<div class="col-sm-12">
    {!! Form::label('service_id', 'الخدمات:') !!}
    <p>{{ $serviceItem->get_category->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $serviceItem->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ اخر تعديل:') !!}
    <p>{{ $serviceItem->updated_at }}</p>
</div>

