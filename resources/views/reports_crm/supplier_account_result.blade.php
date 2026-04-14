@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    td , tr{
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
       #reporttitle {
            display: none;
        }
    @media print {
        @page {
        size: A4;
        margin: 10 !important;
        padding: 5 !important;
    }

        .header, .main-footer, .mb-2{
            display: none;
        }
        .content-wrapper{
        margin: 0 !important;
        background-color: white !important;
        transform: scale(0.81); /* 81% scaling */
        transform-origin: top right; 
         }
       .main-sidebar{
        display: none !important;
        }

        .content{
            background-color: white !important;
        }
      
        .col-sm-12.printable.p-10{
            padding: 5 !important;
            display: block;
            font-size: 24px;
            font-weight: bolder;
        }
        #reporttitle {
            display: none;
        }
        #tab1 {
            max-height: none !important;
            overflow-y: visible !important;
        }
        .hide_column{
            display: none;
        }
 
    }
</style>
@endpush

@section('title')
{{ __('عرض  حساب المورد') }}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
          عرض  حساب المورد
          <span class="badge badge-info" style="font-size: 20px"> {{$supplier_name->name}} </span> 
        </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('supplier_account_report') }}">
            رجوع
        </a>
        <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
            <i class="fas fa-print"></i> تصدير الى الاكسيل 
          </button>
          <button class="btn btn-primary btn-sm float-left" onclick="window.print()" style="margin-left: 10px;"> 
            طباعه 
        </button>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body">
                <h4 style="text-align: center">
                    رصيد دائن <span class="badge badge-info" style="font-size: 15px">{{ number_format($supplier_account_credit, 2) }} جنية</span>
                    &nbsp; &nbsp; &nbsp;
                    رصيد مدين <span class="badge badge-info" style="font-size: 15px">{{ number_format($supplier_account_debit, 2) }} جنية</span>
                    &nbsp; &nbsp; &nbsp;
                    @if (number_format($supplier_credit_debit, 2) > 0 )
                    اجمالي دائن <span class="badge badge-warning" style="font-size: 20px ">{{ number_format(abs($supplier_credit_debit), 2) }} جنية</span>
                    @else
                    اجمالي مدين <span class="badge badge-warning" style="font-size: 20px ">{{ number_format(abs($supplier_credit_debit), 2) }} جنية</span>
                    @endif
                </h4>
                
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div id="tab1" style="max-height: calc(80vh - 150px); overflow-y: auto;">
                    <table class="table table-border" id="tab">
                        <tr>
                            <th colspan="12" class="card-footer text-center" id="reporttitle">تفاصيل دفعات المورد <span class="badge badge-info" style="font-size: 15px">test</span> </th>
                        </tr>
                        <tr class="table-active" style="position: sticky;top: 0;background-color: rgb(0 0 0 / 75%);color: #fff;">
                            <th style="vertical-align: middle;">رقم</th>
                            <th style="vertical-align: middle;">دائن</th>
                            <th style="vertical-align: middle;">مدين</th>
                            <th style="vertical-align: middle;">نوع الدفع</th>
                            <th style="vertical-align: middle;">ملاحظات</th>
                            <th style="vertical-align: middle;">التاريخ</th>
                        </tr>

                    @foreach ($supplier_detail as $supplier_details)
                            <tr>
                                @if($supplier_details->treasury_details_id == 0)
                                <td> اذن الاضافه - {{ $supplier_details->invimport_id }} </td>

                                {{-- @elseif ($supplier_details->invimport_id_return != NULL)
                                <td> مرتجع رقم - {{ $supplier_details->invimport_id_return }} </td> --}}

                                @else
                                <td> اليوميه - {{ $supplier_details->get_treasury_details->treasury_journal }} </td>
                                @endif
                                <td>{{ number_format( $supplier_details->cash_balance_credit ,2)}}</td>
                                <td>{{ number_format( $supplier_details->cash_balance_debit ,2)}}</td>

                                @if($supplier_details->get_payment_type == null )
                                <td>---</td>
                                @else
                                <td>{{ $supplier_details->get_payment_type->name }}</td>
                                @endif
                                <td>{{ $supplier_details->note }}</td>
                                <td>{{ $supplier_details->created_at }}</td>
                            </tr>

                    @endforeach
                    <tr class="table-active" style="position: sticky;top: 0;background-color: rgb(0 0 0 / 75%);color: #fff;">

                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>


                    </tr>
                    </table>

            </div>
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
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>
@endpush