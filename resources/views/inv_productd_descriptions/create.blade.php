@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('انشاء وصف المنتجات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-info"></i>
                   انشاء وصف المنتجات
                </h1>
            </div>
          </div>
        </div>
      </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'invProductdDescriptions.store','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">

                <div class="row">
                    @include('inv_productd_descriptions.fields')
                </div>

            </div>

            <div class="card-footer">
              {!! Form::submit('حفظ', ['class' => 'btn btn-success btn-sm save']) !!}
                <a href="{{ route('invProductdDescriptions.index') }}" class="btn btn-secondary btn-sm">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/views_js/Inv_productd_description.js') }}"></script>
