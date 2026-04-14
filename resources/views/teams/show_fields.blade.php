<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'اسم القسم:') !!}
    <p>{{ $team->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تم الإنشاء:') !!}
    <p>{{ $team->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تم التحديث:') !!}
    <p>{{ $team->updated_at }}</p>
</div>

