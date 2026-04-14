<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'اسم مجموعه المنتج:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invCategory->name }}</span>
</div>

<!-- Created By Field -->
@if(!empty($invCategory->get_user->name))
<div class="col-sm-6">
    {!! Form::label('creator_id', 'انشئ العمليه:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invCategory->get_user->name }}</span>
</div>
@endif
<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تم الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invCategory->created_at }}</span>
</div>

<!-- Updated By Field -->
@if(!empty($invCategory->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invCategory->get_user_update->name}}</span>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تم التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invCategory->updated_at }}</span>
</div>
@endif

