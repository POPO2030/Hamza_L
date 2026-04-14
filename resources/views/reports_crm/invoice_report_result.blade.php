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
    .summary-badge {
        font-size: 16px;
        padding: 10px 15px;
        margin: 5px;
        border-radius: 5px;
        display: inline-block;
    }
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
{{ __('تقرير المبيعات') }}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
          اجمالى المبيعات 
          {{-- <span class="badge badge-info" style="font-size: 20px"> {{$customer_name->name}} </span>  --}}
        </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('invoice_report') }}">
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
                        تقرير مبيعات عن الفترة من ({{ formatDate($request->from) }}) - الى ({{ formatDate($request->to) }})
                    @else
                        تقرير مبيعات 
                    @endif
                </td>
  
            </tr>

        </table>

         <div class="row mt-3 mb-3 text-center">
                <div class="col-md-12">
                    <span class="summary-badge badge-dark">
                        إجمالي صافى المبيعات: {{ number_format($totalNetAmount, 2) }} جنيه
                    </span>
                </div>
                <div class="col-md-12">
                    <span class="summary-badge badge-info">
                        إجمالي الغسيل: {{ number_format($totalWashing, 2) }} جنيه
                    </span>
                    <span class="summary-badge badge-success">
                        إجمالي الفاشون: {{ number_format($totalFashion, 2) }} جنيه
                    </span>
                    <span class="summary-badge badge-warning">
                        إجمالي الخصومات: {{ number_format($totalDiscounts, 2) }} جنيه
                    </span>
                    <span class="summary-badge badge-danger">
                        إجمالي ضريبة 14%: {{ number_format($totalTax, 2) }} جنيه
                    </span>
                    <span class="summary-badge badge-primary">
                        إجمالي اشعار خصم 3%: {{ number_format($totalDiscountNotice, 2) }} جنيه
                    </span>
                </div>
            </div>
            
            
        <br>
        <table id="table_print" style="width: 100%">
            <thead>
                <tr style=" text-align: center; font-weight: bold;">
                    <th>العميل</th>
                    <th>الفرع</th>
                    <th>الفاتورة</th>
                    <th>الوزن</th>
                    <th>العدد</th>
                    <th>اجمالى الفاتورة</th>
                    <th>تاريخ الفاتورة</th>
                   
                </tr>
            </thead>
            <tbody>
    
                @php
                    $total_grand_orginal=0;
                @endphp
            @foreach ($result as $invoice)
                <tr>
                    <td>{{$invoice->get_customer->name}}</td>
                    <td>
                        @if ($invoice->branch == 1)
                            جسر السويس
                        @elseif($invoice->branch == 2)
                            بلقس
                        @endif
                    </td>
                    <td>{{$invoice->id}}</td>
                        <!-- Calculate Weight -->
                        <td>
                            @php
                                $totalWeight = 0;
                                foreach($invoice->get_invoice_details as $detail) {
                                    $totalWeight += $detail->total_kg ?? 0;
                                }
                            @endphp
                            {{$totalWeight}}
                        </td>
                        <!-- Calculate Count -->
                        <td>
                            @php
                                $totalCount = 0;
                                foreach($invoice->get_invoice_details as $detail) {
                                    $totalCount += $detail->total_qty ?? 0;
                                }
                            @endphp
                            {{$totalCount}}
                        </td>
                        <!-- Calculate Total -->
                        <td>
                            @php
                                $invoiceTotal = 0;
                                foreach($invoice->get_invoice_details as $detail) {
                                    $invoiceTotal += $detail->total_amount;
                                }
                            @endphp
                            {{number_format($invoiceTotal, 2)}}
                        </td>
                        
                        <td> {{$invoice->date->format('Y-m-d')}} </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background-color: #f8f9fa;">
                        <td colspan="3">الإجمالي</td>
                        <td>
                            @php
                                $grandWeight = 0;
                                foreach($result as $invoice) {
                                    foreach($invoice->get_invoice_details as $detail) {
                                        $grandWeight += $detail->total_kg ?? 0;
                                    }
                                }
                            @endphp
                            {{$grandWeight}}
                        </td>
                        <td>
                            @php
                                $grandCount = 0;
                                foreach($result as $invoice) {
                                    foreach($invoice->get_invoice_details as $detail) {
                                        $grandCount += $detail->total_qty ?? 0;
                                    }
                                }
                            @endphp
                            {{$grandCount}}
                        </td>
                        <td>
                            @php
                                $grandTotal = 0;
                                foreach($result as $invoice) {
                                    // foreach($invoice->get_invoice_details as $detail) {
                                        $grandTotal += $invoice->amount_original;
                                    // }
                                }
                            @endphp
                            {{number_format($grandTotal, 2)}}
                        </td>
                    </tr>
                </tfoot>
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
    
