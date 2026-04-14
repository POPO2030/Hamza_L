
<!-- Serial Field -->
@if(isset($invImportOrder_return))
<div class="form-group col-sm-6">
    {!! Form::label('import_order_id', 'رقم اذن اضافة:') !!}
    {{-- <p>{{ $invImportOrder_return->invimport_id }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->invimport_id }}</span>
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('import_order_id', 'رقم اذن اضافة:') !!}
    {{-- <p>{{ $invImportOrder->id }}</p> --}}
    {!! Form::text('invimport_id', $invImportOrder->id, ['class' => 'form-control text-center','readonly']) !!}
</div>
@endif

<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    {{-- <p>{{ $invImportOrder_return->id }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->id }}</span>
    @else
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    {{-- <p>{{ $invImportOrder->id }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->id }}</span>
    <input type="hidden" name="ImportOrderid" value="{{$invImportOrder->id}}">
    @endif
</div>

<!-- Date In Field -->
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('date_in', 'تاريخ المرتجع:') !!}
    {{-- <p>{{ date('Y-m-d', strtotime($invImportOrder_return->date_out)) }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ date('Y-m-d', strtotime($invImportOrder_return->date_out)) }}</span>
    @else
    {!! Form::label('date_in', 'تاريخ الاستلام:') !!}
    {{-- <p>{{ date('Y-m-d', strtotime($invImportOrder->date_in)) }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ date('Y-m-d', strtotime($invImportOrder->date_in)) }}</span>
    @endif
</div>

<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('product_category_id', 'مجموعه المنتجات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->invproduct_category->name }}</span>
    <input type="hidden" name="product_category_id" value="{{$invImportOrder_return->product_category_id}}">
    @else
    {!! Form::label('product_category_id', 'مجموعه المنتجات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->invproduct_category->name }}</span>
    <input type="hidden" name="product_category_id" value="{{$invImportOrder->product_category_id}}">
    @endif
</div>


<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->get_supplier->name  }}</span>
    @else
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_supplier->name }}</span>
    @endif
</div>

<!-- User Id Field -->
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->get_user->name }}</span>
    @else
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_user->name }}</span>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-6">
       @if(isset($invImportOrder_return))
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->created_at }}</span>
    @else
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->created_at }}</span>
    @endif
</div>

@if(isset($invImportOrder_return))
@if(!empty($invImportOrder_return->get_user_update->name))
<!-- Updated By Field -->
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->get_user_update->name }}</span>
</div>
@endif
@else
@if(!empty($invImportOrder->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_user_update->name }}</span>
</div>
@endif
@endif

@if(isset($invImportOrder_return))
@if(!empty($invImportOrder_return->get_user_update->name))
<!-- Updated At Field -->
 <div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->updated_at }}</span>
</div>
@endif
@else
@if(!empty($invImportOrder->get_user_update->name))
<!-- Updated At Field -->
 <div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->updated_at }}</span>
</div>
@endif
@endif

@if(isset($invImportOrder_return))
<!-- Comment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comment', 'الملاحظات:') !!}
    {!! Form::text('comment', null, ['class' => 'form-control']) !!}
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('comment', 'الملاحظات:') !!}
    {!! Form::text('comment', null, ['class' => 'form-control']) !!}
</div>
@endif

<table class="table table-border">
    <tr style="background-color: #e0e4e7 !important;">
        <th class="col-3 text-center">المنتج</th>
        <th class="text-center">الوحدة</th>
        <th class="text-center">العدد</th>
        <th class="text-center">مرتجع سابق</th>
        <th class="text-center">المخزن</th>
        <th class="col-2 text-center">كميه المرتجع</th>

    </tr>
    @foreach($table_body as $row)
    @if(isset($invImportOrder_return))
    <tr>
       
        <td class="text-center">
            
            {{
                optional($row->product_color)->get_product
                    ? $row->product_color->get_product->manual_code.' '.$row->product_color->get_product->system_code.' '.$row->product_color->get_product->name.' '.
                    (optional($row->product_color->get_product)->get_product_description ? $row->product_color->get_product->get_product_description->name : '').'  '.
                        optional($row->product_color->get_color)->invcolor_category->name.'  '.
                        optional($row->product_color->get_color)->get_color_code_name
                    : ''
            }}
            <input type="hidden" value="{{$row->product_id}}" name ="product_id[]">
        </td>
        <td class="text-center">
            {{$row->get_unit->name}}
        </td>
        <td class="text-center total">
            @php
            $total=0;
            for ($i=0; $i <count($inv_importOrder_details) ; $i++) { 
                if ($row->product_id == $inv_importOrder_details[$i]->product_id ){
                    $total += $inv_importOrder_details[$i]->quantity;
                }
            }
        @endphp
        {{ $total }}
          
        </td>

        <td class="text-center return_details">
            @if (isset($import_order_return_details))
                @foreach ($import_order_return_details as $detail )
                    @if ($detail['product_id'] == $row->product_id)
                        {{ $detail['quantity'] - $row->quantity}}
                    @endif
                @endforeach
            @endif
        </td>

        <td class="text-center">{{$row->get_store->name}}</td>
        <td class="col-3 text-center">
            <input type="text"  name="quantity[]" value="{{$row->quantity}}" class="form-control quantity" style="text-align: center">
            <span class="error"></span>   
        </td>
    </tr>
        
    @else
    <tr>
       
        {{-- <td class="text-center">{{$row->product_color->get_product->invproduct_category->name.' '.$row->product_color->get_product->name.' ('.$row->product_color->get_color->invcolor_category->name.' - '.$row->product_color->get_color->name.")".$row->product_color->get_product->get_size->name." ".$row->product_color->get_product->get_weight->name}}</td> --}}
        <td class="text-center">
            {{
                  optional($row->product_color)->get_product
                    ? $row->product_color->get_product->manual_code.' '.$row->product_color->get_product->system_code.' '.$row->product_color->get_product->name.' '.
                    (optional($row->product_color->get_product)->get_product_description ? $row->product_color->get_product->get_product_description->name : '').'  '.
                        optional($row->product_color->get_color)->invcolor_category->name.'  '.
                        optional($row->product_color->get_color)->get_color_code_name
                    : ''
            }}
              <input type="hidden" value="{{$row->product_id}}" name ="product_id[]">
        </td>
        <td class="text-center">
        {{$row->get_unit->name}}
        </td>
        <td class="text-center total">
          
           {{$row->quantity }}
        </td>

        <td class="text-center return_details">
            @if (isset($import_order_return_details))
                @foreach ($import_order_return_details as $detail )
                    @if ($detail['product_id'] == $row->product_id)
                        {{ $detail['quantity']}}
                    @endif
                @endforeach
            @endif
        </td>

        <td class="text-center">{{$row->get_store->name}}</td>
       <td class="text-center">
            <input type="text"  name="quantity[]" class="form-control quantity" style="text-align: center">
            <span class="error"></span>
        </td>
    </tr>
    @endif
    
    @endforeach
</table>