@extends('layouts.app')

@section('title')
    {{__('تأكيد طلب الحجز')}}
@endsection

@push('third_party_stylesheets')
 <style>
  input[type="text"],
  input[type="number"],
  input[type="file"],
  input[type="date"],
  select {
    height: 38px;
    font-size: medium;
  }
 </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-check-circle"></i> تاكيد طلب الحجز</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($reservation, ['route' => ['workOrders.store'], 'method' => 'post','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                @include('reservations.show_fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('تاكيد', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('reservations.index') }}" class="btn btn-default">إلغاء</a>
            </div>
            <div class="col"></div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>

    <script>
        var auth = {!! json_encode(Auth::user()) !!};
      </script>
      {{-- form validate --}}
      <script src="{{ asset('js/views_js/confirm_reservation_validate.js') }}"></script>
