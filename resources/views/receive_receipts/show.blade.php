@extends('layouts.app')


<style>
    @page 
    { 
        size: A5 landscape !important; 
    }
    
      #table_print, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 24px;
        color:#000;
        font-weight: bold;
      }
    
      @media print {
             /* Hide everything outside the .card div */
        body * {
            visibility: hidden;
            margin: 0 !important; 
        }

        /* Only make .card div and its contents visible */
        .card, .card * {
            visibility: visible;
        }

        /* Ensure only .card div is printed */
        .card {
            position: absolute;
            left: 50px;
            top: -20px;
            width: 100%;
            zoom: 0.95 !important; 
            background-color: #fff !important; 
        }
        .header, .footer, .mb-2,.content-header,.fixed-plugin {
          display: none;
        }
    
        #hide_tr {
          display: none;
        }
    
        #table_print {
          width: 794px;
          height: 400px;
          font-size: 24px;
        }
    
        #table_print th,
        #table_print td {
          border: 1px solid #000;
          padding: 5px;
        }
    
        #noteprint {
          text-align: center;
          justify-content: center;
          word-wrap: normal;
          float: right;
          width: auto !important; 
        }
      }
    </style>

@section('title')
    {{__('طباعة اذن الاضافة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-receipt"></i> طباعه اذن الاضافة </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary" style="float: left"
                       href="{{ route('receiveReceipts.index') }}">
                        رجوع
                    </a>
                    
                    <button  class="btn btn-primary float-left" onclick="window.print()" style="margin-left: 10px;">  طباعه </button> 
                    
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('receive_receipts.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
