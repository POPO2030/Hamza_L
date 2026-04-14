
@extends('layouts.app')

@push('page_css')
<style>
    .table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }
    .table th, .table td {
        padding: 8px;
        text-align: center;
        border: 1px solid #dee2e6; 
    }
    .table thead th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .table tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }
    .grand-total-container {
        margin-bottom: 5px;
        text-align: center;
    }
    .grand-total-badge {
        font-size: 18px;
        padding: 10px 20px;
        border-radius: 20px;
    }


    @media print {
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            -webkit-print-color-adjust: exact;
            background-color: white!important;
            font-family: 'Arial', sans-serif;
                    text-align: center;
                    margin: 10px;
                    /* padding: 0; */
            zoom: 97%;
        }
        body > *:not(#print-area) {
            display: none;
        }
        #print-area {
            display: block;
        }
        .table {
            page-break-inside: auto;
            width: 80%;
            border-collapse: collapse !important;
        }
        .table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .table thead {
            display: table-header-group;
        }
        .table::before {
            content: element(reportTitle);
            display: table-row;
        }
    }
</style>
@endpush

@section('title')
    {{__('تقرير الخدمات المباعة')}}
@endsection

@section('content')
<section class="content-header no-print">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fas fa-text-height"></i>
                    تقرير الخدمات المباعة 
                </h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary btn-sm float-left" href="{{ route('service_prices_report') }}">
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

