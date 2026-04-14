   <div class="col-sm-12 printable p-10 text-center" >
    اذن صرف بضاعه
    </div>
<!-- Serial Field -->
<div class="col-sm-6">
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->id }}</span>
</div>

<!-- Serial Field -->
@if(!empty($invExportOrder->manual_id))
<div class="col-sm-6">
    {!! Form::label('manual_id',  'رقم المستند:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->manual_id }}</span>
</div>
@endif

<!-- Date In Field -->
<div class="col-sm-6">
    {!! Form::label('date_out', 'تاريخ الصرف:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ date('Y-m-d', strtotime($invExportOrder->date_out)) }}</span>
</div>

<!-- Category_Id Field -->
<div class="col-sm-6">
    {!! Form::label('work_order_id', 'يصرف الى:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->work_order_id }}</span>
</div>


<!-- User Id Field -->
<div class="col-sm-6">
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->get_user->name }}</span>
</div>

<!-- Created At Field -->
@if(!empty($invExportOrder->created_at))
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->created_at }}</span>
</div>
@endif
<!-- Updated By Field -->
@if(!empty($invExportOrder->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->get_user_update->name }}</span>
   </div>
@endif

<!-- Comment Field -->
@if(!empty($invExportOrder->comment))
<div class="col-sm-12">
    {!! Form::label('comment', 'الملاحظات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invExportOrder->comment }}</span>
</div>
@endif
<div class="col-sm-12">
</div>
<table class="table table-border" style="margin-top: 10px;">
    <tr style="background-color: #e0e4e7 !important;">
        <th class="text-center">المنتج</th>
        <th class="text-center">الوحدة</th>
        <th class="text-center">العدد</th>
        <th class="text-center">المخزن</th>
    </tr>
    @foreach($table_body as $row)
    <tr>

        <td class="text-center">
            {{$row->product_color->get_product->manual_code}}- 
            {{$row->product_color->get_product->name}}
            {{-- @if($row->product_color->get_color->color_code_id !=1)
             {{ $row->product_color->get_color->invcolor_category->name }} - {{ $row->product_color->get_color->get_color_code->name ?? '' }}
             @else
             {{ $row->product_color->get_color->invcolor_category->name }}
            @endif --}}
            @if($row->product_color->get_color->colorCategory_id !=1 && $row->product_color->get_color->color_code_id !=1)
             ({{ $row->product_color->get_color->invcolor_category->name }} - {{ $row->product_color->get_color->get_color_code->name }} )
            @elseif($row->product_color->get_color->colorCategory_id !=1 && $row->product_color->get_color->color_code_id ==1)
             ({{ $row->product_color->get_color->invcolor_category->name }})
             @elseif($row->product_color->get_color->colorCategory_id ==1 && $row->product_color->get_color->color_code_id !=1)
             ({{ $row->product_color->get_color->get_color_code->name }} )
            @endif

        </td>
        {{-- @endif --}}
        <td class="text-center">{{$row->get_unit->name}}</td>
        <td class="text-center">{{$row->quantity}}</td>
        <td class="text-center">{{$row->get_store->name}}</td>
    </tr>
    @endforeach
</table>