
<html dir="rtl">
<head>

<title> طباعة الغسلة</title>

    <style>
		  @page {
            size: A5 landscape !important;
            margin: 0px;
        }

        body {
        zoom: 0.73; 
        }

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
                width: 1050px;
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
            .font-weight-bold {
                font-weight: bold;
            }
            .fs-4 {
                font-size: 1.5rem;
            }
            #customer-name {
                margin-right: 1rem;
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

                /* Add this to make background graphics visible */
                * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .badge-secondary {
                color: #fff;
                background-color: #6c757d;
            }
            .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem;
            }

        }
        
        </style>
        
</head>
<body>
	<div class="col-sm-12">
		<a class="btn btn" style="float: left; border: 1px; 
		 width: 50px;text-align:center;margin:5px;border-radius: 8px;padding:5px"
		   href="{{ route('workOrders.index') }}" id="print-workOrder">
			رجوع
		</a>
	</div>
	<br>
    <div class="col-sm-12" style="display: flex; align-items: center; justify-content: space-evenly;">
  <div style="width:90%;">
    <table height="350" cellspacing="1" id="table1" style="border-collapse: collapse; width:100%;">
        <tbody>
            <tr style="border: none;">
                <td style="border: none;" colspan="4">
                    <div style="display: flex; align-items: center; justify-content: space-evenly; padding: 5px;">
                        <div class="col-sm-4 font-weight-bold fs-4 mr-3">
                            <span id="customer-name">{{ $workOrder->get_customer->name }}</span>
                        </div>
                        <div class="col-4 font-weight-bold fs-4 mr-3">
                            <span>الغسلة:</span>
                            <span>{{ $workOrder->id }}</span>
                 
                            <span class="badge badge-secondary">مسلسل: {{ $count_work_orders }}/{{ $index }}</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"   colspan="4">
                    <div style="display: flex; align-items: center; justify-content: space-evenly; padding: 5px;">
                        <div class="col-4 font-weight-bold fs-4 mr-3">
                            <span>اذن اضافة:</span>
                            <span>{{ $workOrder->receive_receipt_id }}</span>
                        </div>
                        <div class="col-4 font-weight-bold fs-4 mr-3">
                            <span>{{ $workOrder->created_at }}</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td  align="center" style="border: 1px solid black;"><span lang="ar-eg" style="font-size: 24px;">الصنف: </span>

                    <span lang="ar-eg">{{$workOrder->get_products->name}}</span>
                </td>
                @if (isset($workOrder->get_fabric_source))
                <td  align="center" style="border: 1px solid black;"><span lang="ar-eg">مصدر القماش: {{$workOrder->get_fabric_source->name}}</span></td>
                @endif
            </tr>
            <tr>
            @if (isset($workOrder->get_fabric))
            <td  align="center" style="border: 1px solid black;"><span lang="ar-eg">الخامة: {{$workOrder->get_fabric->name}}</span></td>
            @endif
                <td  align="center" style="border: 1px solid black;"><span lang="ar-eg">تسليم: {{$workOrder->get_receivables->name}}</span></td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="border: 1px solid black;"><span lang="ar-eg">رقم الموديل: </span>
                {{$workOrder->get_ReceiveReceipt->model}}</td>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid black;">
                    <span lang="ar-eg" style="font-size: 24px;">خيط: </span>
                    <span lang="ar-eg">{{$workOrder->color_thread}}</span>
                </td>
                <td align="center"  style="border: 1px solid black;"><span lang="ar-eg">عدد الفاشون: {{$price}}</span></td>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid black;"><span lang="ar-eg" style="font-size: 24px;">الوزن: {{$workOrder->product_weight}}</span></td>
                <td align="center" style="border: 1px solid black;"><span lang="ar-eg" style="font-size: 24px;">العدد: {{$workOrder->product_count}}</span></td>
            </tr>
            <tr rowspan="3">    
                <td colspan="2" align="center" style="border: none;">
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
        </tbody>
    </table>

        <div style="display: flex; justify-content: center; align-items: center; text-align: center;height:45px; margin-top:10px;">
            {!! DNS1D::getBarcodeHTML("$workOrder->barcode", 'C39E', 2, 50) !!}
        </div>
        <div style="display: flex; justify-content: center; align-items: center; text-align: center; margin-top:5px;">
            <span lang="ar-eg">{{$workOrder->barcode}}</span>
        </div>
    </div> 

        <table style="border-collapse: collapse; width:20%;" >
            <tr style="border: none;">
                <td colspan="2" style="border: none;">
                    <div style="display: flex; flex-wrap: wrap;">
                        @if(!empty($temp))
                        @for($i=0 ; $i<count($temp) ; $i++)
                            <img src="{{ URL($temp[$i]) }}" alt="Image" style="display: inline; margin-bottom: 2px; width: 185px; height: 275px; object-fit: fill;">
                        @endfor
                        @endif
                    </div>

                </td>
            </tr>
        </table>
    </div>


<script>
     window.onload = function() {
      window.print();
    };
  </script>

</body>

</html>


