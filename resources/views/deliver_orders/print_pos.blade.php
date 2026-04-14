
<html dir="rtl">
<head>

<title> طباعة اذن التسليم</title>

    <style>
		  @page {
            /* width: 80mm;
            height: 90mm;
            text-align: center;
            align-content: center;
            /* size: 79mm ; */
            
            size: A5 landscape !important;
            margin: 0; 
        }
        /* body {
        zoom: 0.73; 
        } */
		.btn {
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
            }

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
                font-size: 18px;
            }

            #table1, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size:18px;
                font-weight:bolder;
                }
            .font-weight-bold {
                font-weight: bold;
            }
            .fs-4 {
                font-size: 1.5rem;
            }
            #customer-name {
                margin-right: 1rem;
            }
            #date {
                /* margin-right: 200px; */
            }
            .category-name span {
                display: inline-block;
                margin-right: 3px;
                padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid black;
            }

            @media print {
        #print-deliverOrder {
            display: none;
        }
        }

        </style>
        
</head>
<body>
	<div class="col-sm-12">
		<a class="btn btn" style="float: left; border: 1px; 
		 width: 50px;text-align:center;margin:5px;border-radius: 8px;padding:5px"
		   href="{{ route('final_deliver_orders') }}" id="print-deliverOrder">
			رجوع
		</a>
		
	</div>
 

<table  style="border-collapse: collapse;">
    <tr  style="border: none;">
    <td colspan="7" style="border: none;"><span>{{ $deliverOrder[0]->created_at }}</span></td>
    </tr>
    <tr style="border: none;">
        <td  colspan="7" style="border: none;text-align: center" > اذن تسليم رقم: <span>{{ $deliverOrder[0]->final_deliver_order_id }}</span></td>
    </tr>
    <tr style="border: none;">
         <td colspan="7" style="border: none;"> العميل: <span >{{ $deliverOrder[0]->get_deliver_order->get_customer->name }}</span></td>

    </tr>
    <tr >
       
                    <td style="border: 1px solid black;">اذن اضافة</td>
                    <td style="border: 1px solid black;"> الغسلة </td>
                    <td style="border: 1px solid black;"> موديل </td>
                    <td style="border: 1px solid black;"> المنتج</td>
                    <td style="border: 1px solid black;"> عدد الاكياس</td>
                    <td style="border: 1px solid black;"> العدد</td>
                    <td style="border: 1px solid black;"> الوزن</td>
                    <td style="border: 1px solid black;"> الاجمالى</td>
               
        
    </tr>

    @php $grandtotal=0 @endphp
    @php $packagetotal=0 @endphp
    @foreach($deliverOrder as $data)
   
        <tr>
            <td style="border: 1px solid black;">{{ $data->get_deliver_order->receipt_id }} </td>
            <td style="border: 1px solid black;"> {{ $data->get_deliver_order->work_order_id }}  </td>
            <td style="border: 1px solid black;"> {{ $data->get_deliver_order->get_receive_receipt->model }}  </td>
            <td style="border: 1px solid black;"> {{ $data->get_deliver_order->get_products->name }} {{ $data->get_deliver_order->product_type ? ' (' . $data->get_deliver_order->product_type . ')' : '' }}  </td>
           
            <td style="border: 1px solid black;">{{$data->package_number}}</td>
            <td style="border: 1px solid black;">{{$data->count}}</td>
            <td style="border: 1px solid black;">{{$data->weight}}</td>
            <td style="border: 1px solid black;">{{$data->total}}</td>
            
        </tr>
        @php  $grandtotal+=$data->total @endphp
        @php  $packagetotal+=$data->package_number @endphp
    @endforeach

{{-- </table> --}}

{{-- <table  cellspacing="1" id="table1" style="border-collapse: collapse;"> --}}
    <tr>
		
		<td colspan="3" style="border: 1px solid black;background-color: #b3b1b1" ><span lang="ar-eg">عدد الاكياس: {{$packagetotal}}</span></td>
        <td colspan="5" style="border: 1px solid black;background-color: #b3b1b1"><span lang="ar-eg"> الاجمالى: {{$grandtotal}} </span></td>
    
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
    </tr>
                   
    <tr style="border: none;">  
        <td style="border: none;">   <p>{!! Form::label('Signature', 'التوقيع:') !!} .................................</p></td>
    </tr>
</table>



<script>
     window.onload = function() {
      window.print();
    };
  </script>

</body>

</html>


