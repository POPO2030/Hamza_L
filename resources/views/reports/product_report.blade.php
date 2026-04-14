@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    img {
        max-width: 100%;
        max-height: 100%;
        display: block;
        margin: 0 auto; 
    }
</style>
@endpush

@section('title')
    {{__('تقرير كارت الصنف ')}}
@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
            تقرير كارت الصنف 
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

            <form action="{{URL('product_report_result')}}" method="post">
            @csrf
            <div class="row">
            <div class="form-group col-sm-6">
            {!! Form::label('product_id', 'الصنف:') !!}
            <select name="product_id" class='form-control searchable'  dir="rtl" required>
                <option value="">اختار الصنف</option>
            @foreach($products as $product)
                <option value="{{$product->id}}">

                {{ $product->get_product->manual_code }} - 
                {{ optional($product->get_product)->name ? $product->get_product->name  : '' }}
                @if($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id !=1)
                 ({{ $product->get_color->invcolor_category->name }} - {{ $product->get_color->get_color_code->name }} )
                @elseif($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id ==1)
                 ({{ $product->get_color->invcolor_category->name }})
                 @elseif($product->get_color->colorCategory_id ==1 && $product->get_color->color_code_id !=1)
                 ({{ $product->get_color->get_color_code->name }} )
                @endif

                </option>
                @endforeach
            </select>
            </div>

            <div class="form-group col-sm-6">
                {!! Form::label('store_id', 'المخزن :') !!}
                <select name="store_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($inv_stores as $inv_store)
                        <option value="{{$inv_store->id}}">{{$inv_store->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-6">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>       
                <div class="form-group col-sm-4 text-center" style="margin-top:30px;">
                    <input type="submit" value="بحث" class="btn btn-primary col-12">
                </div>
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
        </div>

    </div>

@endsection
