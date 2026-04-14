@extends('layouts.app')

@section('title')
    {{__('تقارير انتاجية الميزان')}}
@endsection
<?php
function formatDate($date) {
    // Convert the date string to a DateTime object
    $dateTime = new DateTime($date);
    // Define the Arabic day names
    $arabicDayNames = array(
        'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'
    );
    // Get the Arabic day name based on the day of the week
    $dayOfWeek = $dateTime->format('w'); // 0 (Sunday) to 6 (Saturday)
    $arabicDayName = $arabicDayNames[$dayOfWeek];

    // Format the date with the Arabic day name
    $formattedDate = $arabicDayName . '، ' . $dateTime->format('d/m/Y');

    return $formattedDate;
}

?>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">

                <div class="col-sm-6">
                   
                    <h1><i class="fas fa-scroll"></i>
                        &nbsp; تقرير انتاجية الميزان مجمع
                        &nbsp; &nbsp; من ({{ formatDate($request->from) }})
                        - الى ({{ formatDate($request->to) }})
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left" href="{{ route('home') }}">
                      رجوع
                    </a>
                
                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> تصدير الى الاكسيل
                      <i class="fas fa-print"></i>
                    </button>
                   
                  </div>
            </div>
        </div>
    </section>

    

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">


            <table class="table table-bordered table-striped table-hover" id="tab">
                <tr>
                    <th> الغسلة</th>
                    <th>اذن اضافة</th>
                    <th>الموديل</th>
                    <th>العميل</th>
                    <th>المستلم</th>
                    <th>المنتج</th>
                    <th>الوزن</th>
                    <th>العدد</th>
                    <th>اللون</th>
                    <th>التاريخ</th>
                    <th>عدد الفاشون</th>
                    <th>عرض</th>
                </tr>
                
                @foreach ($result as $day)
                @if(isset($day->get_workOrders))
                <tr>
                    <td>{{ $day->work_order_id }}</td>
                    <td>{{ $day->get_workOrders->receive_receipt_id }}</td>
                    <td>{{ $day->get_workOrders->get_ReceiveReceipt->model }}</td>
                    <td>{{ $day->get_workOrders->get_customer->name }}</td>
                    <td>{{ $day->get_workOrders->get_receivables->name }}</td>
                    <td>{{ $day->get_workOrders->get_products->name }}</td>
                    <td>{{ $day->get_workOrders->product_weight }}</td>
                    <td>{{ $day->get_workOrders->product_count }}</td>
                    
                    <td>
                        @php $names=[]; $price=0; @endphp
    
                        @foreach($day->get_workOrders->get_stage as $work_order_service)
                           
                                @php
                                if(in_array($work_order_service->get_sevice_item_stage->get_service_item->name, $names)) {
                                    continue;
                                }
                                array_push($names, $work_order_service->get_sevice_item_stage->get_service_item->name);
                                
                                $price += $work_order_service->get_sevice_item_stage->get_service_item->price;
                                @endphp
                        
                                - {{ $work_order_service->get_sevice_item_stage->get_service_item->name }}
                                
                    @endforeach
                    </td>
                    <td>{{ $day->updated_at }}</td>
                    <td>{{ $price }}</td>
                    <td>
                        <a href="{{ URL('workOrders', $day->work_order_id) }}" class="btn btn-link btn-default btn-just-icon">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                </tr>
                @endif
                @endforeach
               
            </table>

        </div>
    </div>
    


@endsection

<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('تقرير ميزان مجمع.' + (type || 'xlsx')));
    }
</script>

