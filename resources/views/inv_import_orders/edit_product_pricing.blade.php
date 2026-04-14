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

</style>
@endpush

@section('title')
    {{__('تسعير استلام بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-clipboard-check heart-beat"></i>
                    تسعير استلام بضاعه
        </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary btn-sm float-left"
                       href="{{ route('invImportOrders.index') }}">
                        عوده
                    </a>
                    {{-- <button class="btn btn-primary btn-sm float-left" onclick="window.print()" style="margin-left: 10px;"> طباعه </button> --}}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            {!! Form::model($invImportOrder, ['route' => ['invImportOrders.update_product_pricing', $invImportOrder->id], 'method' => 'patch','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('inv_import_orders.fields_product_pricing')
                </div>
                <div class="card-footer">
                    {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                    <a href="{{ route('invImportOrders.index') }}" class="btn btn-default ">الغاء</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_product_pricing.js') }}"></script>

@endpush