<!-- Treasury Id Field -->
<div class="col-sm-12">
    {!! Form::label('treasury_id', 'اسم الخزينة:') !!}
    <p>{{ $treasuryDetails->treasury_id }}</p>
</div>

<!-- Treasury Journal Field -->
<div class="col-sm-12">
    {!! Form::label('treasury_journal', 'يوميه الخزينة:') !!}
    <p>{{ $treasuryDetails->treasury_journal }}</p>
</div>

<!-- Credit Field -->
<div class="col-sm-12">
    {!! Form::label('credit', 'دائن:') !!}
    <p>{{ $treasuryDetails->credit }}</p>
</div>


<!-- Debit Field -->
<div class="col-sm-12">
    {!! Form::label('debit', 'مدين:') !!}
    <p>{{ $treasuryDetails->debit }}</p>
</div>

<!-- Debit Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'تفاصي:') !!}
    <p>{{ $treasuryDetails->details }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $treasuryDetails->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $treasuryDetails->updated_at }}</p>
</div>

