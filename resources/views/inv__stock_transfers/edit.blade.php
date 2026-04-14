@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('تعديل اذن التحويل')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1><i></i>
            <i class="fas fa-exchange-alt"></i>
                    تعديل اذن التحويل
                </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($invStockTransfer, ['route' => ['invStockTransfers.update', $invStockTransfer->id], 'method' => 'patch','id'=>'create']) !!}

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
<script src="{{ asset('js/views_js/inv_stock_transfers.js') }}"></script>