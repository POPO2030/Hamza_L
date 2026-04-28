
<html dir="rtl">
<head>

<title> طباعة اذن التسليم</title>

<style>
    @page{
        size:79mm auto;
        margin:2mm;
    }
    
    body{
        direction:rtl;
        font-family:Tahoma, Arial, sans-serif;
        width:75mm;
        margin:auto;
        color:#000;
        font-size:14px;
        zoom: 90%!important;
    }
    
    .btn{
        background:#17a2b8;
        color:#fff;
        padding:6px 12px;
        border-radius:6px;
        text-decoration:none;
        font-size:14px;
        display:inline-block;
        margin-bottom:8px;
    }
    
    .btn:hover{
        background:#055561;
    }
    
    table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:6px;
    }
    
    th,td{
        padding:4px;
        text-align:center;
        vertical-align:middle;
    }
    
    .main-table th,
    .main-table td{
        border:1px solid #000;
    }
    
    .main-table th{
        background:#f2f2f2;
        font-weight:bold;
        font-size:13px;
    }
    
    .header-table td{
        border:none;
        font-weight:bold;
        font-size:14px;
    }
    
    .total-box td{
        border:1px solid #000;
        font-weight:bold;
        font-size:15px;
        background:#fafafa;
    }
    
    .notes-box,
    .footer-box{
        margin-top:6px;
        font-size:14px;
        line-height:1.6;
    }
    
    .title{
        text-align:center;
        font-size:18px;
        font-weight:bold;
        margin-bottom:5px;
        border-bottom:1px dashed #000;
        padding-bottom:4px;
    }
    
    .separator{
        border-top:1px dashed #000;
        margin:5px 0;
    }
    
    @media print{
    
        #print-deliverOrder{
            display:none;
        }
    
        body{
            width:75mm;
            margin:0 auto;
        }
    }
    </style>
        
</head>
<body>
	<div class="col-sm-12 d-flex justify-content-end" style="text-align: end;">
        <a class="btn btn-secondary" style="width: 50px; text-align:center; margin:5px; border-radius: 8px; padding:5px; border: 1px solid #ccc;"
           href="{{ route('final_deliver_orders') }}" id="print-deliverOrder">
            رجوع
        </a>
    </div>
 
    <div class="title">اذن التسليم</div>
{{-- <table  style="border-collapse: collapse;"> --}}
    <table class="header-table">
    <tr  style="border: none;">
    <td colspan="7" style="border: none;"><span>{{ $deliverOrder[0]->created_at }}</span></td>
    </tr>
    <tr style="border: none;">
        <td  style="border: none;"> </td>
        <td colspan="3" style="border: none;">  <span >{{ $deliverOrder[0]->get_deliver_order->get_customer->name }}</span></td>
        <td  colspan="3" style="border: none;">  <span>{{ $deliverOrder[0]->final_deliver_order_id }}</span></td>
    </tr>
    <tr >
       
                    {{-- <td style="border: 1px solid black;">اذن استلام</td> --}}
                    <td style="border: 1px solid black;"> امر شغل </td>
                    <td style="border: 1px solid black;"> موديل </td>
                    {{-- <td style="border: 1px solid black;"> المنتج</td> --}}
                    <td style="border: 1px solid black;"> عدد الاكياس</td>
                    <td style="border: 1px solid black;"> العدد</td>
                    <td style="border: 1px solid black;"> الاجمالى</td>
               
        
    </tr>

    @php $grandtotal=0 @endphp
    @php $packagetotal=0 @endphp
    @foreach($deliverOrder as $data)
   
        <tr>
            {{-- <td style="border: 1px solid black;">{{ $data->get_deliver_order->receipt_id }} </td> --}}
            <td style="border: 1px solid black;"> {{ $data->get_deliver_order->work_order_id }}  </td>
            <td style="border: 1px solid black;"> {{ $data->get_deliver_order->get_receive_receipt->model }}  </td>
            {{-- <td style="border: 1px solid black;"> {{ $data->get_deliver_order->get_products->name }}   </td> --}}
           
            <td style="border: 1px solid black;">{{$data->package_number}}</td>
            <td style="border: 1px solid black;">{{$data->count}}</td>
            <td style="border: 1px solid black;">{{$data->total}}</td>
            
        </tr>
        @php  $grandtotal+=$data->total @endphp
        @php  $packagetotal+=$data->package_number @endphp
    @endforeach

</table>

<table  cellspacing="1" id="table1" style="border-collapse: collapse;">
    <tr>
		
		<td style="border: 1px solid black;"><span lang="ar-eg">عدد الاكياس: {{$packagetotal}}</span></td>
        <td style="border: 1px solid black;"><span lang="ar-eg"> الاجمالى: {{$grandtotal}} </span></td>
    
    </tr>

</table> 
<table  style="border-collapse: collapse;">

    @if ($deliverOrder[0]->notes != Null)
    <tr style="border: none;">
        <td colspan="12" style="border: none;">
                <p>{!! Form::label('notes', 'ملحوظة:') !!} {{ $deliverOrder[0]->notes }}</p>
        </td>
    </tr>
    @endif

    <tr style="border: none;">
        
                    <td style="border: none;">
                        @if ($deliverOrder[0]->receivable_id != Null)
                        <p>{!! Form::label('receive_id', 'جهة التسليم:') !!} {{ $deliverOrder[0]->get_receivable_name->name }}</p>
                        @else
                        <p>{!! Form::label('receive_id', 'جهة التسليم:') !!} {{ $deliverOrder[0]->get_deliver_order->get_receivable->name }}</p>
                        @endif
                    </td>
                    {{-- <td style="border: none;">   <p>{!! Form::label('Signature', 'التوقيع:') !!} .................................</p></td> --}}
               
        
    </tr>
</table>



<script>
     window.onload = function() {
      window.print();
    };
  </script>

</body>

</html>


