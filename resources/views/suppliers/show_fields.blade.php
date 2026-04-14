
<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'الأسم:') !!}
    <p>{{ $suppliers->name }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-6">
    {!! Form::label('phone', 'التليفون:') !!}
    <p>{{ $suppliers->phone }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', ' تم الإنشاء:') !!}
    <p>{{ $suppliers->created_at }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-6">
    {!! Form::label('creator_id', 'انشئ العمليه:') !!}
    @if(!empty($suppliers->get_user->name))
    <p>{{ $suppliers->get_user->name }}</p>
    @endif
</div>

<!-- Updated At Field -->
@if(!empty($suppliers->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_at', ' تم التحديث:') !!}
    <p>{{ $suppliers->updated_at }}</p>
</div>

<!-- Updated By Field -->
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    @if(!empty($suppliers->get_user_update->name))
    <p>{{ $suppliers->get_user_update->name }}</p>
    @endif
</div>
@endif