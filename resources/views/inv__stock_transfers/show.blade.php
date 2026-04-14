@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('انشاء اذن تحويل بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-exchange-alt"></i>
            تفاصيل اذن التحويل
          </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left"
                       href="{{ route('invStockTransfers.index') }}">
                        عوده
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('inv__stock_transfers.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
