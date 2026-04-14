@extends('layouts.app')

@push('page_css')

<style>
    table, th, td {
    border: 1px solid;
    weight: 90%;
    text-align: center;
    }
</style>
<style>
  tr{
        text-align: center
    }
    .hover-image {
        width: 50px;
        height: 50px;
        transition: width 0.3s, height 0.3s;
    }

    .hover-image:hover {
        width: 250px;
        height: 300px;
    }
    .col-sm-12.printable.p-10{
            padding: 5 !important;
            text-align: center;
            display: none;
        }
        #head{
        background-color: #fdfdfd !important; 
        font-weight: bold;
       }

       .btn.btn-fab, .btn.btn-just-icon{
        height: 30px !important;
       }

   @media print {
    @page {
        size: A4;
        margin: 10mm !important;
    }

    .header, .main-footer, .mb-2, .fixed-plugin, .footer {
        display: none;
    }
    
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background-color: white !important;
    }
    
    .main-sidebar {
        display: none !important;
    }

    .content {
        background-color: white !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    }
    
    .col-sm-12.printable.p-10 {
        padding: 5px !important;
        display: block;
        font-size: 20px;
        font-weight: bolder;
    }
    
    #reporttitle {
        display: none;
    }
    
    #tab1 {
        max-height: none !important;
        overflow: visible !important;
        height: auto !important;
    }
    
    .hide_column {
        display: none;
    }
    
    .ps-scrollbar-y-rail, .ps-scrollbar-y {
        display: none;
    }
    
    /* New rules to ensure proper table printing */
    table {
        page-break-inside: auto;
        width: 100% !important;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    thead {
        display: table-header-group;
    }
    
    tfoot {
        display: table-footer-group;
    }
    
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
@endpush

@section('title')
{{ __('كشف  حساب العميل تفصيلى') }}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
          كشف  حساب العميل تفصيلى
          {{-- <span class="badge badge-info" style="font-size: 20px"> {{$customer_name->name}} </span>  --}}
        </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('customer_account_report') }}">
            رجوع
        </a>
        <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
            <i class="fas fa-file-excel"></i> تصدير الى الاكسيل 
          </button>
          <button class="btn btn-primary btn-sm float-left" onclick="printFullReport()" style="margin-left: 10px;"> 
           <i class="fas fa-print"></i> طباعه 
        </button>

    </div>
  </div>
