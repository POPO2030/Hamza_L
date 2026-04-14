@extends('layouts.app')
@section('title')
    {{__('طباعة اذن التسليم')}}
@endsection

<style>
     @page {
            size: A4 ;
            /* margin-right: 3rem; */
        }
@media print {
    .header-container.container-fluid,.footer, .row.mb-2{
      display: none;
    }
}
</style>




@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
               
                <div class="col-sm-12">
                    <a class="btn btn-default float-left"
                       href="{{ route('final_deliver_orders') }}">
                        عودة
                    </a>
                   
                    <button  class="btn btn-primary float-left" onclick="window.print()" style="margin-left: 10px;">  طباعه </button> 
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card" style="height: 46% ;">
            <div class="card-body" style="font-size: 18px">
                <div class="row">
                    
<div class="col-sm-4" style=" text-align: center;">
    <p>{!! Form::label('final_deliver_order_id', 'اذن تسليم رقم:') !!} {{ $deliverOrder[0]->final_deliver_order_id }}</p>
</div>
 
<div class="col-sm-4" style=" text-align: center;">
    <p>{!! Form::label('customer_id', 'العميل:') !!} {{ $deliverOrder[0]->get_deliver_order->get_customer->name }}</p>
</div>

<div class="col-sm-4" style=" text-align: center;">
    <p>{!! Form::label('created_at', 'التاريخ:') !!} {{ $deliverOrder[0]->created_at }}</p>
</div>

{{-- @foreach ($deliverOrder as $deliverOrders) --}}
<table class="table table-border print-table" >
    <tr>
        <th> اذن اضافة</th>
        <th> الغسلة</th>
        <th> موديل</th>
        <th>المنتج</th>
        <th>عدد الاكياس</th>
        <th>العدد</th>
        <th>الاجمالى</th>
    </tr>


    @php $grandtotal=0 @endphp
    @php $packagetotal=0 @endphp
    @foreach($deliverOrder as $data)
   
        <tr>
            <td>{{ $data->get_deliver_order->receipt_id }} </td>
            <td> {{ $data->get_deliver_order->work_order_id }}  </td>
            <td> {{ $data->get_deliver_order->get_receive_receipt->model }}  </td>
            <td> {{ $data->get_deliver_order->get_products->name }}   </td>
           
            <td>{{$data->package_number}}</td>
            <td>{{$data->count}}</td>
            <td>{{$data->total}}</td>
            
        </tr>
        @php  $grandtotal+=$data->total @endphp
        @php  $packagetotal+=$data->package_number @endphp
    @endforeach

</table>

    <div class="col-sm-3" style="margin-right: 45%">
          عدد الاكياس : <span class="badge badge-secondary">{{$packagetotal}}</span>  
        </div>
    <div class="col-sm-3" style="margin-right: 4%;">
         الاجمالى :   <span class="badge badge-secondary">{{$grandtotal}}</span>
        </div>
        @if ($deliverOrder[0]->notes != Null)
        <div class="form-group col-sm-12">
            <p>{!! Form::label('notes', 'ملحوظة:') !!} {{ $deliverOrder[0]->notes }}</p>
        </div>
        @else
        <div class="form-group col-sm-12"></div>
        @endif
        
       

<div class="col-sm-6">
    @if ($deliverOrder[0]->receivable_id != Null)
    <p>{!! Form::label('receive_id', 'جهة التسليم:') !!} {{ $deliverOrder[0]->get_receivable_name->name }}</p>
    @else
    <p>{!! Form::label('receive_id', 'جهة التسليم:') !!} {{ $deliverOrder[0]->get_deliver_order->get_receivable->name }}</p>
    @endif
</div>
    
<div class="col-sm-6">
    <p>{!! Form::label('Signature', 'التوقيع:') !!} .................................</p>
</div>
{{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>


    <script>
        window.onload = function () {
            var card = document.querySelector('.card'); // Get the first card element
            var clonedCard = card.cloneNode(true); // Clone the card
            card.parentNode.insertBefore(clonedCard, card.nextSibling); // Insert the cloned card after the original card
            window.print();
        };
    </script>
    
   
@endsection


