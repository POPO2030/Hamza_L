<!-- Serial Field -->
<div class="col-sm-3">
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->id }}</span>
</div>

<!-- Store Out Field -->
<div class="col-sm-3">
    {!! Form::label('store_out', 'من:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->get_store_out->name }}</span>
</div>

<!-- Store In Field -->
<div class="col-sm-3">
    {!! Form::label('store_in', 'الى:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->get_store_in->name }}</span>
</div>

<!-- Comment Field -->
@if(!empty($invStockTransfer->comment))
 <div class="col-sm-3">
    {!! Form::label('comment', 'الملاحظات:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->comment }}</span>
 </div>
@endif
<!-- User Id Field -->
@if(isset($invStockTransfer->get_user->name))
<div class="col-sm-3">
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->get_user->name }}</span>
</div>
@endif


<!-- Created At Field -->
@if(isset($invStockTransfer->created_at))
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->created_at }}</span>
</div>
@endif
<!-- Updated By Field -->
@if(!empty($invStockTransfer->get_user_update->name))
 <div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->get_user_update->name }}</span>
 </div>
@endif
<!-- Updated At Field -->
@if(isset($invStockTransfer->updated_at))
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invStockTransfer->updated_at }}</span>
</div>
@endif

<table class="table table-border">
    <tr>
        <th class="text-center">المنتج</th>
        <th class="text-center">الوحدة</th>
        <th class="text-center">المورد</th>
        <th class="text-center">العدد</th>
    </tr>
    @foreach($table_body as $row)
    <tr>
        <td class="text-center" >
            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">
                {{$row->get_product_color->get_product->invproduct_category->name}}-{{$row->get_product_color->get_product->manual_code}}-{{$row->get_product_color->get_product->name}}
            </span>
        </td>
           
        <td>
            @foreach($row->get_product_color->get_product->get_units as $row_unit)
             @if($row_unit->id == $row->unit_id)
              <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $row_unit->name  }}</span>
             @endif
            @endforeach
        </td>
        <td>
            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{$row->get_supplier->name}}</span>
        </td>
        <td>
            @php
            $unitContent = $row['get_product_color']['get_product']['get_units'][0]['pivot']['unitcontent'] ?? 1;
            $quantityOut = $row['quantity'] / $unitContent;
        @endphp
         <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{  $quantityOut }}</span>
        </td>
    </tr>
    @endforeach
</table>

@if ($invStockTransfer->status == 'pending')
    @can('invStockTransfers.confirm_transfer')
        <div class="col-sm-12" style="text-align: center;">
            {!! Form::open(['route' => ['invStockTransfers.confirm_transfer'], 'method' => 'post','id'=>'create']) !!}
                <input type="hidden" name="id" value="{{ $invStockTransfer->id }}">
                {!! Form::button('<i class="fas fa-thumbs-up"></i> موافق', [
                'type' => 'submit',
                'class' => 'btn btn-primary col-2',
                'id' => 'submit-button'
                ]) !!}
                
            {!! Form::close() !!}
        </div>
    @endcan
@endif



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('create').addEventListener('submit', function(event) {
            event.preventDefault();
            var isValid = true;

            if (isValid) {
                var submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;
                this.submit();
            }
        });
    });
</script>
