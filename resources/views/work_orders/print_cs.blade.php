
<html dir="rtl">
<head>

<title> طباعة الغسلة</title>

    <style>
		  @page {
            width: 80mm;
            /* height: 90mm; */
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
        font-size: 16px;
    }

	#table1, th, td {
          border: 1px solid black;
          border-collapse: collapse;
		  font-size:16px;
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
  #print-workOrder {
    display: none;
  }
  body {
    zoom: 0.83; 
    }
}

        </style>
          <link rel="stylesheet" type="text/css" href="{{ asset('cssNEW/bootstrap.min.css') }}">
          <script src="{{ asset('cssNEW/bootstrap.bundle.min.js') }}" ></script>
</head>
<body>
	<div class="col-sm-12">
		<a class="btn btn-primary" style="float: left; border: 1px; 
		width: 50px;text-align:center;margin:30px;border-radius: 8px;padding:5px"
		   href="{{ route('get_work_order', ['receiveReceipt_id' => $workOrder->receive_receipt_id, 'customer_id' => $workOrder->get_customer->id]) }}" id="print-workOrder">
		   رجوع
		</a>
	</div>
 
<table  style="border-collapse: collapse;">
    <tr style="border: none;">
                          
                    <td style="border: none;">
                        <span >{{ $workOrder->get_customer->name }}</span>
                    </td>
                    <td style="border: none;">  <span>{{ $workOrder->id }}</span></td>

                   
                    <td style="border: none;">
                            @if($note_for_updated_cs)
                            <span class="badge rounded-pill bg-secondary"> {{ "تم التعديل" }} </span>
                            @endif
                    </td>
             
        
    </tr>
</table>

