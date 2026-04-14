<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'مكان التخزين:') !!}
    <p>{{ $place->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تم الإنشاء:') !!}
    <p>{{ $place->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تم التحديث:') !!}
    <p>{{ $place->updated_at }}</p>
</div>

