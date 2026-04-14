@extends('layouts.app')

@push('page_css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/datatables_colors.css') }}">
@endpush

@section('title')
    {{__('اكواد الالوان')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-link heart-beat"></i>
            اكواد الالوان
        </h1>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                @include('color_codes.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


