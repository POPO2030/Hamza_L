{{-- @extends('layouts.app')

@section('title')
    {{__('طباعة الباركود')}}
@endsection --}}
<html dir="rtl">
<head>

<title> طباعة الباركود</title>
<style>
  @page {
        width: 80mm;
        height: 90mm;
        text-align: center;
        align-content: center;
        /* size: 79mm ; */
        margin: 0;
    }

/* .btn {
    transition-duration: 0.4s;
    position: relative;
    background-color: #17a2b8;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    color: #FFFFFF;
    padding: 20px;
    width: 20px;
    text-align: center;
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
} */

  .btn:hover {
  background-color: #055561; 
  color: white;
  }

table {
    /* width: 1050px; */
    border-collapse: collapse;
    margin:  auto;
/* font-size: 22px; */
}
td {
    padding: 0.5rem;
    text-align: center;
    font-size: 22px;
}

#table1, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      font-size:22px;
      font-weight:bolder;
    }


@media print {
#print-deliverOrders ,.header, .footer, .mb-2,.header-container{
display: none;
}
}

    </style>

<link rel="stylesheet" type="text/css" href="{{ asset('cssNEW/bootstrap.min.css') }}">
<script src="{{ asset('cssNEW/bootstrap.bundle.min.js') }}" ></script>
</head>
<body>
{{-- @section('content') --}}

<div class="col-sm-12">
  <a class="btn btn-primary" style="float: left; border: 1px; 
  width: 50px;text-align:center;margin:30px;border-radius: 8px;padding:5px"
     href="{{ route('deliverOrders.index') }}" id="print-deliverOrders">
     رجوع
  </a>
</div>


@foreach($deliver_order_details as $row)
  @for($i=0 ; $i<$row->package_number ; $i++)
    {{-- First div --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center; height: 140px; margin-bottom: 20px;">
      <h1 style="font-size: 60px;">{{$workOrder[0]->get_customer->name}}</h1>
    </div>
    {{-- Table --}}
    <table id="table_{{ $row->id }}"  id="table1" style="border-collapse: collapse; ">
      <tr>
        <td style="border: 1px solid black; width: 50%;"><span lang="ar-eg"> الغسلة: </span> {{$workOrder[0]->work_order_id}}</td>
        <td style="border: 1px solid black; width: 50%;">
          <span lang="ar-eg"> رقم الموديل: 
          @if (isset($workOrder[0]->get_work_order->get_ReceiveReceipt->model))
              {{$workOrder[0]->get_work_order->get_ReceiveReceipt->model}}
            </span>
          @endif
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid black;"><span lang="ar-eg"> عدد القطع: </span> {{$row->count}}</td>
        <td style="border: 1px solid black;"><span lang="ar-eg">جهة التسليم: {{$workOrder[0]->get_receivable->name}}</span></td>
      </tr>
    </table> 
    <br>
    {{-- Barcode --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center;height:45px; margin-bottom: 20px;">
      {!! DNS1D::getBarcodeHTML("$row->barcode", 'EAN13',2,50) !!}
    </div>
    {{-- Barcode text --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center; font-size: 22px; margin-bottom: 20px;">
      <span lang="ar-eg">{{$row->barcode}}</span>
    </div>

    <div style="text-align: center; clear: both;">

      <p style="page-break-before: always;"></p>
    </div>

{{-- --------------------------------------------- بداية تكرار الكود للطباعة مرتين ----------------------------------------------------------------------------------------------------- --}}
    {{-- First div --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center; height: 140px; margin-bottom: 20px;">
      <h1 style="font-size: 60px;">{{$workOrder[0]->get_customer->name}}</h1>
    </div>
    {{-- Table --}}
    <table id="table_{{ $row->id }}"  id="table1" style="border-collapse: collapse; ">
      <tr>
        <td style="border: 1px solid black; width: 50%;"><span lang="ar-eg"> الغسلة: </span> {{$workOrder[0]->work_order_id}}</td>
        <td style="border: 1px solid black; width: 50%;">
          <span lang="ar-eg"> رقم الموديل: 
          @if (isset($workOrder[0]->get_work_order->get_ReceiveReceipt->model))
              {{$workOrder[0]->get_work_order->get_ReceiveReceipt->model}}
            </span>
          @endif
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid black;"><span lang="ar-eg"> عدد القطع: </span> {{$row->count}}</td>
        <td style="border: 1px solid black;"><span lang="ar-eg">جهة التسليم: {{$workOrder[0]->get_receivable->name}}</span></td>
      </tr>
    </table> 
    <br>
    {{-- Barcode --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center;height:45px; margin-bottom: 20px;">
      {!! DNS1D::getBarcodeHTML("$row->barcode", 'EAN13',2,50) !!}
    </div>
    {{-- Barcode text --}}
    <div style="display: flex; justify-content: center; align-items: center; text-align: center; font-size: 22px; margin-bottom: 20px;">
      <span lang="ar-eg">{{$row->barcode}}</span>
    </div>

    <div style="text-align: center; clear: both;">

      <p style="page-break-before: always;"></p>
    </div>
{{-- ------------------------------------------------------------------ نهاية تكرار الكود للطباعة مرتين  ------------------------------------------------------------------------------------------------ --}}
    
  @endfor
@endforeach



<script>
  window.onload = function() {
  window.print();
  };
</script>
 
 </body>
 
 </html>