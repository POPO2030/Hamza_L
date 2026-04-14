@extends('layouts.app')

@section('title')
    {{__('تقارير انتاجية الميزان')}}
@endsection
<?php
// Array to map English day names to Arabic equivalents
$arabicDayNames = array(
    "Saturday" => "السبت",
    "Sunday" => "الأحد",
    "Monday" => "الاثنين",
    "Tuesday" => "الثلاثاء",
    "Wednesday" => "الأربعاء",
    "Thursday" => "الخميس",
    "Friday" => "الجمعة"
);
?>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">

                <div class="col-sm-6">
                   
                    <h1><i class="fas fa-scroll"></i>
                        تقرير انتاجية الميزان (الوردية الصباحية)
                        - {{ date("d/m/Y", strtotime("-1 day")) }} 
                        ({{ $arabicDayNames[date("l", strtotime("-1 day"))] }})
                    </h1> 
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left" href="{{ route('home') }}">
                      رجوع
                    </a>
                
                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> تصدير الى الاكسيل
                      <i class="fas fa-print"></i>
                    </button>
                   
                    <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal-default" style="margin-left: 10px;">  بحث  
                        <i class="fas fa-calendar-alt"></i>
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
                @foreach ($balance_shift_day as $day)
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
                @endforeach
            </table>
            <div class="col-sm-4">
                <h1  style="color:#9c27b0;" >(الوردية المسائية)</h1>
            </div>
            <table class="table table-bordered table-striped table-hover" id="tab1">
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
                @foreach ($balance_shift_night as $night)
                <tr>
                    <td>{{ $night->work_order_id }}</td>
                    <td>{{ $night->get_workOrders->receive_receipt_id }}</td>
                    <td>{{ $night->get_workOrders->get_ReceiveReceipt->model }}</td>
                    <td>{{ $night->get_workOrders->get_customer->name }}</td>
                    <td>{{ $night->get_workOrders->get_receivables->name }}</td>
                    <td>{{ $night->get_workOrders->get_products->name }}</td>
                    <td>{{ $night->get_workOrders->product_weight }}</td>
                    <td>{{ $night->get_workOrders->product_count }}</td>
                    
                    <td>
                        @php $name_color=[]; $fashion=0; @endphp
    
                        @foreach($night->get_workOrders->get_stage as $service)
                           
                                @php
                                if(in_array($service->get_sevice_item_stage->get_service_item->name, $name_color)) {
                                    continue;
                                }
                                array_push($name_color, $service->get_sevice_item_stage->get_service_item->name);
                                
                                $fashion += $service->get_sevice_item_stage->get_service_item->price;
                                @endphp
                        
                                - {{ $service->get_sevice_item_stage->get_service_item->name }}
                                
                    @endforeach
                    </td>
                    <td>{{ $night->updated_at }}</td>
                    <td>{{ $fashion }}</td>
                    <td>
                        <a href="{{ URL('workOrders', $night->work_order_id) }}" class="btn btn-link btn-default btn-just-icon">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
    


    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">البحث بتاريخ</h5>
        {{-- <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
        </button> --}}
        </div>
        <div class="modal-body">
            
            <Form method="post" action="{{URL('result_balance_all')}}">
                @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {!! Form::label('from', 'من:') !!}
                            {{-- {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control searchable ','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }} --}}
                            <input type="datetime-local" id="from" name="from" class="form-control" style="width: 100%;">
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('to', 'الى:') !!}
                            {{-- {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control searchable ','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }} --}}
                            <input type="datetime-local" id="to" name="to" class="form-control" style="width: 100%;">
                        </div>
                    </div>
            
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
        </div>
        </div>
      </form>














@endsection

<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
{{-- <script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script> --}}

<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.createElement('div');
        
        // Clone and append the morning table
        var table1 = document.getElementById('tab').cloneNode(true);
        elt.appendChild(table1);
    
        // Add a line break between the tables
        elt.appendChild(document.createElement('br'));
    
        // Clone and append the evening table
        var table2 = document.getElementById('tab1').cloneNode(true);
        elt.appendChild(table2);
    
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    
        if (dl) {
            var wbout = XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
            saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), fn || ('انتاجية الميزان.' + (type || 'xlsx')));
        } else {
            XLSX.writeFile(wb, fn || ('انتاجية الميزان.' + (type || 'xlsx')));
        }
    }
    
    // Convert data to array buffer
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    </script>