function ExportToExcel(type = 'xlsx', fn, dl) {
    var table = document.getElementById('table_print');

    if (!table) {
        alert("لا يوجد جدول للتصدير");
        return;
    }

    // إنشاء جدول ملخص الإجماليات مؤقتًا
    var summaryTable = document.createElement('table');
    summaryTable.style.marginBottom = '20px';
    var summaryHead = summaryTable.createTHead();
    var headRow = summaryHead.insertRow();
    var cell = headRow.insertCell();
    cell.colSpan = 2;
    cell.innerHTML = 'ملخص الإجماليات';
    cell.style.fontWeight = 'bold';
    cell.style.backgroundColor = '#D9D9D9';
    cell.style.textAlign = 'center';

    var summaryBody = summaryTable.createTBody();

    // قراءة كل القيم من الـ spans
    var spans = document.querySelectorAll('.summary-badge');
    spans.forEach(function(span) {
        var row = summaryBody.insertRow();
        var labelCell = row.insertCell();
        var valueCell = row.insertCell();
        labelCell.innerHTML = span.textContent.split(':')[0];
        valueCell.innerHTML = span.textContent.split(':')[1];
    });

    // إنشاء ملف Excel جديد
    var wb = XLSX.utils.book_new();

    // تحويل جدول الإجماليات إلى Sheet
    var ws_summary = XLSX.utils.table_to_sheet(summaryTable);
    XLSX.utils.book_append_sheet(wb, ws_summary, "ملخص الإجماليات");

    // تحويل جدول البيانات إلى Sheet
    var ws_data = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws_data, "تقرير مبيعات");

    // إعداد RTL
    wb.Workbook = wb.Workbook || {};
    wb.Workbook.Views = [{ RTL: true }];

    // اسم الملف
    var today = new Date();
    var dateStr = today.getFullYear() + "-" + (today.getMonth() + 1).toString().padStart(2, '0') + "-" + today.getDate().toString().padStart(2, '0');
    var safeCustomerName = (typeof reportCustomerName !== 'undefined' ? reportCustomerName : 'كل العملاء').replace(/[\\/:*?"<>|]/g, '-');
    var fileName = 'تقرير مبيعات - ' + safeCustomerName + ' - ' + dateStr + '.' + type;

    // تصدير الملف
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || fileName);
}
</script>
@endpush

<script>
function printFullReport() {
    // جلب الجدول
    var printContents = document.getElementById('table_print').outerHTML;

    // جلب ملخص الإجماليات من ال spans
    var summaryHtml = '<table style="width:100%;border-collapse:collapse;margin-bottom:10px;font-size:13px;">';
    summaryHtml += '<thead><tr style="background-color:#D9D9D9;font-weight:bold;"><th colspan="2" style="border:1px solid #333;padding:5px;text-align:center;">ملخص الإجماليات</th></tr></thead><tbody>';

    var spans = document.querySelectorAll('.summary-badge');
    spans.forEach(function(span) {
        var textParts = span.textContent.split(':');
        summaryHtml += `<tr>
            <td style="border:1px solid #333;padding:4px;text-align:right;">${textParts[0]}</td>
            <td style="border:1px solid #333;padding:4px;text-align:center;">${textParts[1]}</td>
        </tr>`;
    });

    summaryHtml += '</tbody></table>';

    // جلب نص الفترة
    var periodText = "";

    @if(isset($request->from) && isset($request->to))
        periodText = `تقرير مبيعات عن فترة ({{ formatDate($request->from) }}) - الى ({{ formatDate($request->to) }})`;
    @else
        periodText = "تقرير مبيعات";
    @endif

    // فتح نافذة الطباعة
    var printWindow = window.open('', '_blank');

    printWindow.document.open();
    printWindow.document.write(`
        <html dir="rtl" lang="ar">
        <head>
            <title>طباعة التقرير</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 5px 2px 0 2px !important;
                    padding: 0;
                    background: white;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    width: calc(100% - 4px);
                }

                .print-header {
                    text-align: center;
                    margin: 5px 2px 10px 2px;
                }

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

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                .badge {
                    padding: 2px 4px;
                    display: inline-block;
                    border-radius: 2px;
                    font-size: 11px;
                    margin: 1px;
                    line-height: 1.3;
                    color: white !important;
                }

                .badge-primary { background-color: #9c27b0 !important; }
                .badge-secondary { background-color: #6c757d !important; }
                .badge-info { background-color: #00bcd4 !important; }

                @page {
                    size: A4;
                    margin: 5mm 2mm 5mm 2mm !important;
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h3 style="margin:5px 2px;font-size:16px;">${periodText}</h3>
            </div>

            ${summaryHtml}

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