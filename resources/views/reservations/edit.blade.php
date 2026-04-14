@extends('layouts.app')

@section('title')
    {{__('تعديل حجز الغسلة')}}
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
  #copy-button {
      display: none;
    }
    .btn {
    margin: 0 !important;
  }
 </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-check-circle"></i> تعديل حجز الغسلة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($reservation, ['route' => ['reservations.update', $reservation->id], 'method' => 'patch','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('reservations.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('reservations.index') }}" class="btn btn-default">الغاء</a>
            </div>
            <div class="col"></div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('js/views_js/reservations_validate.js') }}"></script>