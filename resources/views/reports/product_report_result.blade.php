@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

<style>
        .badge-info {
      background-color: #17a2b8!important;
    }
    
    .badge-warning {
      background-color: #ffc107!important;
    }
    .badge-danger {
      background-color: #dc3545!important;
    }
    .badge-success {
      background-color: #28a745!important;
    }
    .badge-info, .bg-info>a {
  color: #fff!important;
}

  .badge-warning, .bg-warning>a {
  color: #000!important;
}
  .badge-danger, .bg-danger>a {
  color: #fff!important;
}
  .badge-success, .bg-success>a {
  color: #fff!important;
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
        #reporttitle {
            display: none;
        }
        #head{
        background-color: #fdfdfd !important; 
        font-weight: bold;
       }
    /* @media print {
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
 
    } */
    @media print {
    @page {
        size: A4 !important;
        margin: 0 !important; 
    }
    body {
        background-color: white !important;
    }
    body * {
        visibility: hidden !important;
    }

    .content.px-3 {
        visibility: visible !important;
    }


    .content.px-3 * {
        visibility: visible !important;
    }

    /* Display .content.px-3 in full, and adjust layout for printing */
    .content.px-3 {
        position: absolute;
        top: 0;
        left: 20% !important;
        /* right: -100% !important; */
        width: 80% !important;
        margin: 0 !important;
        background-color: white !important;
        padding: 5px !important;
    }
    /* Hide header, footer, sidebar, etc. */
    .header, .main-footer, .footer, .sidebar, .fixed-plugin, .navbar {
        display: none !important;
    }

.col-sm-12.printable.p-10{
    padding: 5 !important;
    display: block;
    font-size: 24px;
    font-weight: bolder;
    margin-bottom: 10px;
}

      /* Add this to make background graphics visible */
      * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
        }

}
</style>
@endpush

@section('title')
    {{__('تقرير كارت الصنف ')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
            تقرير كارت الصنف 
            </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('product_report') }}">
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
                <div class="col-sm-12 printable p-10" id="title">
                    <p>تقرير كارت الصنف </p>
                </div>

                <div  style="max-height: calc(80vh - 150px); overflow-y: auto;">
                <table class="table table-border" id="tab">
                    <thead>
                    <tr>
                        <th colspan="6" class="card-footer text-center" id="reporttitle">
                            تقرير كارت الصنف </th>
                    </tr>
                    @if(!empty($request->from) && !empty($request->to))
                    <tr>
                        <td colspan="11" class="text-center">
                            <span class="badge badge-primary rounded" style="font-size: 18px; border: none;">
                                من : {{ $request->from }}
                                </span>
    
                            <span class="badge badge-primary rounded" style="font-size: 18px; border: none;">
                                الى : {{ $request->to}}
                            </span>
                        </td>
                    </tr>                   
                    @endif
                    <tr class="table-active">
                    <th>الكود</th>
                    <th>الصنف</th>
                    <th>اللون</th>
                    <th>بيان</th>
                    {{-- <th>تحت اسم</th> --}}
                    <th>المورد</th>
                    <th>وارد</th>
                    <th>منصرف</th>
                    <th>رقم الاذن</th>
                    <th>الغسلة</th>
                    <th>التاريخ</th>
                    <th>المخزن</th>
                    </tr>
                    </thead>
                    {{-- المنتجات --}}
                    @if(isset($stocks))
                    @foreach($stocks as $stock)
                    <tr>
                        <td>
                            {{$stock->get_product_color->get_product->manual_code}}
                        </td>
                        <td>
                            {{$stock->get_product_color->get_product->name}}
                        </td>

                        <td>
                            @if($stock->get_product_color->color_id == 1)
                            {{$stock->get_product_color->get_color->invcolor_category->name}}
                                @else
                            {{-- {{$stock->get_product_color->get_color->invcolor_category->name}} - {{$stock->get_product_color->get_color->get_color_code->name}} --}}
                            {{$stock->get_product_color->get_color->invcolor_category->name}}
                            @endif
                        </td>

                        <td>
                            @if($stock->flag=='1')
                            <span class="badge badge-success"> {{'اذن اضافة'}} </span>
                            @elseif($stock->flag=='2')
                            <span class="badge badge-danger"> {{'اذن صرف'}} </span>
                            @elseif($stock->flag=='3')
                            <span class="badge badge-info"> {{'مرتجع'}} </span>
                            @elseif($stock->flag=='4')
                            <span class="badge badge-warning"> {{'اذن تحويل'}} </span>
                            @elseif($stock->flag=='5')
                            <span class="badge badge-primary"> {{'رصيد اول المدة'}} </span>
                            @endif
                        </td>
                        {{-- <td>
                            {{$stock->get_customer->name}}
                        </td> --}}
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
                        <td>{{$stock->invimport_export_id}}</td>

                        <td>
                        @if($stock->flag=='2')
                        <span class="badge badge-info" style="font-size: 14px">{{$stock->work_order_id}}
                            @else
                        ---
                        @endif
                        </td>

                        <td>{{$stock->created_at}}</td>
                        <td>
                            {{$stock->get_store->name}}
                        </td>
                    </tr>
                    @endforeach 
                    @endif
                </table>
                </div>
                <div class="card-footer text-center">
                          <div class="col-sm-12">
                            <h6>اجمالي الرصيد : 
                                <span class="badge badge-info" style="font-size: 14px">

                            @if (isset($largename) && isset($smallname))
                                {{ $large_netQuantity }}{{$largename}}  , {{$small_netQuantity}}{{$smallname}}   
                            @elseif (isset($largename) && !isset($smallname))
                                {{ $large_netQuantity }}{{$largename}}
                            @elseif (!isset($largename) && isset($smallname)) 
                                {{$small_netQuantity}}{{$smallname}}   
                            @endif  

                        </span>
                            </h6>
                                </div>
                    <div class="float-right">
                        
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