@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
@endpush

@section('title')
    {{__('انشاء خزينه')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>انشاء خزينه</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'treasuries.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('treasuries.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-success btn-sm save']) !!}
                <a href="{{ route('treasuries.index') }}" class="btn btn-secondary btn-sm">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/views_js/treasuries.js') }}"></script>
