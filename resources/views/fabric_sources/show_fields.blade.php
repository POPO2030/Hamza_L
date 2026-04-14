<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'مصدر القماش:') !!}
    <p>{{ $fabricSource->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تم الانشاء:') !!}
    <p>{{ $fabricSource->created_at }}</p>
</div>


<!-- Created By Field -->
@if(!empty($fabricSource->get_user->name))
<div class="col-sm-6">
    {!! Form::label('creator_id', 'انشئ العمليه:') !!}
    <p>{{ $fabricSource->get_user->name }}</p>
</div>
@endif

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تم التعديل:') !!}
    <p>{{ $fabricSource->updated_at }}</p>
</div>


<!-- Updated By Field -->
@if(!empty($fabricSource->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <p>{{ $fabricSource->get_user_update->name }}</p>
</div>
@endif