<table  cellspacing="1" id="table1" style="border-collapse: collapse;">
    <tr>
		<td>
            <span lang="ar-eg">{{$workOrder->get_products->name}}</span>
        </td>
		<td style="border: 1px solid black;"><span lang="ar-eg">تسليم: {{$workOrder->get_receivables->name}}</span></td>
    </tr>
    <tr>
        @if (isset($workOrder->get_fabric))
        <td style="border: 1px solid black;"><span lang="ar-eg">الخامة: {{$workOrder->get_fabric->name}}</span></td>
        @endif
        @if (isset($workOrder->get_fabric_source))
        <td style="border: 1px solid black;"><span lang="ar-eg">مصدر القماش: {{$workOrder->get_fabric_source->name}}</span></td>
        @endif
    </tr>

    <tr>
		<td style="border: 1px solid black;"><span lang="ar-eg"> الموديل: </span>
        {{$workOrder->get_ReceiveReceipt->model}}</td>
  
        <td>
            <span>اذن اضافة:</span>
            <span>{{ $workOrder->receive_receipt_id }}</span>
        </td>
        
	</tr>
    <tr>

       
       
            <td style="border: 1px solid black;"><span lang="ar-eg">العدد المبدئى:</span>{{$workOrder->initial_product_count}}</td>
  
        {{-- <td style="border: 1px solid black;">
            <div style="display: flex; justify-content: center; align-items: center; text-align: center;height:45px">
                {!! DNS1D::getBarcodeHTML("$workOrder->barcode", 'C39E', 2, 50) !!}
            </div>
            <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                <span lang="ar-eg">{{$workOrder->barcode}}</span>
            </div>
        </td> --}}
       
        <td style="border: 1px solid black;"><span lang="ar-eg">عدد الفاشون: {{$price}}</span></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black;"><span lang="ar-eg"> خيط: {{$workOrder->color_thread}}</span></td>
    </tr>

     {{-- <tr > --}}
        {{-- <td colspan="2"  style="border: 1px solid black;"><span lang="ar-eg">اللون</span> :<span class="category-name" style="font-size: 20px;">
            @php $names=[] @endphp
            @foreach($work_order_services as $work_order_service)
                @foreach($work_order_service->get_work_order_service as $service)
                    @php 
                    if(in_array($service->name,$names)){
                        continue;
                    };
                    array_push($names,$service->name) ;
                    @endphp
                    @if($service->get_category->get_category->id == '1')
                        <span>{{$service->name}}</span>
                    @endif
                @endforeach
            @endforeach
        </span></td> --}}
        {{-- <td  style="border: 1px solid black;">
            <span class="category-name" style="font-size: 20px;">
                @php $names=[] @endphp
                @foreach($work_order_services as $work_order_service)
                    @foreach($work_order_service->get_work_order_service as $service)
                        @php 
                        if(in_array($service->name,$names)){
                            continue;
                        };
                        array_push($names,$service->name) ;
                        @endphp
                        @if($service->get_category->get_category->id == '1')
                            <span>{{$service->name}}</span>
                        @endif
                    @endforeach
                @endforeach
            </span>
        </td> --}}
    {{-- </tr> --}}
 {{--   <tr>
        <td  style="border: 1px solid black;"><span lang="ar-eg">الفاشون</span> :</td>
        <td style="border: 1px solid black;">
            <span class="category-name" style="font-size: 20px;">
                @php $names=[] @endphp
                @foreach($work_order_services as $work_order_service)
                    @foreach($work_order_service->get_work_order_service as $service)
                        @php 
                        if(in_array($service->name,$names)){
                            continue;
                        };
                        array_push($names,$service->name) ;
                        @endphp
                        @if($service->get_category->get_category->id == '2')
                            <span>{{$service->name}}</span>
                        @endif
                    @endforeach
                @endforeach
            </span>
        </td>
    </tr> --}}
    <!--------------------------الملاحظات------------------------------------------------->
    <tr>      
        <td colspan="2" style="border: 1px solid black;">
            <div style="display: flex; justify-content: space-around;">
                @php $names=[] @endphp
                @foreach($workOrder->get_note as $service)
                    @php 
                    if(in_array($service->note,$names)){
                        continue;
                    };
                    array_push($names,$service->note) ;
                    @endphp
                    @if($service->creator_team_id == '1' || $service->creator_team_id == '2' || $service->creator_team_id == '3' || $service->creator_team_id == '4')  <!--خدمة العملاء-->
                    
                    @php
                    $spanContent = explode('/', $service->note);
                    $spanChunks = array_chunk($spanContent, 6);
                    @endphp
            
                    @foreach ($spanChunks as $index => $chunk)
                    <div style="display: inline-block;margin-right: 3px;@if($index > 0) margin-left: 10px; @endif">
                        <ul style="list-style-type: disc; padding-left: 15px;">
                            @foreach ($chunk as $content)
                                <li>{{$content}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
            
                    @endif 
                @endforeach
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><span>{{ $workOrder->created_at }}</span></td>
    </tr>
    <!------------------------------------------------------------------------------->
</table> 
<br>
<div style="display: flex; justify-content: center; align-items: center; text-align: center; height:45px;">
    {!! DNS1D::getBarcodeHTML("$workOrder->barcode", 'C93', 2, 50) !!}
</div>
<div style="display: flex; justify-content: center; align-items: center; text-align: center;">
    <span lang="ar-eg">{{$workOrder->barcode}}</span>
</div>
<div style="display: flex; justify-content: center; align-items: center; text-align: center;">
    <span lang="ar-eg">
        تمت بواسطة <i class="far fa-copyright"></i> Nexgen
    </span>
</div>

{{-- <table width="80mm" style="border-collapse: collapse;">
    <tr style="border: none;">
        <td colspan="4" style="border: none;">
			<div style="display: flex; flex-wrap: wrap;">
				@if(!empty($temp))
				  @for($i=0 ; $i<count($temp) ; $i++)
					<img src="{{ URL($temp[$i]) }}" alt="Image" style="display: inline; margin-bottom: 2px; width: 500; height: 200; object-fit: fill;">
				  @endfor
				@endif
			  </div>

		</td>
	</tr>
	</table> --}}

    <script src="{{asset('assets/js/font.js')}}"></script>
<script>
     window.onload = function() {
      window.print();
    };
  </script>

</body>

</html>