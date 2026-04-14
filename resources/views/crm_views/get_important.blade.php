@extends('layouts.app')

@section('title')
    {{__('تقرير الغسلات الهامة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقرير الغسلات الهامة</h1>
                </div>
                <div class="col-sm-6">

                    <a class="btn btn-primary float-left"
                       href="{{ route('reports') }}">
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
          <tr>
            <th> الغسلة</th>
            <th>اذن اضافة</th>
            <th>العميل</th>
            <th>المستلم</th>
            <th>المنتج</th>
            <th>الوزن</th>
            <th>العدد</th>
            <th>اللون</th>
            <th>مرحله الانتاج</th>
            <th>المكان</th>
            <th>التاريخ</th>
            <th>عدد الفاشون</th>
            <th>عرض</th>

          </tr>
          @if(isset($important))

            @foreach($important as $item)
              <tr>
                <td>{{$item->id}}</td>

                <td>{{$item->get_ReceiveReceipt->id}}</td>
                <td>{{$item->get_customer->name}}</td>
                <td>{{$item->get_receivables->name}}</td>
                <td>{{$item->get_products->name}}</td>
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