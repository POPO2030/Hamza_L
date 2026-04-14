
 @extends('layouts.app')

 @section('title')
    {{__('طباعة غسلة مسبق')}}
@endsection


 @section('content')


 <style>
    .btn.btn-info:hover {
        background-color: #055561;
        color: white;
    }

    table {
        width: 100%;
        border: none;
        border-collapse: collapse;
        margin: auto;
    }

    td {
        padding: 0.5rem;
        text-align: center;
        font-size: 20px !important;
        border: none;
    }

    #table1,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 22px;
        font-weight: bolder;
    }

    #copyright {
        display: none!important; /* Hide copyright by default */
    }
	@media print {
        @page {
            size: A5 landscape;
        }
        .header-container.container-fluid, .footer, #print-reservation, .content-header {
            display: none;
        }
        #copyright {
            display: block!important; 
            font-weight: 700;
        }
    }
</style>

 
 <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-receipt"></i> طباعه حجز الغسلة </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" style="float: left"
                       href="{{ route('reservations.index') }}">
                        رجوع
                    </a>
                    
                    <button  class="btn btn-primary float-left" onclick="window.print()" style="margin-left: 10px;">  طباعه </button> 
                    
                </div>
            </div>
        </div>
    </section>

 <div class="content px-3">
	 <div class="card">
		 <div class="card-body">
			 <div class="row">
				 <table>
					 <tr style="border: none;">
						 <td style="border: none;">
							 <div style="display: flex; align-items: center; justify-content: space-between; padding: 5px;">
								 <div class="col-2 font-weight-bold fs-4 mr-3">
									 <span id="customer-name">{{ $reservation->get_customer->name }}</span>
								 </div>
								 <div class="col-2 font-weight-bold fs-4 mr-3">
									 <span>تسليم: {{ $reservation->get_receivables->name }}</span>
								 </div>
								 <div class="col-2 font-weight-bold fs-4 mr-3">
									 <span>عدد الفاشون: {{ $price }}</span>
								 </div>
								 <div class="col-2 font-weight-bold fs-4 mr-3">
									 <span>{{ date('Y-m-d', strtotime($reservation->reservation_date)) }}</span>
								 </div>
							 </div>
						 </td>
					 </tr>
				 </table>
 
				 <table id="table1" width="1050" height="350" cellspacing="1">
					 <tr>
						 <td>
							 <span lang="ar-eg" >الصنف</span>
						 </td>
						 <td>
							 <span lang="ar-eg" >{{ $reservation->get_products->name }}</span>
						 </td>
						 <td>
							 <span lang="ar-eg" >العدد المبدئى</span>
						 </td>
						 <td>
							 <b><span lang="ar-eg" >{{ $reservation->initial_product_count }}</span></b>
						 </td>
					 </tr>
					 <tr>
						 <td>
							 <span lang="ar-eg">اللون</span> :
						 </td>
						 <td colspan="3">
							 <span class="category-name">
								 @php $names=[] @endphp
								 @foreach($reservation->get_reservation_stage as $service)
								 @php 
								 if(in_array($service->name,$names)){
								   continue;
								 };
								 array_push($names,$service->name) ;
								 @endphp
								 @if($service->get_service_item->get_category->get_category->id == '1')
								 <span>{{$service->get_service_item->name}}</span>
								 @endif
								 @endforeach
							 </span>
						 </td>
					 </tr>
					 <tr>
						 <td>
							 <span lang="ar-eg">الفاشون</span> :
						 </td>
						 <td colspan="3">
							 <span class="category-name">
								 @php $names=[] @endphp
								 @foreach($reservation->get_reservation_stage as $service)
								 @php 
								 if(in_array($service->id,$names)){
								   continue;
								 };
								 array_push($names,$service->id) ;
								 @endphp
								 @if($service->get_service_item->get_category->get_category->id == '2')
								 <span>{{$service->get_service_item->name}}</span>
								 @endif
								 @endforeach
							 </span>
						 </td>
					 </tr>
					 <tr>
						 <td>
							 <span lang="ar-eg">ملاحظات</span> :
						 </td>
						 <td colspan="3">
							 <span>{{ $reservation->note }}</span>
						 </td>
					 </tr>
				 </table>
			 </div>
		 </div>
	 </div>
 </div>
 <div style="display: flex; justify-content: center; align-items: center; text-align: center;" id="copyright">
    <span lang="ar-eg">
        تمت بواسطة <i class="far fa-copyright"></i> ERP Solutions
    </span>
</div>
 @endsection
 
<script>
	window.onload = function() {
	 window.print();
   };
 </script>