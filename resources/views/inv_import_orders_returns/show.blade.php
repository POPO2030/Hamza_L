@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

<style>
    @page {
       /* size: A5 landscape; */
       margin: 10 !important; 
   }

   .col-sm-12.printable.p-10{
            padding: 5 !important;
            display: none;
            font-size: 24px;
            font-weight: bolder;
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

}

</style>
@endpush

@section('title')
    {{__('تفاصيل اذن مرتجع')}}
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <i class="fas fa-clipboard-check"></i>
                       تفاصيل اذن مرتجع 
            </h1>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-primary btn-sm float-left"
                           href="{{ route('invImportOrders.index') }}">
                            عوده
                        </a>
                        <button class="btn btn-primary btn-sm float-left" onclick="window.print()" style="margin-left: 10px;"> طباعه </button>
                    </div>
                </div>
            </div>
        </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('inv_import_orders_returns.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
