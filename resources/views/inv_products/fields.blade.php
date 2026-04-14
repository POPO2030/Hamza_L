<!-- Category Id Field -->
{{-- @if(in_array(Auth::user()->team_id, [1, 2, 3,4,5])) --}}
    {{-- <div class="form-group col-sm-4">
        {!! Form::label('category_id', 'مجموعه المنتجات: <span style="color: red">*</span>', [], false) !!}
        <div id="category_id-container">
            {{ Form::select('category_id', $cats, null, ['placeholder' => 'اختر مجموعه المنتجات', 'class' => 'form-control searchable', 'data-placeholder' => "اختر المجموعه", 'style' => "width: 100%", 'id' => 'category_id', 'onchange' => 'handleProductChange1()'], ['option' => 'cats']) }}
        </div>
        @error('category_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="category_id-error" class="error-message" style="color: red"></span>
    </div>
@else --}}
    <div class="form-group col-sm-4">
        {!! Form::label('category_id', 'مجموعه المنتجات: <span style="color: red">*</span>', [], false) !!}
        <div id="category_id-container">
            <!-- except(3) لاظهار مجموعات الانتاج الا المجموعه بكود 3 -->
            {{ Form::select('category_id', $cats, null, ['placeholder' => 'اختر مجموعه المنتجات', 'class' => 'form-control searchable', 'data-placeholder' => "اختر المجموعه", 'style' => "width: 100%", 'id' => 'category_id', 'onchange' => 'handleProductChange1()'], ['option' => 'cats']) }}
        </div>
        @error('category_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="category_id-error" class="error-message" style="color: red"></span>
    </div>
{{-- @endif --}}

<!-- Name Field -->
<div class="form-group col-sm-4">
    {!! Form::label('name', 'اسم المنتج: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'id'=>'product_name','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
<span id="product_name-error" class="error-message" style="color: red"></span>
</div>

@if (isset($invProduct))
    <div class="form-group col-sm-4">
        {!! Form::label('opening_balance', 'رصيد افتتاحي: <span style="color: red">*</span>', [], false) !!}
        {!! Form::text('opening_balance',$opening_balance , ['class' => 'form-control' . ($errors->has('opening_balance') ? ' is-invalid' : ''),'id'=>'opening_balance','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
        @if ($errors->has('opening_balance'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('opening_balance') }}</strong>
        </span>
    @endif
    <span id="opening_balance-error" class="error-message" style="color: red"></span>
    </div>
@else
    <div class="form-group col-sm-4">
        {!! Form::label('opening_balance', 'رصيد افتتاحي: <span style="color: red">*</span>', [], false) !!}
        {!! Form::text('opening_balance',0 , ['class' => 'form-control' . ($errors->has('opening_balance') ? ' is-invalid' : ''),'id'=>'opening_balance','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
        @if ($errors->has('opening_balance'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('opening_balance') }}</strong>
        </span>
    @endif
    <span id="opening_balance-error" class="error-message" style="color: red"></span>
    </div>
@endif


<!-- Manual Code Field -->
<div class="form-group col-sm-4">
    {!! Form::label('manual_code', 'كود المنتج <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('manual_code', null, ['class' => 'form-control','id'=>'manual_code']) !!}
    @if ($errors->has('manual_code'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('manual_code') }}</strong>
        </span>
    @endif
    <span id="manual_code-error" class="error-message" style="color: red"></span>
</div>



<!-- Product Request Field -->
<div class="form-group col-sm-4">
    {!! Form::label('product_request', ' حد الطلب(اصغر وحدة): <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('product_request', 5, ['class' => 'form-control' . ($errors->has('product_request') ? ' is-invalid' : ''),'id'=>'product_request','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @if ($errors->has('product_request'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('product_request') }}</strong>
    </span>
@endif
<span id="product_request-error" class="error-message" style="color: red"></span>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('unit_id', ' الوحدة: <span style="color: red">*</span>', [], false) !!}
    <div id="unit_id-container">
    <select name="unit_id" id="unit_id" class="form-control searchable">
        <option value="" selected>اختر الوحدة</option>
        @foreach($units as $unit)
            @if (isset($table_body))
                @if($unit->id == $table_body->get_unit->id)
                    <option value="{{$unit->id}}" selected>{{$unit->name}}</option>
                @else
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                @endif
            @else
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endif
        @endforeach
    </select>
    </div>
    @error('unit_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
<span id="unit_id-error" class="error-message" style="color: red"></span>
</div>
{{-- <span id="validationMessage" style="color: red;"></span> --}}




<div class="row" style="margin:3rem 0;width:100%">

          {{-- <button onclick="addRow_color()" type="button" class="btn btn-primary btn-sm add_row">
            <i class="fas fa-plus"></i>
            اضافة لون
          </button>     --}}
            {{-- <table id="empTable_color" class="table table-boreder"> --}}
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
                                @else
                                    @if($color->get_color_code->id == 1)
                                        <option value="{{$color->id}}">{{$color->invcolor_category->name}}</option>
                                    @else
                                        <option value="{{$color->id}}">{{$color->get_color_code->name.' ('.$color->invcolor_category->name.')'}}</option>
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
                {{-- @if(isset($table_color_body))
                @foreach($table_color_body as $rows)
                    <tr>
                        <td>
                            <select name="color_id[]" class="form-control searchable">
                                @foreach($colors as $color)
                                    @if($color->id == $rows->get_color->id && $color->get_color_code->id == 1)
                                
                                    <option value="{{$color->id}}" selected>{{' ('.$color->invcolor_category->name.')'}}</option>

                                    @elseif($color->id == $rows->get_color->id && $color->get_color_code->id != 1)

                                    <option value="{{$color->id}}" selected>{{$color->get_color_code->name.' ('.$color->invcolor_category->name.')'}}</option>
                                    @elseif($color->get_color_code->id == 1)
                                    <option value="{{$color->id}}">{{' ('.$color->invcolor_category->name.')'}}</option>
                                    @else
                                    <option value="{{$color->id}}">{{$color->get_color_code->name.' ('.$color->invcolor_category->name.')'}}</option>

                                    @endif
                                @endforeach
                                
                            </select>
                        </td>
                       <td>

                        <input type="file" multiple class="form-control img" id="img_{{$rows->get_color->id}}" name="img_{{$rows->get_color->id}}[]">
                        @foreach($rows->images as $image)
                        <input type="hidden" multiple class="form-control imgs" id="imgs_{{$rows->get_color->id}}" name="imgs_{{$rows->get_color->id}}[]" value="{{$image->img}}">
                        @endforeach
                        <span class="text-danger errorSpan" id="errorSpan"></span>
                        </td>
                        <td>
                            <div class="preview" style="display: flex;">
                                @foreach($rows->images as $image)
                                    <img src="{{ asset('uploads/products/' . $image->img) }}" alt="Image" style="height:100px;">
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button onclick="removeRow_color(this)" class="btn btn-link btn-danger btn-just-icon"><i class="fa fa-trash"></i></button>
                     </td>
                    </tr> 
                @endforeach
            @endif --}}
            </table>
            <span id="validationMessage_color" style="color: red;"></span>
{{-- </div> --}}

          
</div>




<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>


<script>

   $(document).ready(function() {
    $(document).on('change', '.color_id', function() {
            var color_id = $(this).val();
            this.parentNode.parentNode.children[1].children[0].setAttribute('name','img_'+color_id+'[]')
    })

   });

    document.addEventListener("DOMContentLoaded", function() {
        $("#category_id").select2();
    });
</script>

<script src="{{ asset('js/fields_config.js') }}"></script>



<script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            if ($(this).val() == '3') {
                $('.container_hid').hide();
                $('.container_hid_siz').show();
            } else {
                $('.container_hid').show();
                $('.container_hid_siz').hide();
            }

        });
    });
</script>