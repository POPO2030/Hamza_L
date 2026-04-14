@extends('layouts.app')

@section('title')
    {{__('تقرير الموديل')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i>  تقرير الموديل </h1>
                </div>
                {{-- <div class="col-sm-2">
                </div> --}}
                <div class="col-sm-2" style="font-weight: bold;">
                 <h4> عدد الوجبات:  <span class="badge badge-primary">{{$row_count}}</span></h4>
                  </div>
                  <div class="col-sm-2" style="font-weight: bold;">
                     <h4>   الاجمالى:  <span class="badge badge-primary">{{$product_sum}}</span></h4>
                  </div>
                
                <div class="col-sm-4">

                  
                    <a class="btn btn-primary float-left"
                       href="{{ route('models_report') }}">
                        رجوع
                    </a>

                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-print"></i> تصدير الى الاكسيل 
                      </button>
                      
                   
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">
   
          

            <table class="table table-striped" id="tab">
                <tr id="head">
                    
                    {{-- <th>اذن اضافة</th> --}}
                    <th> الغسلة</th>
                    <th>الوزن</th>
                    <th>العدد</th>
                    {{-- <th>اللون</th> --}}
                    <th>الموديل</th>
                    <th>العميل</th>
                    <th>المستلم</th>
                    <th>المنتج</th>
                  
                
                    <th>مرحله الانتاج</th>
                    <th>جاهز</th>
                    <th>تم تسليم</th>
                    <th>التاريخ</th>
                    
                    @can('workOrders.show')
                    <th>عرض</th>
                    @endcan
                </tr>
                @if(isset($result))

                  @foreach($result as $item)
              
        
                    <tr>
                        {{-- <td>{{$item->receive_receipt_id}}</td> --}}
                        <td>{{$item->id}}</td>
                        <td>{{$item->product_weight}}</td>
                        <td>{{$item->product_count}}</td>
                        <td>{{$item->get_ReceiveReceipt->model}}</td>
                        
                        <td>{{$item->get_customer->name}}</td>
                        <td>{{$item->get_receivables->name}}</td>
                        <td>{{$item->get_products->name}} {{ $item->get_ReceiveReceipt->product_type ? ' (' . $item->get_ReceiveReceipt->product_type . ')' : '' }}</td>
                            
                          
                        <td>
                          @if ($item->get_open_activity)
                            @if (Auth::user()->team_id == 14)       <!----تخطيط مصنع التفصيل----->
                              <span class="badge badge-info">{{'قيد التشغيل'}} </span>
                            @else
                              <span class="badge badge-info">{{$item->get_open_activity->get_owner->name}} </span>
                            @endif
                          @endif
                        </td>

                        <td>
                          @if ($item->get_deliver_order)
                            @php  $ready_store=0;      @endphp
                              @foreach ($item->get_deliver_order as $deliver)
                                @foreach ($deliver->get_details as $details)
                                  @php $ready_store+= $details->total; @endphp 
                                @endforeach
                              @endforeach

                              {{ $ready_store }}
                          @endif
                        </td>

                        <td>
                          @if ($item->get_deliver_order)
                            @php  $deliverd_qty=0;      @endphp
                              @foreach ($item->get_deliver_order as $deliver)
                                @foreach ($deliver->get_final_deliver as $final)
                                    @php $deliverd_qty+= $final->total; @endphp 
                                @endforeach
                              @endforeach

                              {{ $deliverd_qty }}
                          @endif

                        </td>

                            {{-- <td>
                              @if($item->get_activity->isEmpty())
                                @if ($item->get_places)
                                {{$item->get_places->name}}
                                @else
                                ---
                                @endif
                                @elseif ($activity->get_owner->id == 48)
                                @if ($item->get_places)
                                {{$item->get_places->name}}
                              @else
                                ---
                              @endif
                              @endif
                            </td> --}}

                        <td>{{$item->created_at}}</td>

                        @can('workOrders.show')
                        <td>
                          <a href="{{ route('workOrders.show', ['id' => $item->id]) }}" class="btn btn-link btn-default btn-just-icon"><i class="fa fa-eye"></i></a>
                        </td>
                        @endcan
                            
                    </tr>
                  @endforeach
                @endif



              
            </table>
                    
            </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">

               
            </div>

    </div>        
   
                           
@endsection



<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }

</script>















{{-- 
<td>
  @foreach ($item->get_work_order as $work_order)
  
  @php $row_count ++ ;$product_sum+=$work_order->product_count @endphp
  
    <span class="badge badge-success">{{$work_order->id}}</span>
   
    <td>
    @php $names=[];$price=0 @endphp
  
    @foreach($work_order->get_stage as $work_order_service)
      @php
      if(in_array($work_order_service->get_sevice_item_stage->get_service_item->name,$names)){
      continue;
      };
      array_push($names,$work_order_service->get_sevice_item_stage->get_service_item->name ) ;
  
      $price+=$work_order_service->get_sevice_item_stage->get_service_item->price
  
      @endphp
      - <span class="badge bg-success">{{$work_order_service->get_sevice_item_stage->get_service_item->name}}</span>
      
    @endforeach 
 </td> --}}
  
