@extends('layouts.app')

@section('title')
    {{__('تقارير اذون التسليم')}}
@endsection
<?php
function formatDate($date) {
    // Convert the date string to a DateTime object
    $dateTime = new DateTime($date);
    // Define the Arabic item names
    $arabicitemNames = array(
        'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'
    );
    // Get the Arabic item name based on the item of the week
    $itemOfWeek = $dateTime->format('w'); // 0 (Sunitem) to 6 (Saturitem)
    $arabicitemName = $arabicitemNames[$itemOfWeek];

    // Format the date with the Arabic item name
    $formattedDate = $arabicitemName . '، ' . $dateTime->format('d/m/Y');

    return $formattedDate;
}

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        direction: rtl;
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f4f4f4;
    }
    .summary {
        font-weight: bold;
    }
    .view-button {
            display: inline-block;
            margin-bottom: 10px;
        }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">

                <div class="col-sm-6">
                   
                    <h1><i class="fas fa-scroll"></i>
                        &nbsp; تقرير اذون التسليم
                        &nbsp; &nbsp;
                        @if (isset($request->from))
                            @if ($request->from == $request->to)
                                يوم ({{ formatDate($request->from) }})
                            @else
                                من ({{ formatDate($request->from) }})
                                - الى ({{ formatDate($request->to) }})
                            @endif
                        @endif
                        
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left" href="{{ route('final_delivers_report') }}">
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


            <div class="card-body row">
                <!-- Wrapper table for export -->
                <table id="export-table" style="display: none;">
                    <thead>
                        <tr>
                            <th>اذن تسليم</th>
                            <th>الغسلة</th>
                            <th>اذن اضافة</th>
                            <th>العدد</th>
                            <th>الوزن</th>
                            <th>الموديل</th>
                            <th>العميل</th>
                            <th>المستلم</th>
                            <th>المنتج</th>
                            <th>الخدمات</th>
                            <th>عدد الفاشون</th>
                            <th>عدد الاكياس</th>
                            <th>كمية التسليم</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $finalDeliverOrder)
                            @foreach ($finalDeliverOrder['work_orders'] as $workOrder)
                                <tr>
                                    <td>{{ $finalDeliverOrder['final_deliver_order_id'] }}</td>
                                    <td>{{ $workOrder['work_order_id'] }}</td>
                                    <td>{{ $workOrder['receive_receipt_id'] }}</td>
                                    <td>{{ $workOrder['work_order_product_count'] }}</td>
                                    <td>{{ $workOrder['work_order_product_weight'] }}</td>
                                    <td>{{ $workOrder['model'] ?? '' }}</td>
                                    <td>{{ $workOrder['customer_name'] }}</td>
                                    <td>{{ $workOrder['receivable_name'] }}</td>
                                    <td>{{ $workOrder['product_name'] }}</td>
                                    <td>
                                        @foreach ($workOrder['service_item_names'] as $service)
                                            <span class="badge badge-info"> {{$service}} </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $workOrder['service_items_total_price'] }}</td>
                                    <td>{{ $workOrder['package_number_sum'] }}</td>
                                    <td>{{ $workOrder['total_sum'] }}</td>
                                    <td>{{ $workOrder['created_at'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            
                <!-- Display tables for the user -->
                @foreach ($result as $finalDeliverOrder)
                    <div class="view-button">
                        <a href="{{ URL('show_final_deliver', $finalDeliverOrder['final_deliver_order_id']) }}" target="_blank" class="badge badge-primary">
                            <i class="fa fa-eye"></i> اذن تسليم: {{ $finalDeliverOrder['final_deliver_order_id'] }}
                        </a>
                    </div>
                    <table class="table table-bordered table-striped table-hover" id="tab">
                        <thead>
                            <tr>
                                <th>الغسلة</th>
                                <th>اذن اضافة</th>
                                <th>العدد</th>
                                <th>الوزن</th>
                                <th>الموديل</th>
                                <th>العميل</th>
                                <th>المستلم</th>
                                <th>المنتج</th>
                                <th>الخدمات</th>
                                <th>عدد الفاشون</th>
                                <th>عدد الاكياس</th>
                                <th>كمية التسليم</th>
                                <th>التاريخ</th>
                                <th>عرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finalDeliverOrder['work_orders'] as $workOrder)
                                <tr>
                                    <td>{{ $workOrder['work_order_id'] }}</td>
                                    <td>{{ $workOrder['receive_receipt_id'] }}</td>
                                    <td>{{ $workOrder['work_order_product_count'] }}</td>
                                    <td>{{ $workOrder['work_order_product_weight'] }}</td>
                                    <td>{{ $workOrder['model'] ?? '' }}</td>
                                    <td>{{ $workOrder['customer_name'] }}</td>
                                    <td>{{ $workOrder['receivable_name'] }}</td>
                                    <td>{{ $workOrder['product_name'] }}</td>
                                    <td>
                                        @foreach ($workOrder['service_item_names'] as $service)
                                            <span class="badge badge-info"> {{$service}} </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $workOrder['service_items_total_price'] }}</td>
                                    <td>{{ $workOrder['package_number_sum'] }}</td>
                                    <td>{{ $workOrder['total_sum'] }}</td>
                                    <td>{{ $workOrder['created_at'] ?? '' }}</td>
                                    <td>
                                        <a href="{{ URL('workOrders', $workOrder['work_order_id']) }}" target="_blank" class="btn btn-link btn-default btn-just-icon">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="summary">
                                <td colspan="10">المجموع</td>
                                <td>{{ $finalDeliverOrder['total_package_number'] }}</td>
                                <td>{{ $finalDeliverOrder['total_sum'] }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
    


@endsection

<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
    function ExportToExcel(type, fn, dl) {
        // Select the wrapper table for export
        var elt = document.getElementById('export-table');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('تقرير اذون التسليم.' + (type || 'xlsx')));
    }
    </script>