{{-- // Blade view --}}
<div class="container">
    <div class="card">
        <div class="card-body">
            @if(count($processedResults) > 0)
                <div class="table-responsive">
                    <table class="table table-striped" id="tab">
                        <thead>
                            <tr class="total-row">
                                <td colspan="10" style="text-align: left; padding-left: 20px;">
                                    <span class="badge badge-secondary total-badge">
                                        اجمالى السعر: {{ number_format($grandTotal, 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">اسم الخدمة</th>
                                <th width="4%">التكرار</th>
                                <th width="9%">الوزن/العدد</th>
                                <th width="9%">السعر</th>
                                <th width="12%">الإجمالي</th>
                                <th width="8%">رقم الفاتورة</th>
                                <th width="15%">اسم العميل</th>
                                <th width="10%">الفرع</th>
                                <th width="11%">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($processedResults as $result)
                                <tr>
                                    <td>{{ $result['counter'] }}</td>
                                    <td>{{ $result['service_item']['name'] }}</td>
                                    <td>{{ $result['repetition'] }}</td>
                                    <td><span class="badge badge-secondary" style="font-size: 12px;padding:5px;">{{ number_format($result['quantity'], 2) }}</span></td>
                                    <td><span class="badge badge-secondary" style="font-size: 12px;padding:5px;">{{ number_format($result['price'], 2) }}</span></td>
                                    <td><span class="badge badge-primary" style="font-size: 12px;padding:5px;">{{ number_format($result['total'], 2) }}</span></td>
                                    <td>{{ $result['invoice_id'] }}</td>
                                    <td>{{ $result['customer_name'] }}</td>
                                    <td>{{ $result['branch'] }}</td>
                                    <td>{{ $result['date'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-align-center">لا توجد نتائج مطابقة للبحث</div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('page_scripts')
<script type="text/javascript" src="{{ asset('datatables_js/xlsx.full.min.js') }}"></script>
<script>
function ExportToExcel(type) {
    if (typeof XLSX === 'undefined') return console.error('XLSX library missing');
    const table = document.getElementById('tab');
    if (!table) return console.error('Table #tab not found');

    let data = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(table), { header: 1 });
    if (data.length && String(data[0][0]).includes("تقرير الخدمات المباعة")) data[0] = ["تقرير الخدمات المباعة"];
    else data.unshift(["تقرير الخدمات المباعة"]);

    const sheet = XLSX.utils.aoa_to_sheet(data);
    const range = XLSX.utils.decode_range(sheet['!ref']), colIndex = 9;
    for (let r = range.s.r; r <= range.e.r; r++) {
        const ref = XLSX.utils.encode_cell({ c: colIndex, r }), cell = sheet[ref];
        if (!cell || !cell.v) continue;
        let d = null;
        if (typeof cell.v === 'number') {
            if (cell.v > 59 && cell.v < 2958465) d = cell.v;
            else if (cell.v > 1e10) d = excelSerial(new Date(cell.v));
            else if (cell.v > 1e9) d = excelSerial(new Date(cell.v * 1000));
        } else {
            let s = String(cell.v).trim().replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => '٠١٢٣٤٥٦٧٨٩'.indexOf(x));
            let m;
            if (m = s.match(/^(\d{4})-(\d{1,2})-(\d{1,2})/)) d = excelSerial(new Date(m[1], m[2]-1, m[3]));
            else if (m = s.match(/^(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})/)) d = excelSerial(new Date(m[3], m[2]-1, m[1]));
        }
        if (d) { cell.t = 'n'; cell.v = d; cell.z = "dd/mm/yyyy"; }
    }

    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, sheet, "Service Report");
    XLSX.writeFile(wb, `service_prices_report.${type}`);
}

const excelSerial = d => (Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()) - Date.UTC(1899, 11, 30)) / 86400000;
</script>
@endpush


<script>
  function printFullReport() {
    const reportSection = document.querySelector('.card-body');
    const table = document.getElementById('tab');
    
    // Clone the table for printing
    const clonedTable = table.cloneNode(true);
    
    // Apply print-specific styles to badges in the cloned table
    const badges = clonedTable.querySelectorAll('span.badge');
    badges.forEach(badge => {
        badge.style.display = 'inline-block';
        badge.style.padding = '3px 6px';
        badge.style.borderRadius = '10px';
        badge.style.fontSize = '12px';
        badge.style.color = '#fff';
        badge.style.backgroundColor = badge.classList.contains('badge-primary') ? '#007bff' : '#6c757d';
    });
    
    // Open print window
    const printWindow = window.open('', '_blank');
    
    // Prepare print content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>تقرير الخدمات المباعة</title>
            <style>
                @page {
                    size: A4;
                    margin: 5mm;
                }
                body {
                    font-family: Arial, sans-serif;
                    -webkit-print-color-adjust: exact !important;
                    color-adjust: exact !important;
                    background: white;
                    margin: 5px;
                    padding: 0;
                    text-align: center;
                }
                h2 {
                    margin: 10px 0;
                    font-size: 20px;
                }
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    page-break-inside: auto;
                    margin: 0 auto;
                }
                .table thead {
                    display: table-header-group;
                    background-color: #f8f9fa !important;
                }
                .table tbody tr:nth-child(odd) {
                    background-color: #f8f9fa !important;
                }
                .table th, .table td {
                    border: 1px solid #dee2e6;
                    padding: 8px;
                    text-align: center;
                    font-size: 12px;
                }
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                .total-row {
                    font-weight: bold;
                    background-color: #e2e3e5 !important;
                }
                .badge {
                    display: inline-block;
                    padding: 3px 6px;
                    border-radius: 10px;
                    font-size: 12px;
                    color: #fff !important;
                }
                .badge-secondary {
                    background-color: #6c757d !important;
                }
                .badge-primary {
                    background-color: #007bff !important;
                }
                .total-badge {
                    font-size: 14px;
                    padding: 5px 10px;
                    background-color: #6c757d !important;
                    color: white !important;
                }
            </style>
        </head>
        <body>
            <h2>تقرير الخدمات المباعة</h2>
            ${clonedTable.outerHTML}
            <script>
                // Add page numbers after content is loaded
                window.onload = function() {
                    const totalPages = Math.ceil(document.body.scrollHeight / 1123); // A4 height in pixels
                    const footer = document.createElement('div');
                    footer.style.textAlign = 'center';
                    footer.style.marginTop = '20px';
                    footer.style.fontSize = '12px';
                    footer.innerHTML = 'الصفحة 1 من ' + totalPages;
                    document.body.appendChild(footer);
                };
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
    
    printWindow.onload = function () {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}
    </script>
    




 