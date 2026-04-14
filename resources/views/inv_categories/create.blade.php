@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('انشاء مجموعه منتجات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-list-alt heart-beat"></i>
            انشاء مجموعه منتجات
                </h1>
            </div>
          </div>
        </div>
      </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'invCategories.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('inv_categories.fields')
                </div>

            </div>

            <div class="card-footer">

                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('invCategories.index') }}" class="btn btn-default">الغاء</a>

            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/views_js/inv_category.js') }}"></script>