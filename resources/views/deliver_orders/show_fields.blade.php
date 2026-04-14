{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<style>@page { size: A5 }</style> --}}
{{-- <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
</style> --}}


<style>
    @page { size: A5 landscape;}
    @media print {
        .header-container.container-fluid,.footer, .row.mb-2 {
          display: none;
        }
    }
    </style>
    
<!-- Receipt Id Field -->
<div class="col-sm-12" style="padding: 1rem; text-align: center; font-size: 18px;">
    <p>{!! Form::label('receipt_id', 'اذن تغليف رقم:') !!} {{ $deliverOrder->id }}</p>
</div>
<div class="col-sm-3">
    
    <p>{!! Form::label('receipt_id', 'اذن اضافة:') !!} {{ $deliverOrder->receipt_id }}</p>
</div>

<!-- Work Order Id Field -->
<div class="col-sm-3">
    
    <p>{!! Form::label('work_order_id', 'الغسلة:') !!} {{ $deliverOrder->work_order_id }}  </p>
</div>

<!-- Product Id Field -->
<div class="col-sm-3">
    
    <p>{!! Form::label('product_id', 'المنتج:') !!} {{ $deliverOrder->get_products->name }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-3">
    
    <p>{!! Form::label('customer_id', 'العميل:') !!} {{ $deliverOrder->get_customer->name }}</p>
</div>



<!-- Created At Field -->
<div class="col-sm-3">
    
    <p>{!! Form::label('created_at', 'التاريخ:') !!} : {{ $deliverOrder->created_at }}</p>
</div>

<table class="table table-border">
    <tr>
        <th>عدد الاكياس</th>
        <th>العدد</th>
        <th>الاجمالى</th>
    </tr>
    @php $grandtotal=0 @endphp
    @foreach($deliverOrder->get_details as $row)
        <tr>
            <td>{{$row->package_number}}</td>
            <td>{{$row->count}}</td>
            <td>{{$row->total}}</td>
            
        </tr>
        @php  $grandtotal+=$row->total @endphp
    @endforeach
</table>

<div class="col-sm-10">
    الاجمالى : {{$grandtotal}}
    <p></p>
    </div>

 
<!-- Receive Id Field -->
<div class="col-sm-6">
    
    <p>{!! Form::label('receive_id', 'جهة التسليم:') !!} {{ $deliverOrder->get_receivable->name }}</p>
</div>

<!-- Signature Field -->
<div class="col-sm-6">
    
    <p>{!! Form::label('Signature', 'التوقيع:') !!} .................................</p>
</div>
