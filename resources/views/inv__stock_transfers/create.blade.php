@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('انشاء اذن تحويل بضاعه')}}
@endsection

<style>
    .swal2-error{
        display: block !important;
    }
    .swal2-icon.swal2-error [class^='swal2-x-mark-line'][class$='left']{
        left: -3.9375em !important;
    }
</style>

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1><i></i>
            <i class="fas fa-exchange-alt"></i>
            انشاء اذن تحويل بضاعه
        </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'invStockTransfers.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('inv__stock_transfers.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('invStockTransfers.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script src="{{URL('js/sweetalert2@11.js')}}" ></script>
<script src="{{ asset('js/views_js/inv_stock_transfers.js') }}"></script>
