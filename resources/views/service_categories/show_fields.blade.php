<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الاسم:') !!}
    <p>{{ $serviceCategory->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', ' تاريخ الانشاء:') !!}
    <p>{{ $serviceCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', ' تاريخ اخر تعديل:') !!}
    <p>{{ $serviceCategory->updated_at }}</p>
</div>

