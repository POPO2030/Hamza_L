<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الأسم:') !!}
    <p>{{ $receivable->name }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'رقم التليفون:') !!}
    <p>{{ $receivable->phone }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تم الإنشاء:') !!}
    <p>{{ $receivable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تم التعديل:') !!}
    <p>{{ $receivable->updated_at }}</p>
</div>

