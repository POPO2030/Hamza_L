@extends('layouts.app')

@section('title')
    {{__('طباعة اذن التغليف')}}
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1>Deliver Order Details</h1> -->
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('deliverOrders.index') }}">
                        عودة
                    </a>
                    <button  class="btn btn-primary float-right" onclick="window.print()">  طباعه </button> 
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('deliver_orders.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
