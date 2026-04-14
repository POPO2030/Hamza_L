<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الاسم:') !!}
    <p>{{ $service->name }}</p>
</div>

<!-- Service Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('service_category_id', 'مجموعه الخدمات:') !!}
    <p>{{ $service->service_category_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $service->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', ' تاريخ اخر تعديل:') !!}
    <p>{{ $service->updated_at }}</p>
</div>