</div>
</section>


    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        {{-- <div class="card">
            <div class="card-body">
                <h4 style="text-align: center">



                </h4>

            </div>
        </div> --}}
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
        <div class="card">
            <div class="card-body">

                <table style="width: 100%">
                    <tr>
                        <td colspan="6" style="background-color: #6c757d;font-weight: bold; color:#fff;">
                          @if(isset($request->from) && isset($request->to))
                              كشف حساب عن الفترة من ({{ formatDate($request->from) }}) - الى ({{ formatDate($request->to) }})
                          @else
                               كشف حساب 
                          @endif
                        </td>
  
                      </tr>

                    <tr>
                        <td colspan="6" style="background-color: #6c757d;font-weight: bold; color:#fff;">
                            العميل : {{$customer_name}}
                        </td>
                    </tr>


                    {{-- <tr>
                        <td colspan="5" style="text-align: center; background-color: #628ca1; font-weight: bold;">
                            رصيد اول المدة : التاريخ {{ \Carbon\Carbon::parse($request->from)->subDay()->format('Y-m-d') }}
                        </td>
                        <td  style="text-align: center; background-color: #628ca1; font-weight: bold;">
                            {{ $customer_balance_first_period }}  
                        </td>
                    </tr> --}}
                  </table>
        <br>
        <table id="table_print" style="width: 100%">
            <thead>
                <tr style=" text-align: center; font-weight: bold;">
                    <th>اذن التسليم</th>
                    <th>اذن الاضافة</th>
                    <th>الموديل</th>
                    <th>جهة التسليم</th>
                    <th>نوع الغسيل</th>
                    <th>العدد / الوزن</th>
                    <th>سعر الغسيل</th>
                    <th>قيمة الغسيل</th>
                    <th>نوع الفاشون</th>
                    <th>العدد</th>
                    <th>سعر الفاشون</th>
                    <th>قيمة الفاشون</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>رصيد</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $balance = $customer_balance_first_period;
                @endphp

                    <tr>
                        <td colspan="10" style="text-align: center;  font-weight: bold;"></td>
               
                        <td colspan="2" style="text-align: center; font-weight: bold;">   
                            @if(isset($request->from))
                            التاريخ
                                {{ \Carbon\Carbon::parse($request->from)->subDay()->format('Y-m-d') }}
                            @endif
                        </td>
                        <td colspan="2" style="text-align: center; font-weight: bold;"> 
                             رصيد اول المدة
                        </td>
                        <td colspan="1" style="text-align: center;  font-weight: bold;">
                            <span class="badge badge-info">
                             {{ $customer_balance_first_period }}  
                            </span>
                        </td>
                    </tr>

                @foreach ($customer_all_details as $order)
                    @if ($order->invoice_id)
                        {{-- Invoice header row --}}
                        <tr>
                            <td colspan="15" style="text-align: right; font-weight: bold;">
                                <span class="badge badge-primary export-hide">
                                    فاتوره رقم ( {{ $order->invoice_id }} ) : التاريخ {{ $order->date }}
                                </span>
                                <span class="export-only" style="display:none;">
                                    فاتوره رقم ( {{ $order->invoice_id }} ) : التاريخ {{ $order->date }}
                                </span>
                                <span class="badge badge-secondary export-hide">
                                    الاجمالى {{ $order->get_invoice->amount_net}}
                                </span>
                                <span class="export-only" style="display:none;">
                                    الاجمالى {{ $order->get_invoice->amount_net}}
                                </span>
                            </td>
                        </tr>
                        
                        {{-- Loop through invoice items --}}
                        @foreach ($order->get_invoice_details as $item)
                            @php
                                // Filter services by type using the relationship
                                $wash_services = $item->get_invoice_services->where('service_id', 1);
                                $fashion_services = $item->get_invoice_services->where('service_id', 2);

                                $wash_names = [];
                                $price_wash = 0;
                                foreach ($wash_services as $wash) {
                                    $wash_names[] = $wash->get_service_item->name;
                                    $price_wash += $wash->service_price;
                                }
                                
                                $fashion_names = [];
                                $price_fashion = 0;
                                foreach ($fashion_services as $fashion) {
                                    $fashion_names[] = $fashion->get_service_item->name;
                                    $price_fashion += $fashion->service_price;
                                }
                                
                                $total_kg = $item->total_kg ?? 0;
                                $total_qty = $item->total_qty ?? 0;
                                $wash_value = $price_wash * $total_kg;
                                $fashion_value = $price_fashion * $total_qty;
                                
                                // Calculate debit
                                $debit = ($item->piece_price == null)
                                    ? $wash_value + $fashion_value
                                    : $item->piece_price * $total_qty;
                                
                                $balance += $debit;
                            @endphp
                            
                            {{-- Display item row with current balance --}}
                            <tr>
                                <td style="text-align: center;">{{ $item->final_deliver_order_id }}</td>
                                <td style="text-align: center;">{{ $item->get_work_order?->receive_receipt_id }}</td>
                                <td style="text-align: center;">
                                    {{ $item->get_work_order?->get_products?->name ?? '' }}
                                    {{ $item->get_work_order?->get_ReceiveReceipt?->product_type ?? '' }} 
                                    ({{ $item->get_work_order?->get_ReceiveReceipt?->model ?? '----' }})
                                </td>
                                <td style="text-align: center;">
                                    {{ $item->get_work_order?->get_receivables?->name ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    @foreach ($wash_names as $name)
                                        <span class="badge badge-secondary">{{ $name }}</span>
                                    @endforeach
                                </td>
                    
                                @if ($item->piece_price == null)
                                    <td style="text-align: center;">{{ $total_kg }}</td>
                                    <td style="text-align: center;">{{ $price_wash }}</td>
                                    <td style="text-align: center;">{{ $wash_value }}</td>
                                @else
                                    <td style="text-align: center;">{{ $total_qty }}</td>
                                    <td style="text-align: center;">{{ $item->piece_price }}</td>
                                    <td style="text-align: center;">{{ $item->piece_price * $total_qty }}</td>
                                @endif
                    
                                <td style="text-align: center;">
                                    @foreach ($fashion_names as $name)
                                        <span class="badge badge-secondary">{{ $name }}</span>
                                    @endforeach
                                </td>
                                @if ($item->piece_price == null)
                                    <td style="text-align: center;">{{ $total_qty }}</td>
                                    <td style="text-align: center;">{{ $price_fashion }}</td>
                                    <td style="text-align: center;">{{ $fashion_value }}</td>
                                @else
                                    <td style="text-align: center;">{{ $total_qty }}</td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;">0</td>
                                @endif
                                <td style="text-align: center;">{{ $debit }}</td>
                                <td style="text-align: center;">0</td>
                                <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                            </tr>
                        @endforeach
                        
                        {{-- Apply invoice adjustments after all items --}}
                        @php
                            $adjustments_exist = ($order->get_invoice->amount_minus > 0 || 
                                                $order->get_invoice->tax > 0 || 
                                                $order->get_invoice->discount_notice > 0);
                        @endphp
                        
                        @if ($adjustments_exist)
                            @if ($order->get_invoice->amount_minus > 0)
                                @php $balance -= $order->get_invoice->amount_minus; @endphp
                                <tr>
                                    <td colspan="12" style="text-align: center; background-color: #474747; font-weight: bold; color: #fff;">
                                        <span class="badge badge-info"> مبلغ الخصم </span>
                                    </td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;">{{ $order->get_invoice->amount_minus }}</td>
                                    <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                                </tr>
                            @endif

                            @if ($order->get_invoice->tax > 0)
                                @php $balance += $order->get_invoice->tax; @endphp
                                <tr>
                                    <td colspan="12" style="text-align: center; background-color: #474747; font-weight: bold; color: #fff;">
                                        <span class="badge badge-info"> ضريبة 14 % </span>
                                    </td>
                                    <td style="text-align: center;">{{ $order->get_invoice->tax }}</td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                                </tr>
                            @endif

                            @if ($order->get_invoice->discount_notice > 0)
                                @php $balance -= $order->get_invoice->discount_notice; @endphp
                                <tr>
                                    <td colspan="12" style="text-align: center; background-color: #474747; font-weight: bold; color: #fff;">
                                        <span class="badge badge-info"> اشعار خصم 3 % </span>
                                    </td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;">{{ $order->get_invoice->discount_notice }}</td>
                                    <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                                </tr>
                            @endif
                        @endif
                        
                    @elseif ($order->invoice_id == null)
                        {{-- Payment rows --}}
                        @php 
                            if($order->payment_type_id == 10 || $order->payment_type_id == 2 || $order->payment_type_id == 3 || $order->payment_type_id == 5){      // خصم
                                $balance -= $order->cash_balance_credit;
                            }elseif($order->payment_type_id == 11) {    // تسويه
                                $balance += $order->cash_balance_debit;
                            }
                           
                        @endphp
                        <tr>
                            <td colspan="12" style="text-align: center; background-color: #474747; font-weight: bold; color: #fff;">
                                @if ($order->payment_type_id == 2)  
                                <span class="badge badge-info" ><i class="fas fa-coins"></i>{{ $order->get_payment_type->name}}</span>
                                بتاريخ {{ $order->date }} <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                                @elseif ($order->payment_type_id == 3) 
                                <span class="badge badge-info" ><i class="fas fa-money-bill"></i>{{ $order->get_payment_type->name}} </span>
                                بتاريخ {{ $order->date }} <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                                @elseif ($order->payment_type_id == 4) 
                                <span class="badge badge-info" ><i class="fas fa-coins"></i> {{ $order->get_payment_type->name}} </span>
                                بتاريخ {{ $order->date }} <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                                @elseif ($order->payment_type_id == 5) 
                                <span class="badge badge-info" ><i class="fas fa-money-bill"></i> {{ $order->get_payment_type->name}} </span>
                                بتاريخ {{ $order->date }} <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                                @elseif ($order->payment_type_id == 10)
                                <span class="badge badge-info" ><i class="fas fa-coins"></i>{{ $order->get_payment_type->name}}</span>
                                بتاريخ {{ $order->date }} <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                         
                                @elseif ($order->payment_type_id == 11)
                                <span class="badge badge-info" ><i class="fas fa-coins"></i>{{ $order->get_payment_type->name}}</span>
                                بتاريخ {{ $order->date }}  <span class="badge rounded-pill bg-light text-dark" style="color: red; font-weight:bolder">  {{ $order->note }} </span>
                                @endif
                            </td>
                           
                                @if($order->payment_type_id == 10 ||$order->payment_type_id == 2 || $order->payment_type_id == 3 || $order->payment_type_id == 5)         {{-- خصم  --}}
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;">{{ $order->cash_balance_credit }}</td>
                                    <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                                @elseif($order->payment_type_id == 11)    {{-- تسويه  --}}
                                    <td style="text-align: center;">{{ $order->cash_balance_debit }}</td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;"><span class="badge badge-info">{{ $balance }}</span></td>
                                @endif
                            
                           
                           
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
                
             
                
                <div class="card-footer text-center">
                    <div class="row">
                       
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

@endsection

@push('page_scripts')
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>

<script>
    var customerName = @json($customer_name);
    function ExportToExcel(type, fn, dl) {
        // إخفاء النص الأصلي (badge) وإظهار النص الخاص بالتصدير مع تعديل التاريخ
        var badges = document.querySelectorAll('.export-hide');
        var exportSpans = document.querySelectorAll('.export-only');

        badges.forEach(badge => badge.style.display = 'none');
        exportSpans.forEach(span => {
            // تعديل النص داخل span: نضيف ' قبل التاريخ
            span.textContent = span.textContent.replace(/التاريخ (\d{4}-\d{2}-\d{2})/, "التاريخ '$1");
            span.style.display = 'inline';
        });

        var elt = document.getElementById('table_print');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "كشف حساب" });

        wb.Workbook = wb.Workbook || {};
        wb.Workbook.Views = [{ RTL: true }];

        // إعادة الحالة كما كانت بعد التصدير
        badges.forEach(badge => badge.style.display = 'inline');
        exportSpans.forEach(span => span.style.display = 'none');

        var safeCustomerName = customerName.replace(/[\\/:*?"<>|]/g, '-');
        var fileName = 'كشف حساب عميل - ' + safeCustomerName + '.' + (type || 'xlsx');

        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || fileName);
    }
</script>
@endpush

<script>
function printFullReport() {
    // Get all the content you want to print
    var printContents = document.getElementById('table_print').outerHTML;
    var customerName = "{{ $customer_name }}";
    var periodText = "";
    
    @if(isset($request->from) && isset($request->to))
        periodText = `كشف حساب عن الفترة من ({{ formatDate($request->from) }}) - الى ({{ formatDate($request->to) }})`;
    @else
        periodText = "كشف حساب";
    @endif

    var printWindow = window.open('', '_blank');

    printWindow.document.open();
    printWindow.document.write(`
        <html dir="rtl" lang="ar">
        <head>
            <title>كشف حساب العميل ${customerName}</title>
            <style>
                /* Base Styles */
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 5px 2px 0 2px !important;
                    padding: 0;
                    background: white;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    width: calc(100% - 4px);
                }
                
                /* Header Styles */
                .print-header {
                    text-align: center;
                    margin: 5px 2px 10px 2px;
                    padding: 0;
                }
                
                /* Table Styles */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 0;
                    page-break-inside: auto;
                    font-size: 12px;
                }
                
                th, td {
                    border: 1px solid #333;
                    padding: 4px;
                    text-align: center;
                }
                
                th {
                    background-color: #f0f0f0 !important;
                    font-weight: bold;
                }
                
                /* Custom Badge Colors */
                .badge {
                    padding: 2px 4px;
                    display: inline-block;
                    border-radius: 2px;
                    font-size: 11px;
                    margin: 1px;
                    line-height: 1.3;
                    color: white !important;
                }
                
                .badge-primary {
                    background-color: #9c27b0 !important; /* Purple */
                }
                
                .badge-secondary {
                    background-color: #6c757d !important; /* Gray */
                }
                
                .badge-info {
                    background-color: #00bcd4 !important; /* Cyan */
                }
                
                /* Page Break Control */
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                
                /* Page Settings */
                @page {
                    size: A4;
                    margin: 5mm 2mm 0mm 2mm !important;
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h3 style="margin:5px 2px;font-size:16px;">${periodText}</h3>
                <h4 style="margin:5px 2px;font-size:14px;">العميل: ${customerName}</h4>
            </div>
            ${printContents}
            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 300);
                    }, 200);
                };
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>