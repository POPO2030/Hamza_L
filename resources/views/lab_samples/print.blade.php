{{-- @extends('layouts.app') --}}

{{-- @section('title')
    {{__('طباعة إذن استلام العينة')}}
@endsection --}}

{{-- <style> @page {
  width: 80mm;
  /* height: 90mm; */
  text-align: center;
  align-content: center;
  /* size: 79mm ; */
  margin: 0;
}
</style>
<style>

  #table_print, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 24px;
    color:#000;
    font-weight: bold;
  }

  @media print {
    .header, .footer, .mb-2, .content-header {
      display: none !important;
    }
    .header{
      display: none !important;
    }
    .footer{
      display: none !important;
    }

    #hide_tr {
      display: none;
    }

    #table_print {
      width: 80mm;
      /* height: 400px; */
      font-size: 18px;
    }

    #table_print th,
    #table_print td {
      border: 1px solid #000;
      padding: 5px;
    }


    #noteprint {
      text-align: center;
      justify-content: center;
      word-wrap: normal;
      float:right;
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
        font-size: 24px;
    }

	#table1, th, td {
          border: 1px solid black;
          border-collapse: collapse;
		  font-size:24px;
		  font-weight:bolder;
        }
    .font-weight-bold {
        font-weight: bold;
    }
  }
</style> --}}

{{-- @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="fas fa-receipt"> طباعه إذن استلام العينة </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" style="float: left"
                       href="{{ route('labSamples.index') }}">
                        رجوع
                    </a>
                    
                    <button  class="btn btn-primary float-left" onclick="window.print()" style="margin-left: 10px;">  طباعه </button> 
                    
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <div class="content px-3">
        <div class="card"> --}}
            {{-- <div class="card-body"> --}}
                {{-- <div class="row"> --}}


{{-- <table id="table_print" dir="ltr" style="width: 794px; height: 400px; text-align: center; border-collapse: collapse;">

  <tr style="height: 7rem;">
    <th colspan="3" style="border: 1px solid #000;  padding: 5px; font-size: 26px;">
      <div style="align-items: center; padding: 5px; float:right">

          العميل: {{ $labSample->get_customer->name }}
      </div> 
      <div style="padding: 5px; float: left;">{{ $labSample->created_at->format('Y-m-d') }}</div>
    </th>
  </tr>
  <tr style="height: 7rem;">
    <th style="border: 1px solid #000; padding: 5px;">{{ $labSample->get_products->name }}</th> 
    <td colspan="1" style="border: 1px solid #000; padding: 5px;"> 
      <span>عدد القطع:</span>
      <span >{{ $labSample->count }}</span>
      <span > قطعة </span>
      @if(isset($labSample->sample_original_count))
        /
      <span >{{ $labSample->sample_original_count }}</span>
      <span > اصلية </span>
      @endif
    </td>
    <td>رقم العينة: {{ $labSample->id }}  </td>
    
  </tr>
  <tr id="hide_tr">
    <td rowspan="4" height="250" width="600" style="border: 1px solid #000; padding: 5px; text-align: right;">
      @if(!empty($temp))
        @for($i = 0; $i < count($temp); $i++)
          <img src="{{ URL($temp[$i]) }}" alt="Image" style="display: block; margin-bottom: 10px; width: 100%; height: 100%; object-fit: fill;">
        @endfor
      @endif
    </td>
  </tr>
  <tr>
 
 
 
  </tr>
  
  <tr>
   @if (count($labSample->get_samples_stage) > 1)
    <td colspan="3" style="border: 1px solid #000; padding: 5px;">الخدمات: 
      @php $names=[];$price=0 @endphp

      @foreach($labSample->get_samples_stage as $sample_service)
        @php
        if(in_array($sample_service->get_service_item->name,$names)){
        continue;
        };
        array_push($names,$sample_service->get_service_item->name ) ;

        $price+=$sample_service->get_service_item->price

        @endphp
        - {{$sample_service->get_service_item->name}}
      @endforeach
    </td>
    @else
    @endif
  </tr>

  <tr>
    <td colspan="3" style="border: 1px solid #000; padding: 5px;" id="note">
      <div id="noteprint" style="word-wrap: break-word;width:530px; text-align: center; justify-content: center; align-items: center;">
      الملاحظات: {{ $labSample->note }}</td>
      </div>
  </tr>
</table> --}}





