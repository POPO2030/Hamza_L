
@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    img {
        max-width: 100%;
        max-height: 100%;
        display: block;
        margin: 0 auto; 
    }
</style>

@section('title')
    {{__('كارته صنف المنتجات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-text-height"></i>
            كارته صنف المنتجات
        </h1>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">

            <form action="{{URL('product_report_result')}}" method="post" id="create">
            @csrf
            <div class="row">
            <div class="form-group col-sm-6">
            {!! Form::label('product_id', 'المنتج:') !!}
            <div id="product_id-container">
            <select name="product_id" id="product_id" class='form-control searchable' >
                <option value="">اختار المنتج</option>
            @foreach($products as $product)
                <option value="{{$product->id}}">
                    {{$product->name}}
                </option>
                @endforeach
            </select>
            </div>
            <span id="product_id-error" class="error-message" style="color: red"></span>
            </div>
            <div class="form-group col-sm-6">
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control searchable ','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
                <span id="from-error" class="error-message" style="color: red"></span>
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control searchable ','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
                <span id="to-error" class="error-message" style="color: red"></span>
            </div>
              

            <div class="form-group col-sm-6">
            <button class="btn btn-primary save" type="submit">بحث</button>
            </div>
        </form>
            </div>


        </div>
            </div>
 
            <div>
                <div>
                    <img src="{{ asset('images/product_report.jpg') }}">
                </div>                    
            </div>


@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/views_js/product_report.js') }}"></script>