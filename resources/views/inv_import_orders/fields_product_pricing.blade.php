<div class="col-sm-12 printable p-10 text-center" >
    اذن اضافة بضاعه
    </div>
<!-- Serial Field -->
<div class="col-sm-6">
    {!! Form::label('serial', 'الرقم التسلسلى:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->id }}</span>
</div>

<!-- Date In Field -->
<div class="col-sm-6">
    {!! Form::label('date_in', 'تاريخ الاستلام:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;"> {{ date('Y-m-d', strtotime($invImportOrder->date_in)) }}</span>
</div>

  
  
 <!-- Supplier Id Field -->
<div class="col-sm-6">
  {{-- {!! Form::label('supplier_id', 'المورد:') !!} --}}
  {!! Form::label('supplier_id', 'المورد: <span style="color: red">*</span>', [], false) !!}
  {{-- <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_supplier->name }}</span> --}}
  <div id="supplier_id-container">
    {{ Form::select('supplier_id',$suppliers,null,['placeholder' => 'اختر  المورد','class'=> 'form-control searchable ','id'=>'supplier_id', 'data-placeholder'=>"اختر المورد", 'style'=>"width: 100%"],['option'=>'suppliers']) }}
  </div>  
  @error('supplier_id')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    <span id="supplier_id-error" class="error-message" style="color: red"></span>
</div>

<!-- User Id Field -->
<div class="col-sm-6">
    {!! Form::label('user_id', 'مضاف بواسطة:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_user->name }}</span>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->created_at }}</span>
</div>
@if(!empty($invImportOrder->get_user_update->name))
<!-- Updated By Field -->
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    @if(!empty($invImportOrder->get_user_update->name))
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_user_update->name }}</span>
    @endif
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التحديث:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->updated_at }}</span>
</div>
@endif
<!-- Comment Field -->
@if(!empty($invImportOrder->comment))
<div class="col-sm-12">
    {!! Form::label('comment', 'الملاحظات:') !!}
    <span class="border border-lightgray  rounded text-white p-3 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->comment }}</span>
</div>
@endif
<div class="col-sm-6">
    {!! Form::label('original_invoice_img', 'صوره الفاتورة الاصل:') !!}
    {{-- <input type="file" name="original_invoice_img"> --}}
    {!! Form::file('original_invoice_img', ['multiple' => true, 'class' => 'form-control', 'id' => 'img', 'data-browse' => 'اختر الصورة']) !!}
    <div class="preview">
        @if (isset($invImportOrder->original_invoice_img))
            <div class="row">
                <div class="col-sm-6"> 
                    <img class="img-thumbnail" src="{{ asset('uploads/original_invoice_img/'.$invImportOrder->original_invoice_img) }}" alt="preview" > 
                    <a href="{{ asset('uploads/original_invoice_img/'.$invImportOrder->original_invoice_img) }}" class="btn btn-secondary btn-sm" target="_blank">
                        {{ $invImportOrder->original_invoice_img }}
                    </a>
                </div>
            </div>
        @endif
    </div>
    @error('img')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="errorSpan" class="error" style="color: red;font-weight:bold"></span>
</div>


<table class="table table-border" style="margin-top: 10px;">
    <tr style="background-color: #e0e4e7 !important;">
        <th calss="text-center">المنتج</th>
        <th calss="text-center">الوحدة</th>
        <th calss="text-center">العدد</th>
        <th calss="text-center">سعر الوحدة</th>
        <th calss="text-center">المخزن</th>
    </tr>
    @foreach($table_body as $row)
    <tr>
       
        <td calss="text-center" dir="rtl">
          
            {{$row->product_color->get_product->name}}
        </td>

        <td calss="text-center">{{$row->get_unit->name}}</td>
        <td calss="text-center">{{$row->quantity}}</td>
        <td calss="text-center">

            {!! Form::text('product_price[]', $row->product_price, ['class' => 'form-control text-center product_price']) !!}
            @error('product_price')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <span id="product_price-error" class="error-message" style="color: red"></span>
            
            <input type="hidden" name="product_id[]" value="{{ $row->product_id }}">
        </td>

        <td calss="text-center">{{$row->get_store->name}}</td>
    </tr>
    @endforeach
</table>


