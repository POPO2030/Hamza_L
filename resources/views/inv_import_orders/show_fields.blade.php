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

  
  
 <!-- Customer Id Field -->
 <div class="col-sm-6">
  {!! Form::label('spend_to', 'المورد:') !!}
  <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $invImportOrder->get_supplier->name }}</span>
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


@can("product_price.edit_final_product_price")
<div class="preview">
    @if (isset($invImportOrder->original_invoice_img))
        <div class="row">
            <div class="col-sm-6"> 
                <img class="img-thumbnail" src="{{ asset('uploads/original_invoice_img/'.$invImportOrder->original_invoice_img) }}" alt="preview" > 
            </div>
        </div>
    @endif
</div>
@endcan



<table class="table table-border" style="margin-top: 10px;">
    <tr style="background-color: #e0e4e7 !important;">
        <th calss="text-center">المنتج</th>
        <th calss="text-center">الوحدة</th>
        <th calss="text-center">العدد</th>
        <th calss="text-center">المخزن</th>
    </tr>
    @foreach($table_body as $row)
    <tr>
       
        <td calss="text-center">{{$row['product_name']}}</td>
        <td calss="text-center">{{$row['unit_name']}}</td>
        <td calss="text-center">{{$row['quantity']}}</td>
        <td calss="text-center">{{$row['store_name']}}</td>
    </tr>
    @endforeach
</table>



@if ($invImportOrder->status == 'pending')
    @can('insert_into_stores')
        <div class="col-sm-12" style="text-align: center;">
            {!! Form::open(['route' => ['insert_into_stores'], 'method' => 'post','id'=>'create']) !!}
                <input type="hidden" name="id" value="{{ $invImportOrder->id }}">
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