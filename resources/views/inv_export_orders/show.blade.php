@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
 
<style>
    .col-sm-12.printable.p-10{
    padding: 5 !important;
    text-align: center;
    display: none;
}
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

    /* Hide non-printable elements */
    .non-printable {
        display: none !important;
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

}

</style>
@endpush

@section('title')
    {{__('تفاصيل اذن صرف بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-dolly-flatbed heart-beat"></i>
                 تفاصيل اذن صرف بضاعه
                </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left btn-sm"
                       href="{{ route('invExportOrders.index') }}">
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
                    @include('inv_export_orders.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
