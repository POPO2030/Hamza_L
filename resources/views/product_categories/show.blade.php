@extends('layouts.app')

@section('title')
    {{__('تفاصيل مجموعات الاصناف')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-sitemap"></i> تفاصيل مجموعات الاصناف</h1>
                </div>

            <div class="col-sm-6">
                <a class="btn btn-primary" style="float: inline-end"
                   href="{{ route('productCategories.index') }}">
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
                    @include('product_categories.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
