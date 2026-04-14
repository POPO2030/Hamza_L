  <!-- Name Field -->
  <div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'service_name', 'onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!}
    <span id="name-error" class="error-message" style="color: red"></span>
</div>

<!-- Service Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_category_id', 'مجموعة الخدمات:') !!}
    <div id="service-category-container">
        {{ Form::select('service_category_id', $cats, null, ['placeholder' => 'اختر مجموعة...', 'class' => 'form-control searchable', 'id' => 'service_category_id', 'data-placeholder' => 'اختر مجموعة', 'style' => 'width: 100%', 'onchange' => 'removeError(this)']) }}
    </div>
    <span id="service-category-error" class="error-message" style="color: red"></span>
</div>