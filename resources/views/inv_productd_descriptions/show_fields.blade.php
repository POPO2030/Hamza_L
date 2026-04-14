<!-- Model Code Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'الاسم:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{   $invProductdDescription->name }}</span>
</div>

<!-- User Id Field -->
@if(!empty($invProductdDescription->get_user->name))
<div class="col-sm-6">
    {!! Form::label('creator_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{   $invProductdDescription->get_user->name }}</span>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invProductdDescription->created_at }}</span>
</div>
@endif

@if(!empty($invProductdDescription->updated_by))
<!-- Updated By Field -->
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    @if(!empty($invProductdDescription->get_user_update->name))
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invProductdDescription->get_user_update->name }}</span>
    @endif
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProductdDescription->updated_at }}</span>
</div>
@endif

