@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
@endpush

@section('title')
    {{__('تعديل المنتجات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-cube heart-beat"></i>
                    تعديل المنتجات
                </h1>
            </div>
          </div>
        </div>
      </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($invProduct, ['route' => ['invProducts.update', $invProduct->id], 'method' => 'patch','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">
                    @include('inv_products.fields')
                </div>
            </div>

            <div class="card-footer">

                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('invProducts.index') }}" class="btn btn-default">الغاء</a>

            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
@push('page_scripts')
{{-- <script src="{{ asset('js/views_js/image_recevie_receipts.js') }}"></script> --}}
<script src="{{ asset('js/views_js/inv_prouducts.js') }}"></script>
@endpush