<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'نوع الدفع:') !!}
    <p>{{ $paymentType->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $paymentType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تارخ التعديل:') !!}
    <p>{{ $paymentType->updated_at }}</p>
</div>

