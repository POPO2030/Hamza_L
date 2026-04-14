@extends('layouts.app')

@php
    $currentStatus = request('product_category_id'); 
    $currentStageId = null;
@endphp


@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/datatables_colors.css') }}"> --}}

<style>
  .arrow-steps .clearfix {
      overflow: auto;
      white-space: nowrap;
      justify-content: center;
  }

  .step {
      display: inline-block;
      max-width: 300px;
      margin: 3px;
      text-align: center;
      vertical-align: top;
      position: relative;
      background-color: #6c757d;
      cursor: pointer;
      color: #fff;
      transition: background-color 0.2s ease;
      min-width: 99px;
      text-align: center;
  }

  .step:not(:last-child)::before {
      content: "";
      position: absolute;
      left: -10px;
      top: 0;
      border-top: 15px solid transparent;
      border-bottom: 20px solid transparent;
      border-right: 10px solid #6c757d;
  }

  .step::after {
      content: "";
      position: absolute;
      right: 0px;
      top: 0;
      border-top: 15px solid transparent;
      border-bottom: 20px solid transparent;
      border-right: 10px solid #fff; 
  }

  .nav {
      margin-top: 40px;
  }

  .pull-right {
      float: right;
  }

  a, a:active {
      color: #6c757d;
      text-decoration: none;
  }

  a:hover {
      color: #999;
  }

  .arrow-steps .step.current::before {
      /* border-right: 10px solid #17a2b8; */
      border-right: 10px solid #9c27b0;
  }

  .arrow-steps .step.current {
      /* background-color: #17a2b8; */
      background-color: #9c27b0
  }

  /* Center the modal vertically and horizontally */
  .modal.modal-top .modal-dialog {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
}

  .btn-primary[data-id] {
    height: 25px; 
}

.step_menu {
    display: inline-block;
      max-width: 300px;
      margin: 3px;
      text-align: center;
      vertical-align: top;
      position: relative;
      background-color: #666;
      cursor: pointer;
      color: #fff;
      transition: background-color 0.2s ease;
      min-width: 99px;
      text-align: center;
      
    }

    #hidden_div {
      display: none !important;
      /* clear: both;  */
    }
</style>
@endpush

@section('title')
    {{__('اذن استلام بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-clipboard-check heart-beat"></i>
             اذن استلام بضاعه
        </h1>
    </div>

    <div class="col-sm-6">
        <a class="btn btn-primary float-left btn-sm"
           href="{{ route('invImportOrders.create') }}" id="new_create" style="display:none;">
            عوده
        </a>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <div class="arrow-steps clearfix" style="text-align: center;">
                    <div class="step @if($currentStatus == null) current  @endif">
                        {!! Form::open(['route' => ['invImportOrders.index'], 'method' => 'get', 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                            {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-home" ></i> الكل</h6>', [
                               'type' => 'submit',
                               'style' => 'background-color: transparent; border: none; ',
                    
                            ]) !!}
                        {!! Form::close() !!} 
                    </div>
      
    
                    @foreach($inv_category as $category)
                    <div class="step @if($currentStatus == $category->id) current @endif">
                        {!! Form::open(['route' => ['invImportOrders.index'], 'method' => 'get', 'style' => 'text-align:center; padding-top: 4px; margin-top: 2px; margin-bottom: 0px;']) !!}
                            <input type="hidden" name="product_category_id" value="{{ $category->id }}">
                            {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-file" ></i> '. $category->name .'</h6>', [
                                'type' => 'submit',
                                'style' => 'background-color: transparent; border: none;color: #fff;',
                            ]) !!}
                        {!! Form::close() !!}
                    </div>
                @endforeach
                
                    
                 


                </div>
                @include('inv_import_orders.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
