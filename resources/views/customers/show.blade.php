@extends('layouts.app')

@section('title')
    {{__('تفاصيل بيانات العميل')}}
@endsection

{{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1><i class="fas fa-users"></i> تفاصيل بيانات العملاء</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" style="float: left"
                       href="{{ route('customers.index') }}">
                        رجوع
                    </a>
                </div>
         

            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('customers.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
