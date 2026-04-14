@extends('layouts.app')

@section('title')
    {{__('تفاصيل تكلفة الغسلة')}}
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل تكلفة الغسلة</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('accountingCosts.index') }}">
                        عودة
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('accounting_costs.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