{{-- </div>
</div>
</div>
</div> --}}



<html dir="rtl">
<head>

<title> طباعة العينات</title>

    <style>
		  @page {
            width: 80mm;
            height: 90mm;
            text-align: center;
            align-content: center;
            /* size: 79mm ; */
            margin: 0;
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
  #print-workOrder {
    display: none;
  }
  #hide_tr {
      display: none;
    }
}

        </style>
        
</head>
<body>
	<div class="col-sm-12">
	
		<a class="btn btn" style="float: left; border: 1px; 
		width: 50px;text-align:center;margin:5px;border-radius: 8px;padding:5px"
		   href="{{ route('labSamples.index') }}" id="print-workOrder">
		   رجوع
		</a>

	</div>

 
<table  style="border-collapse: collapse;">
    <tr style="border: none;">
   
                    <div style="display: flex; justify-content: center; align-items: center; text-align: center;height:45px">
                        قسم العينات
                    </div>
                    <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                        {{-- <span lang="ar-eg">{{$workOrder->barcode}}</span> --}}
                    </div>
                   
                    <td style="border: none;">
                        <span >{{ $labSample->get_customer->name }}</span>
                    </td>
                    <td style="border: none;">  <span>{{ $labSample->serial }}</span></td>
 
        
    </tr>
</table>

<table  cellspacing="1" id="table1" style="border-collapse: collapse;">
    <tr>
		<td>
            <span lang="ar-eg">{{$labSample->get_products->name}}</span>
        </td>
		<td style="border: 1px solid black;"><span lang="ar-eg"> {{ $labSample->created_at->format('Y-m-d')}}</span></td>
	
    
    </tr>

    <tr>
      @if (isset($labSample->get_fabric))
        <td style="border: 1px solid black;"><span lang="ar-eg">الخامة: {{$labSample->get_fabric->name}}</span></td>
      @endif
      @if (isset($labSample->get_fabric_source))
        <td style="border: 1px solid black;"><span lang="ar-eg">مصدر القماش: {{$labSample->get_fabric_source->name}}</span></td>
      @endif
    </tr>

    <tr>

       
            <td colspan="2"  style="border: 1px solid black;"><span lang="ar-eg">عدد القطع:</span>
              <span >{{ $labSample->count }}</span>
              <span > قطعة </span>
              @if(isset($labSample->sample_original_count))
                /
              <span >{{ $labSample->sample_original_count }}</span>
              <span > اصلية </span>
              @endif</td>
  
    </tr>

    @if (count($labSample->get_samples_stage) > 1)
     <tr >
        <td colspan="2"  style="border: 1px solid black;"><span lang="ar-eg">اللون</span> :<span class="category-name" style="font-size: 20px;">
          @php $names=[];$price=0 @endphp

          @foreach($labSample->get_samples_stage as $sample_service)
            @php
            if(in_array($sample_service->get_service_item->name,$names)){
            continue;
            };
            array_push($names,$sample_service->get_service_item->name ) ;
    
            $price+=$sample_service->get_service_item->price
    
            @endphp
            - {{$sample_service->get_service_item->name}}
          @endforeach
        </span></td>

    </tr>
    @else
    @endif
 
    <tr>
        <td colspan="2"  style="border: 1px solid black;"><span lang="ar-eg">الملاحظات</span>:{{ $labSample->note }}
    </tr>
    <tr id="hide_tr">
      <td colspan="2" rowspan="4" height="250" width="600" style="border: 1px solid #000; padding: 5px; text-align: right;">
        @if(!empty($temp))
          @for($i = 0; $i < count($temp); $i++)
            <img src="{{ URL($temp[$i]) }}" alt="Image" style="display: block; margin-bottom: 10px; width: 100%; height: 100%; object-fit: fill;">
          @endfor
        @endif
      </td>
    </tr>
    <!------------------------------------------------------------------------------->
</table>
<div style="display: flex; justify-content: center; align-items: center; text-align: center;margin-top:5px">
  <span lang="ar-eg">
      تمت بواسطة <i class="far fa-copyright"></i> ERP Solutions
  </span>
</div>


<script src="{{asset('assets/js/font.js')}}"></script>
<script>
     window.onload = function() {
      window.print();
    };
  </script>

</body>

</html>


