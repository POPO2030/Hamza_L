@extends('layouts.app')

@section('title')
    {{__('طباعة إذن استلام مرتجع')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-receipt"></i> طباعه إذن استلام مرتجع </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" style="float: left"
                       href="{{ route('returnReceipts.index') }}">
                        رجوع
                    </a>
                    
                    <button  class="btn btn-primary float-left" onclick="window.print()" style="margin-left: 10px;">  طباعه </button> 
                    
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('return_receipts.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
