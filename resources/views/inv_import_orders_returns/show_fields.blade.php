
<!-- Serial Field -->
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    {{-- <p>{{ $invImportOrder_return->id }}</p> --}}
    <input type="text" class="form-control text-center" value="{{ $invImportOrder_return->id }}" readonly>
    @else
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    {{-- <p>{{ $invImportOrder->id }}</p> --}}
    <input type="text" class="form-control text-center" value="{{ $invImportOrder->id }}" readonly>
    <input type="hidden" name="ImportOrder_id" value="{{$invImportOrder->id}}">
    @endif
</div>

<!-- Date In Field -->
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('date_in', 'تاريخ المرتجع:') !!}
    {{-- <p>{{ $invImportOrder_return->date_out }}</p> --}}
    <input type="text" class="form-control text-center" value="{{ $invImportOrder_return->date_out }}" readonly>
    @else
    {!! Form::label('date_in', 'تاريخ الاستلام:') !!}
    {{-- <p>{{ $invImportOrder->date_in }}</p> --}}
    <input type="text" class="form-control text-center" value="{{ $invImportOrder->date_in }}" readonly>
    @endif
</div>


<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('product_category_id', 'مجموعه المنتجات:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder_return->invproduct_category->name }}" readonly>
    @else
    {!! Form::label('product_category_id', 'مجموعه المنتجات:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder->invproduct_category->name }}" readonly>
    @endif
</div>
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder_return->get_supplier->name }}" readonly>
    @else
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder->get_supplier->name }}" readonly>
    @endif
</div>

<!-- User Id Field -->
<div class="col-sm-6">
    @if(isset($invImportOrder_return))
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder_return->get_user->name }}" readonly>
    @else
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder->get_user->name }}" readonly>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-6">
       @if(isset($invImportOrder_return))
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <input type="text" class="form-control text-center" value="{{  $invImportOrder_return->created_at }}" readonly>
    @else
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <input type="text" class="form-control text-center" value="{{   $invImportOrder->created_at }}" readonly>
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
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder->get_user_update->name }}</span>
</div>
@endif
@endif

@if(isset($invImportOrder_return))
@if(!empty($invImportOrder_return->get_user_update->name))
<!-- Updated At Field -->
 <div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->updated_at }}</span>
</div>
@endif
@endif

@if(isset($invImportOrder_return) && $invImportOrder_return->comment != null)
<!-- Comment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comment', 'الملاحظات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->comment }}</span>
</div>
@endif

<table class="table table-border" style="margin: 10px;">
    <tr style="background-color: #e0e4e7 !important;">
        <th class="col-3 text-center">المنتج</th>
        <th class="text-center">الوحدة</th>
        <th class="text-center">العدد</th>
        <th class="text-center">المخزن</th>
        <th class="col-2 text-center">كميه المرتجع</th>
        @if(isset($invImportOrder_return))
       
        @else
        <th class="col-2 text-center">كميه المرتجع</th>
        @endif
    </tr>
    @foreach($table_body as $row)
    @if(isset($invImportOrder_return))
    <tr>
        <td class="text-center">
            
{{
    optional($row->product_color)->get_product
        ? $row->product_color->get_product->name.' ('.

        (optional($row->product_color->get_product)->get_product_description ? $row->product_color->get_product->get_product_description->name : '').' - '.



            optional($row->product_color->get_color)->invcolor_category->name.'  '.
            optional($row->product_color->get_color)->get_color_code_name.
            ')'.optional($row->product_color->get_product->get_size)->name.
            ' '.optional($row->product_color->get_product->get_weight)->name
        : ''
}}
</td>
        <td class="text-center">{{$row->get_unit->name}}</td>
        <td class="text-center">
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
        <td class="text-center">{{$row->get_store->name}}</td>
        <td class="text-center">{{$row->quantity}}</td>
    </tr>
    @endif
    
    @endforeach
</table>