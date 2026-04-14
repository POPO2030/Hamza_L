@extends('layouts.app')
@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
@endpush

@section('title')
    {{__('تعديل الخزينه')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل الخزينه</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($treasury, ['route' => ['treasuries.update', $treasury->id], 'method' => 'patch']) !!}

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
