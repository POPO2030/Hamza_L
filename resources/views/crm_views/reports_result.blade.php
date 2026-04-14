@extends('layouts.app')
<style>
  /* #head{
    position:fixed
  } */

.fa-stack[data-count]:after{
  position:absolute;
  right:-14%;
  top:0%;
  content: attr(data-count);
  font-size:55%;
  padding:.6em;
  border-radius:999px;
  line-height:.75em;
  color: white;
  color: #DF0000;
  text-align:center;
  min-width:2em;
  font-weight:bold;
  background: white;
  border-style:solid;
}
.fa-circle {
  color:#DF0000;
}
</style>
@section('title')
    {{__('تقارير مراحل الانتاج')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-2">
                    <h1><i class="fas fa-scroll"></i> تقارير مراحل الانتاج</h1>
                   
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2" style="font-weight: bold;">
                 <h4> عدد الوجبات:  <span class="badge badge-primary">{{$row_count}}</span></h4>
                  </div>
                  <div class="col-sm-2" style="font-weight: bold;">
                     <h4>   الاجمالى:  <span class="badge badge-primary">{{$product_sum}}</span></h4>
                  </div>
                
                <div class="col-sm-4">
                  
                    <a class="btn btn-primary float-left"
                       href="{{ route('reports') }}">
                        رجوع
                    </a>

                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-print"></i> تصدير الى الاكسيل 
                      </button>
                      <div style=" display:inline-block;font-size:20px; padding: inherit;float:left;" >
                        <a href="{{URL('get_important')}}" style="color:black;font-weight:bold;">
                        <span class="fa-stack fa-1x has-badge" data-count= {{$important}} >
                          
                          <i class="fa fa-circle fa-stack-2x"></i>
                       
                          
                          <i class="fa fa-star fa-stack-1x fa-inverse"></i>
                        </span>
                      </a>
              
                      </div>
                 
                   
                </div>
                  
            </div>
        </div>
    </section>

    <div class="content px-3">



        <div class="clearfix"></div>

        <div class="card">
  

            <table class="table table-striped" id="tab">
      
                <tr id="head">
                    <th> الغسلة</th>
                    <th>اذن اضافة</th>
                    <th>الموديل</th>
                    <th>العميل</th>
                    <th>المستلم</th>
                    <th>المنتج</th>
                    <th>الخيط</th>
                    <th>الوزن</th>
                    <th>العدد</th>
                    <th>اللون</th>
                    <th>مرحله الانتاج</th>
                    <th>المكان</th>
                    <th>التاريخ</th>
                    <th>عدد الفاشون</th>
                    <th>عرض</th>

                </tr>
                @if(isset($result))

                    {{-- @php $row_count=0; $product_sum=0 ;@endphp --}}
                    @if(isset($production_status))

                        @foreach($result as $item)
                   
                            @if($production_status == 'true')
                            
                                @if($item->is_production==0)
                                  @php  continue; @endphp
                                @endif
                                {{-- @php $row_count ++ ;$product_sum+=$item->product_count @endphp --}}
                                <!-- ===========in production======= -->
              <tr>
                <td>{{$item->id}}</td>

                <td>{{$item->get_ReceiveReceipt->id}}</td>
                <td>{{$item->get_ReceiveReceipt->model}}</td>
                <td>{{$item->get_customer->name}}</td>
                <td>{{$item->get_receivables->name}}</td>
                <td>{{$item->get_products->name}} {{ $item->get_ReceiveReceipt->product_type ? ' (' . $item->get_ReceiveReceipt->product_type . ')' : '' }}</td>
                <td>{{$item->color_thread}}</td>
                <td>{{$item->product_weight}}</td>
                <td>{{$item->product_count}}</td>
                <td>
                    @php $names=[];$price=0 @endphp

                    @foreach($item->get_work_order_stage as $work_order_service)
                      @php
                      if(in_array($work_order_service->get_service_item->name,$names)){
                      continue;
                      };
                      array_push($names,$work_order_service->get_service_item->name ) ;

                      $price+=$work_order_service->get_service_item->price

                      @endphp
                      - {{$work_order_service->get_service_item->name}}
                    @endforeach
                </td>
    <td>

      @foreach($item->get_activity as $activity)
        @if($activity->status == 'open')
          {{$activity->get_owner->name}}
        @else
          @if($loop->last)
          {{$activity->get_owner->name}} <!------ اخر مرحلة تم تنفيذها------->
          @endif
        @endif
      @endforeach
    </td>


    <td>
      @if($item->get_activity->isEmpty())
        @if ($item->get_places)
        {{$item->get_places->name}}
        @else
        ---
        @endif
      @else
        ---

      @endif
    </td>

    <td>{{$item->created_at}}</td>

    <td>{{$price}}</td>

    <td>
      <a href="{{ URL('workOrders', $item->id) }}" class="btn btn-link btn-default btn-just-icon">
        <i class="fa fa-eye"></i>
      </a>

    </td>


  </tr>

                            @else
                            @if($item->is_production==1 || $item->product_count==0 )
                            @php  continue; @endphp
                            @endif
                            {{-- @php $row_count ++ ;$product_sum+=$item->product_count @endphp --}}
                            <!-- ===========not in production======= -->
                            <tr>
    <td>{{$item->id}}</td>

    <td>{{$item->get_ReceiveReceipt->id}}</td>
    <td>{{$item->get_ReceiveReceipt->model}}</td>
    <td>{{$item->get_customer->name}}</td>
    <td>{{$item->get_receivables->name}}</td>
    <td>{{$item->get_products->name}} {{ $item->get_ReceiveReceipt->product_type ? ' (' . $item->get_ReceiveReceipt->product_type . ')' : '' }}</td>
    <td>{{$item->color_thread}}</td>
    <td>{{$item->product_weight}}</td>
    <td>{{$item->product_count}}</td>
    <td>
        @php $names=[];$price=0 @endphp

        @foreach($item->get_work_order_stage as $work_order_service)
          @php
          if(in_array($work_order_service->get_service_item->name,$names)){
          continue;
          };
          array_push($names,$work_order_service->get_service_item->name ) ;

          $price+=$work_order_service->get_service_item->price

          @endphp
          - {{$work_order_service->get_service_item->name}}
        @endforeach
    </td>
    <td>

      @foreach($item->get_activity as $activity)
      @if ($activity->get_owner->id == 48)
      
        @continue
        @if($activity->status == 'open')
          {{$activity->get_owner->name}}
        @else
          @if($loop->last)
          {{$activity->get_owner->name}} <!------ اخر مرحلة تم تنفيذها------->
          @endif
        @endif
      @endif
      @endforeach
    </td>


    <td>
      @if($item->get_activity->isEmpty())
        @if ($item->get_places)
        {{$item->get_places->name}}
        @else
        ---
        @endif
      @elseif ($activity->get_owner->id == 48)
        @if (isset($item->get_places))
        {{$item->get_places->name}}
        @else
        ---
        @endif
       
      @else
        ---

      @endif
    </td>

    <td>{{$item->created_at}}</td>

    <td>{{$price}}</td>

    <td>
      <a href="{{ URL('workOrders', $item->id) }}" class="btn btn-link btn-default btn-just-icon">
        <i class="fa fa-eye"></i>
      </a>

    </td>


  </tr>


                            @endif
                        @endforeach

                    @else
                    @foreach($result as $item)
                    {{-- @php $row_count ++ ;$product_sum+=$item->product_count @endphp --}}
                     <!-- ===========in & out production======= -->
  <tr>
    <td>{{$item->id}}</td>

    <td>{{$item->get_ReceiveReceipt->id}}</td>
    <td>{{$item->get_ReceiveReceipt->model}}</td>
    <td>{{$item->get_customer->name}}</td>
    <td>{{$item->get_receivables->name}}</td>
    <td>{{$item->get_products->name}} {{ $item->get_ReceiveReceipt->product_type ? ' (' . $item->get_ReceiveReceipt->product_type . ')' : '' }}</td>
    <td>{{$item->color_thread}}</td>
    <td>{{$item->product_weight}}</td>
    <td>{{$item->product_count}}</td>
    <td>
        @php $names=[];$price=0 @endphp

        @foreach($item->get_work_order_stage as $work_order_service)
          @php
          if(in_array($work_order_service->get_service_item->name,$names)){
          continue;
          };
          array_push($names,$work_order_service->get_service_item->name ) ;

          $price+=$work_order_service->get_service_item->price

          @endphp
          - {{$work_order_service->get_service_item->name}}
        @endforeach
    </td>
    <td>

      @foreach($item->get_activity as $activity)
      @if ($activity->get_owner->id == 48)
      @continue
      @endif
        @if($activity->status == 'open')
          {{$activity->get_owner->name}}
        @else
          @if($loop->last)
          {{$activity->get_owner->name}} <!------ اخر مرحلة تم تنفيذها------->
          @endif
        @endif
      @endforeach
    </td>


    <td>
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
    </td>

    <td>{{$item->created_at}}</td>

    <td>{{$price}}</td>

    <td>
      <a href="{{ URL('workOrders', $item->id) }}" class="btn btn-link btn-default btn-just-icon">
        <i class="fa fa-eye"></i>
      </a>

    </td>


  </tr>
@endforeach

                    @endif



                @endif

            </table>
                    
            </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">

               
            </div>

    </div>        
   
                           
@endsection



<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

        var date = new Date();
        var dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        var fileName = 'متابعة الانتاج ' + dateString ;
        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fileName + '.' + (type || 'xlsx'));
    }

</script>