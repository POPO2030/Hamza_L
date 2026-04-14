@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

<style>
  .fa-stack[data-count]:after{
  position:absolute;
  right:-14%;
  top:0%;
  content: attr(data-count);
  font-size:55%;
  padding:.6em;
  border-radius:999px;
  line-height:.75em;
  color: white;
  color: #DF0000;
  text-align:center;
  min-width:2em;
  font-weight:bold;
  background: white;
  border-style:solid;
}
  .fa-circle {
    color:#DF0000;
  }
  </style>

@section('title')
    {{__('الغسلات')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fab fa-first-order heart-beat"></i>
                الغسلات 
                 </h1>
                    </div>
                                        <div style=" display:inline-block;font-size:15px; padding: inherit;float:left;" >
                        <a href="{{URL('get_important')}}" style="color:black;font-weight:bold;">
                        <span class="fa-stack fa-1x has-badge" data-count= {{$important}} >
                          
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-star fa-stack-1x fa-inverse"></i>
                        </span>
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
                @include('work_orders.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

