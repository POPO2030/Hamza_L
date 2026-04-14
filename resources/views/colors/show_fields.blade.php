<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'كود اللون:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $color->get_color_code->name }}</span>
</div>

<!-- colorcategory_id Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'اسم مجموعه الالوان:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $color->invcolor_category->name }}</span>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $color->created_at }}</span>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $color->updated_at }}</span>
</div>

