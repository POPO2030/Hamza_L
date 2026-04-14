@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

<style>
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
        #reporttitle {
            display: none;
        }
        #head{
        background-color: #fdfdfd !important; 
        font-weight: bold;
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
 
    }
</style>

@section('title')
    {{__('عرض كارته صنف المنتج')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height"></i>
            عرض كارته صنف المنتج
            </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-md float-left"
           href="{{ route('product_report') }}">
            رجوع
        </a>
        <button class="btn btn-primary btn-md float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
            <i class="fas fa-print"></i> تصدير الى الاكسيل 
          </button>
          <button class="btn btn-primary btn-md float-left" onclick="window.print()" style="margin-left: 10px;"> 
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
                <div class="col-sm-12 printable p-10" id="title">
                    <p>عرض كارته صنف المنتج</p>
                </div>

                <div  style="max-height: calc(80vh - 150px); overflow-y: auto;">
                <table class="table table-border" id="tab">
                    <tr>
                        <th colspan="6" class="card-footer text-center" id="reporttitle">
                            عرض كارته صنف المنتج</th>
                    </tr>
                    <tr class="table-active">
                    <th>الصنف</th>
                    <th>بيان</th>
                    <th>المورد</th>
                    <th>وارد</th>
                    <th>منصرف</th>
                    <th>رقم العملية</th>
                    <th>التاريخ</th>
                    <th>المخزن</th>
                    </tr>
                    @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->get_product->name}}</td>

                        <td>
                            @if($stock->flag=='1')
                            {{'اذن اضافة'}}
                            @elseif($stock->flag=='2')
                            {{'اذن صرف'}}
                            @endif
                        </td>
                        <td>
                            @if($stock->supplier_id != 0)
                            {{$stock->get_supplier->name}}
                            @endif
                        </td>
                        @if($stock->quantity_in==0)
                        <td>0</td>
                        @else
                        <td>{{$stock->quantity_in}} {{$stock->get_unit->name}}</td>
                        @endif

                        @if($stock->quantity_out==0)
                        <td>0</td>
                        @else
                        <td>{{$stock->quantity_out}} {{$stock->get_unit->name}}</td>
                        @endif
                        <td>{{$stock->inv_stockinout_id}}</td>
                        <td>{{$stock->created_at}}</td>
                        <td>
                            {{$stock->get_store->name}}
                        </td>
                    </tr>
                    @endforeach 
                </table>
                </div>
                <div class="card-footer text-center">
                    @if($isdate!=1)
                          <div class="col-sm-12">
                            <h6>اجمالي الرصيد  : 
                                <span class="badge badge-info" style="font-size: 14px">{{ $large_netQuantity }}</span>
                                <span>{{$largename}}</span>
                                <span class="badge badge-info" style="font-size: 14px">{{ $small_netQuantity }}</span>
                                <span> و {{$smallname}}</span>
                               
                            </h6>
                                </div>
                                @endif
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

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
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>