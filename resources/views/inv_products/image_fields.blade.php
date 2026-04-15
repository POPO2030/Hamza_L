@extends('layouts.app')

@push('page_css')
@endpush

@section('title')
    {{__('تعديل المنتجات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-cube heart-beat"></i>
                    تعديل المنتجات
                </h1>
            </div>
          </div>
        </div>
      </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($invProduct, ['route' => ['invProducts.updateimage', $invProduct->id], 'method' => 'patch','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">


              <div class="col-sm-4">
                    {!! Form::label('category_id', 'مجموعه المنتجات:') !!}
                    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->invproduct_category->name }}</span>
                <input type="hidden" value="{{$invProduct->category_id}}" id="category_id">
                  </div>
              <div class="col-sm-4">
                  {!! Form::label('name', 'اسم المنتج:') !!}
                  <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->name }}</span>
              </div>

              <!-- Manual Code Field -->
            <div class="col-sm-4">
                {!! Form::label('manual_code', 'كود المنتج:') !!}
                <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->manual_code }}</span>
            </div>
              
              
              
              <!-- Product Request Field -->


            <div class="col-sm-4">
              {!! Form::label('unit_id', ' الوحدة:', [], false) !!}
              <div id="unit_id-container">
              {{-- <select name="unit_id" id="unit_id" class="form-control searchable"> --}}
                  @foreach($units as $unit)
                          @if($unit->id == $table_body->get_unit->id)
                              {{-- <option value="{{$unit->id}}" selected>{{$unit->name}}</option> --}}
                              <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$unit->name}}</span>
                          @endif
                  @endforeach
              {{-- </select> --}}
              </div>
          </div>
              
          <div class="col-sm-4">
            {!! Form::label('product_request', 'حد الطلب:') !!}
            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invProduct->product_request }}</span>
        </div>
              
              <div class="row" style="margin:3rem 0;width:100%">
              
                          <table id="empTable_color" class="table table-boreder">
                              <tr style="font-weight: bolder;background-color: #e0e4e7 !important;">
                              <td class="col-3 text-center">اللون</td>
                              <td class="text-center">اختيار الصور</td>
                              <td class="text-center">الصور</td>
                              </tr>
                          
                              <tr>
                                  <td>
                                      <div id="color_id-container">
  
                                          <select name="color_id" id="color_id" class="form-control searchable">
                                            <option value="" selected>اختر اللون</option>
                                            @foreach($colors as $color)
                                                @if (isset($table_color_body))
                                                    @if ($color->id == $table_color_body->color_id)
                                                        @if($color->get_color_code->id == 1)
                                                            <option value="{{$color->id}}" selected>{{$color->invcolor_category->name}}</option>
                                                        @else
                                                            <option value="{{$color->id}}" selected>{{$color->get_color_code->name.' ('.$color->invcolor_category->name.')'}}</option>
                                                        @endif
                                                    @else
                                                        @if($color->get_color_code->id == 1)
                                                            <option value="{{$color->id}}">{{$color->invcolor_category->name}}</option>
                                                        @else
                                                            <option value="{{$color->id}}">{{$color->get_color_code->name.' ('.$color->invcolor_category->name.')'}}</option>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                      </div>
                                      @error('color_id')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                      <span id="color_id-error" class="error-message" style="color: red"></span>
                                      </div>
                                  </td>
              
                                  <td>
              
                                      <input type="file" multiple class="form-control img" id="img" name="img[]">
                   
                                      <span class="text-danger errorSpan" id="errorSpan"></span>
                                  </td>
              
                                      <td>
                                          <div class="preview" style="display: flex;">
                                              @if (isset($table_color_body))
                                                  @foreach($table_color_body->images as $image)
                                                      <img src="{{ asset('uploads/products/' . $image->img) }}" alt="Image" style="height:100px;">
                                                      <input type="hidden" class="form-control imgs" id="imgs" name="imgs[]" value="{{$image->img}}">
                                                  @endforeach
                                              @endif    
                                          </div>
                                      </td>

                          </table>
                          <span id="validationMessage_color" style="color: red;"></span>
 
              </div>
                          


{{-- ========================================choose unit============================== --}}

</div>
</div>

<div class="card-footer">
  {!! Form::submit('حفظ', ['class' => 'btn btn-success btn-sm save']) !!}
    <a href="{{ route('invProducts.index') }}" class="btn btn-secondary btn-sm">الغاء</a>
</div>

{!! Form::close() !!}

</div>
</div>
@endsection

@push('page_scripts')
<script src="{{ asset('js/views_js/image_recevie_receipts.js') }}"></script>
@endpush
