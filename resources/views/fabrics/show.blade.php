@extends('layouts.app')

@section('title')
    {{__('تفاصيل القماشة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-tape"></i> تفاصيل القماشة</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left"
                       href="{{ route('fabrics.index') }}">
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
                    @include('fabrics.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
