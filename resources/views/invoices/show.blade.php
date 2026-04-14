@extends('layouts.app')

@section('title')
    {{__('طباعة الفاتورة')}}
@endsection

<style>
           .header-box {
                    border: 1px solid #ddd;
                    background-color: #e0e4e7;
                    color: #504f4f;
                    font-weight: bold;
                    padding: 5px;
                    text-align: center;
                    margin-bottom: 5px;
                    border-radius: 8px; /* ✅ Rounded corners */
                }

                .info-row {
                    display: flex;
                    flex-wrap: nowrap;
                    margin-bottom: 10px;
                    gap: 10px;
                }

                .info-item {
                    flex: 0 0 32%;
                    min-width: 120px;
                }

                    .info-item2 {
                    flex: 0 0 19%;
                    min-width: 120px;
                }

                .info-label {
                    font-weight: bold;
                    font-size: 13pt;
                    margin-bottom: 3px;
                }
                .info-label2 {
                    font-weight: bold;
                    font-size: 13pt;
                    margin-bottom: 3px;
                }
    /* Print-specific styles */
    @media print {
        @page {
            size: A5 landscape;
            margin: 0;
        }
        body {
            width: 100%;
            margin: 0;
            padding: 5mm;
            font-size: 10pt;
            background: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body * {
            visibility: visible;
        }
        .no-print, .card-header, .card-footer, .content-header {
            display: none !important;
        }
        #printed_area {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        th, td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }
    }
    
    /* Screen styles */
    #printed_area {
        direction: rtl;
        padding: 15px;
    }
    .header-box {
        border: 1px solid #ddd;
        background-color: #e0e4e7;
        color: #504f4f;
        font-weight: bold;
        padding: 5px;
        text-align: center;
        margin-bottom: 5px;
    }
    .info-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 5px;
    }
    .info-item {
        flex: 1;
        min-width: 120px;
        margin: 2px;
    }
</style>

@section('content')
    <section class="content-header no-print">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>طباعة الفاتورة</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('invoices.index') }}">
                        عودة
                    </a>
                    <button class="btn btn-primary float-left" onclick="printInvoice()">طباعه</button>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                @include('invoices.show_fields')
            </div>
        </div>
    </div>
@endsection

<script>
    function printInvoice() {
        // Create a hidden iframe
        const iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.width = '148mm'; // A5 width
        iframe.style.height = '210mm'; // A5 height
        iframe.style.left = '-10000px';
        iframe.style.top = '0';
        iframe.style.visibility = 'hidden';
        
        document.body.appendChild(iframe);
        
        // Get the content to print
        const printContent = document.getElementById('printed_area').innerHTML;
        
        // Write the content to the iframe with print-specific styles
        iframe.contentDocument.open();
        iframe.contentDocument.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>طباعة الفاتورة</title>
                <style>
                    @page {
                        size: A5 landscape;
                        margin: 5mm 0 0 0; /* 10mm top margin on ALL pages */
                    }
                    body {
                        margin: 0;
                        padding: 5mm;
                        font-size: 10pt;
                        direction: rtl;
                        background: white;
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 8pt;
                        page-break-inside: auto;
                    }
                    tr {
                        page-break-inside: avoid;
                    }
                    th, td {
                        border: 1px solid black;
                        padding: 2px;
                        text-align: center;
                    }
                    .header-box {
                        border: 1px solid #ddd;
                        background-color: #e0e4e7;
                        color: #504f4f;
                        font-weight: bold;
                        padding: 5px;
                        text-align: center;
                        margin-bottom: 5px;
                        border-radius: 8px; 
                    }
                    .info-row {
                        display: flex;
                        flex-wrap: nowrap;
                        margin-bottom: 10px;
                        gap: 10px;
                    }
                    .info-item {
                        flex: 0 0 32%;
                        min-width: 120px;
                    }
                    .info-item2 {
                        flex: 0 0 19%;
                        min-width: 120px;
                    }
                    .info-label {
                        font-weight: bolder;
                        font-size: 9pt;
                        margin-bottom: 3px;
                    }
                    /* Badge styles */
                    .badge {
                        display: inline-block;
                        padding: 2px 5px;
                        font-size: 85%;
                        font-weight: bold;
                        line-height: 1;
                        text-align: center;
                        white-space: nowrap;
                        vertical-align: baseline;
                        border-radius: 3px;
                        margin: 1px;
                    }
                    .badge-secondary {
                        color: #fff;
                        background-color: #6c757d;
                        border: 1px solid #5a6268;
                    }
                    .badge-info {
                        color: #fff;
                        background-color: #17a2b8;
                        border: 1px solid #117a8b;
                    }
                    .border-lightgray {
                        border-color: #d3d3d3 !important;
                    }
                </style>
            </head>
            <body>
                ${printContent}
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                            setTimeout(function() {
                                document.body.removeChild(document.querySelector('iframe'));
                            }, 100);
                        }, 200);
                    };
                <\/script>
            </body>
            </html>
        `);
        iframe.contentDocument.close();
    }
     window.addEventListener('DOMContentLoaded', function() {
        printInvoice();
    });
</script>