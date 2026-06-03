<!-- Print Title -->
<div class="col-sm-12 printable p-10 text-center">
    تفاصيل اذن مرتجع بضاعة
</div>
<!-- Serial Field -->
<div class="col-sm-2">
    @if(isset($invImportOrder_return))
    {!! Form::label('serial', 'م:') !!}
     <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->id }}</span>
    @endif
</div>
<!-- Serial Field -->
<div class="col-sm-2">
    @if(isset($invImportOrder_return))
    {!! Form::label('invImportOrder_id', 'اذن الاستلام:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->invimport_id }}</span>
    @endif
</div>

<!-- Date In Field -->
<div class="col-sm-2">
    @if(isset($invImportOrder_return))
    {!! Form::label('date_in', 'تاريخ المرتجع:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->date_out->format('Y-m-d') }}</span>
    @else
    {!! Form::label('date_in', 'تاريخ الاستلام:') !!}
     <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder->date_in->format('Y-m-d')}}</span>
    @endif
</div>

<div class="col-sm-2">
    @if(isset($invImportOrder_return))
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invImportOrder_return->get_supplier->name }}</span>
    @else
    {!! Form::label('supplier_name', 'اسم المورد:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invImportOrder->get_supplier->name }}</span>
    @endif
</div>

@if(isset($invImportOrder_return) && $invImportOrder_return->comment != null)
<!-- Comment Field -->
<div class="form-group col-sm-2">
    {!! Form::label('comment', 'الملاحظات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->comment }}</span>
</div>
@endif

<table class="table table-border" style="margin: 10px;">
    <tr style="background-color: #e0e4e7 !important;">
        <th class="col-3 text-center">المنتج</th>
        <th class="text-center">الوحدة</th>
        <th class="text-center">العدد</th>
        <th class="text-center">المتاح</th>
        <th class="text-center">المخزن</th>
        <th class="col-2 text-center">كميه المرتجع</th>
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
                            ' '.optional($row->product_color->get_product->get_weight)->name : ''
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
        <td class="text-center">
            @if (isset($import_order_return_details))
                @foreach ($import_order_return_details as $detail)
                    @if ($detail['product_id'] == $row->product_id)
                        {{ $total - $detail['quantity'] + $row->quantity }}
                    @endif
                @endforeach
            @endif
        </td>
        <td class="text-center">{{$row->get_store->name}}</td>
        <td class="text-center">{{$row->quantity}}</td>
    </tr>
    @endif
    
    @endforeach
</table>

<!-- User Id Field -->
<div class="col-sm-2 no-print">
    @if(isset($invImportOrder_return))
    {!! Form::label('user_id', 'انشائها:') !!}
     <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invImportOrder_return->get_user->name }}</span>
    @else
    {!! Form::label('user_id', 'انشائها:') !!}
     <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invImportOrder->get_user->name }}</span>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-2 no-print">
       @if(isset($invImportOrder_return))
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $invImportOrder_return->created_at }}</span>
    @else
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{   $invImportOrder->created_at }}</span>
    @endif
</div>

@if(isset($invImportOrder_return))
@if(!empty($invImportOrder_return->get_user_update->name))
<!-- Updated By Field -->
<div class="col-sm-2 no-print">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder_return->get_user_update->name }}</span>
</div>
@endif
@else
@if(!empty($invImportOrder->get_user_update->name))
<div class="col-sm-2 no-print">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder->get_user_update->name }}</span>
</div>
@endif
@endif

@if(isset($invImportOrder_return))
@if(!empty($invImportOrder_return->get_user_update->name))
<!-- Updated At Field -->
 <div class="col-sm-2 no-print">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$invImportOrder_return->updated_at }}</span>
</div>
@endif
@endif