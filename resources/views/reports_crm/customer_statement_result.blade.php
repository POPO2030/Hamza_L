@extends('layouts.app')

@push('page_css')
<style>
        .hover-image {
            width: 50px;
            height: 50px;
            position: relative;
        }

        .clone-image {
            display: none;
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px solid #ccc;
            background-color: #f9f9f9;
            z-index: 999;
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
       #reporttitle {
            display: none;
        }
        tr,th,td{
            text-align: center;
        }

       @media print {
        @page {
            size: A4;
            /* margin: 10 !important; */
            /* padding: 5 !important; */
        }

        /* .header, .main-footer, .mb-2{
            display: none;
        }
        .content-wrapper{
            margin: 0 !important;
            padding: 0 !important;
            background-color: white !important;
            width: 100% !important;
        }
       .main-sidebar{
            display: none !important;
        }
        span{
            font-size: 13px !important;
            width: 90% !important;
        }
        .content{
            background-color: white !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
      
        .col-sm-12.printable.p-10{
            padding: 5 !important;
            display: block;
            font-size: 24px;
            font-weight: bolder;
        }

        .hide_column{
            display: none;
        } */
        
        /* New styles for the title div */
        #title {
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        
        #tab {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        body, html {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endpush

@section('title')
    {{__('كشف حساب العملاء')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> كشف حساب العملاء  </h1>
                </div>

                <div class="col-sm-6">
                    <a class="btn btn-primary btn-sm float-left"
                       href="{{ route('customer_account_report') }}">
                        رجوع
                    </a>
                    <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-file-excel"></i> تصدير الى الاكسيل 
                    </button>
                    <button class="btn btn-primary btn-sm float-left" onclick="printTitleOnly()" style="margin-left: 10px;"> 
                        <i class="fas fa-print"></i>  طباعه 
                    </button>
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">
   <div id="title">
            <div class="col-sm-12 printable p-10">
                <p>كشف حساب العملاء</p>
            </div>

            <table class="table table-striped" id="tab">
                <tr id="head">
                    <th>العميل</th>
                    <th>التليفون</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>اجمالي</th>


                </tr>
                    <tbody>
                        @foreach($result as $item)
                        @if (isset($item->get_customer))
                            <tr> 	

                                <td style="font-weight: bolder;">
                                    {{$item->get_customer->name}}
                                </td>

                                <td style="font-weight: bolder;">
                                    {{$item->get_customer->phone}}
                                </td>
                      
                                <td>
                                    <span class="badge badge-secondary"  style="font-size: 13px;width: 85%">
                                        {{ number_format( $item->sum_cash_balance_debit ,2)}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary" style="font-size: 13px;width: 85%">
                                        {{ number_format( $item->sum_cash_balance_credit ,2)}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-primary" style="font-size: 13px;width: 85%">
                                        {{ number_format( $item->sum_cash_balance_debit - $item->sum_cash_balance_credit,2 )}}
                                    </span>
                                </td>
                            </tr>
                            @endif
                @endforeach
                    </tbody>
                </table>
                </div>
            </div>
                </div>      

@endsection

@push('page_scripts')
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tab');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        
        // Get today's date
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
        var year = today.getFullYear();
        
        // Format the date as YYYY-MM-DD
        var formattedDate = year + '-' + month + '-' + day;

        // Generate the filename
        var filename = 'كشف حساب العملاء.' + formattedDate + '.' + (type || 'xlsx');
        
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || filename);
    }
</script>
@endpush
<script>
function printTitleOnly() {
    var printContents = document.getElementById('title').outerHTML;
    var printWindow = window.open('', '_blank');

    printWindow.document.open();
    printWindow.document.write(`
        <html dir="rtl" lang="ar">
        <head>
            <title>كشف حساب العملاء</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    background: white;
           /* Force background colors and images when printing */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px auto;
                }
                th, td {
                    border: 1px solid #333;
                    padding: 8px;
                    font-size: 14px;
                    text-align:center
                }
                th {
                    background-color: #f0f0f0;
                }
                .printable {
                    display: block;
                    font-size: 24px;
                    font-weight: bold;
                    margin-top: 10px;
                }
                .badge {
                    padding: 4px 8px;
                    display: inline-block;
                    border-radius: 4px;
                }
                .badge-secondary {
                    background-color: #6c757d;
                    color: white;
                }
                .badge-primary {
                    background-color: #9c27b0;
                    color: white;
                }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>  
