@extends('layouts.app')

@section('title')
    {{__('تفاصيل مصدر القماش')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-stamp"></i> تفاصيل مصدر القماش</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left"
                       href="{{ route('fabricSources.index') }}">
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
                    @include('fabric_sources.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
