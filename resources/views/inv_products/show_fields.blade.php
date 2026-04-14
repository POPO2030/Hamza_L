<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'اسم المنتج:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->name }}</span>
</div>

<!-- Category Id Field -->
<div class="col-sm-6">
    {!! Form::label('category_id', 'مجموعه المنتجات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->invproduct_category->name }}</span>
</div>

@if(isset($invProduct) && $invProduct->category_id ==3)
@if(isset($invProduct->get_finalproduct->name))
<!-- Category Id Field -->
<div class="col-sm-6">
    {!! Form::label('description_id', 'نوع المنتج:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->get_finalproduct->name }}</span>
</div>
@endif 

<!-- Category Id Field -->
@if(isset($invProduct->get_product_description->name))
<div class="col-sm-6">
    {!! Form::label('description_id', 'وصف المنتج:') !!}

    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->get_product_description->name }}</span>
</div>
@endif 
@endif 

<!-- Product Request Field -->
<div class="col-sm-6">
    {!! Form::label('product_request', 'حد الطلب:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->product_request }}</span>
</div>

@if(isset($invProduct) && $invProduct->category_id !=3)
<!-- Product Request Field -->
<div class="col-sm-6">
    {!! Form::label('size_id', 'المقاس:') !!}

    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px;">
        @if(isset($invProduct->get_size))
        {{ $invProduct->get_size->name }}
        @endif 
    </span>
</div>
<!-- Product Request Field -->
<div class="col-sm-6">
    {!! Form::label('weight_id', 'السمك:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px;">
        @if(isset($invProduct->get_weight))
        {{ $invProduct->get_weight->name }}
        @endif 
    </span>

</div>

<!-- Product Request Field -->
<div class="col-sm-6">
    {!! Form::label('brand_id', 'الماركه:') !!}

    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px; ">
        @if(isset($invProduct->get_brands))
        {{ $invProduct->get_brands->name }}
        @endif 
    </span>
</div>
{{-- ========================================================================================= --}}
@else
{{-- ========================================================================================== --}}
<!-- Product Request Field -->
<div class="col-sm-6" style="display: none;">
    {!! Form::label('size_id', 'المقاس:') !!}

    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px;">
        @if(isset($invProduct->get_size))
        {{ $invProduct->get_size->name }}
        @endif 
    </span>
</div>
<!-- Product Request Field -->
<div class="col-sm-6" style="display: none;">
    {!! Form::label('weight_id', 'السمك:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px;">
        @if(isset($invProduct->get_weight))
        {{ $invProduct->get_weight->name }}
        @endif 
    </span>

</div>

<!-- Product Request Field -->
<div class="col-sm-6" style="display: none;">
    {!! Form::label('brand_id', 'الماركه:') !!}

    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;height: 42px; ">
        @if(isset($invProduct->get_brands))
        {{ $invProduct->get_brands->name }}
        @endif 
    </span>
</div>

@endif
<!-- Created By Field -->
<div class="col-sm-6">
    {!! Form::label('creator_id', 'انشئ العمليه:') !!}
    @if(!empty($invProduct->get_user->name))
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->get_user->name }}</span>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تم الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->created_at }}</span>
</div>

@if(!empty($invProduct->get_user_update->name))
<!-- Updated By Field -->
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    @if(!empty($invProduct->get_user_update->name))
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->get_user_update->name }}</span>
    @endif
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تم التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->updated_at }}</span>
</div>
@endif


<div class="row" style="margin:3rem 0;width:100%">
      <table id="empTable_color" class="table table-boreder">
          <tr  style="font-weight: bolder;background-color: #e0e4e7 !important;">
          <td class="col-3 text-center">اللون</td>
          <td class="col-6 text-center">الصور</td> 
          </tr>
          @if(isset($table_color_body))
          @foreach($table_color_body as $rows)
              <tr>
                  <td class="col-3 text-center">

                          @foreach($colors as $color)
                              @if($color->id == $rows->get_color->id)
                              @if($color->get_color_code->id == 1)

                                {{' ('.$color->invcolor_category->name.')'}}
                                @else
                                {{' ('.$color->invcolor_category->name.')' .$color->get_color_code->name}}

                              @endif
                              @endif
                          @endforeach
                  </td>
                  <td class="col-6 text-center">
                      <div class="preview" style="display: flex; justify-content: center;">
                          @foreach($rows->images as $image)
                              <img src="{{ asset('uploads/products/' . $image->img) }}" alt="Image" 
                              style="height:100px; width:100px; padding: 5px;border-style: outset; object-fit: contain;">

                              @endforeach
                      </div>
                  </td>
              </tr> 
          @endforeach
      @endif
      </table>
</div>

{{-- ========================================choose unit============================== --}}


<table class="table table-boder"> 
    <tr style="font-weight: bolder;background-color: #e0e4e7 !important;">
        <td class="col-3 text-center">الوحدة</td>
        <td class="col-6 text-center">العدد</td>
    </tr>
@foreach($invProduct->get_units as $row)
    <tr>
        <td class="col-3 text-center">{{$row->name}}</td>
        <td class="col-6 text-center">{{$row->pivot->unitcontent}}</td>
    </tr>
@endforeach
</table>