@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      text-align: center;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
      text-align: center;
    }
    
    tr:nth-child(even) {
      background-color: #dddddd;
    }

    .col-sm-12.printable.p-10{
            padding: 5 !important;
            text-align: center;
            display: none;
        }
    @media print {
        @page {
        size: A4;
        margin: 10 !important;
        padding: 5 !important;
    }

        .header, .main-footer, .mb-2{
            display: none;
        }
        .content-wrapper{
        margin: 0 !important;
        background-color: white !important;
        transform: scale(0.81); /* 81% scaling */
        transform-origin: top right; 
         }
       .main-sidebar{
        display: none !important;
        }

        .content{
            background-color: white !important;
        }
      
        .col-sm-12.printable.p-10{
            padding: 5 !important;
            display: block;
            font-size: 24px;
            font-weight: bolder;
        }
        #reporttitle {
            display: none;
        }
        #tab1 {
            max-height: none !important;
            overflow-y: visible !important;
        }
        .hide_column{
            display: none;
        }
    }
    </style>
    @endpush

    <?php
    // Array to map English day names to Arabic equivalents
    $arabicDayNames = array(
        "Saturday" => "السبت",
        "Sunday" => "الأحد",
        "Monday" => "الاثنين",
        "Tuesday" => "الثلاثاء",
        "Wednesday" => "الأربعاء",
        "Thursday" => "الخميس",
        "Friday" => "الجمعة"
    );
    ?>
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2" style="text-align: right">
                    <h1 style="font-weight: bold;">يوميه الخزينة </h1>
                </div>
                <div class="col-sm-6" style="text-align: right">
                    <h3 style="font-family: 'Cairo', sans-serif;color: #3f3f3f"> من :  {{$date_from}}  الي : {{$date_to}}</h4>
                        
                </div>
                <div class="col-sm-2" style="text-align: center">
                    <a class="btn btn-primary btn-sm float-left"
                    href="{{ route('treasuries_report') }}">
                        رجوع
                    </a>
                     <button class="btn btn-primary btn-sm float-left" onclick="window.print()" style="margin-left: 10px;"> 
                       طباعه 
                   </button>
                </div>

    
            </div>
        </div>
        <br>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'treasuryDetails.store']) !!}

            <div class="card-body">
                    <br>
                    <div style="margin-right: 7%;margin-left: 7%;">
                        @php
                        $credit_total = 0;
                        $debit_total = 0;
                        @endphp
                        
                        @php
                        $previous_date = null;
                        @endphp
                        
                        <div class="col-sm-12 printable p-10 text-center">
                            يوميه الخزينة من :  {{$date_from}}  الي : {{$date_to}}
                            <br>
                            <br>
                          </div>

                        <table>
                            <tr>
                                <th>دائن</th>
                                <th>مدين</th>
                                <th>تفاصيل</th>
                                <th>تاريخ الانشاء</th>
                            </tr>
                        
                            @foreach ($result as $journals)
                                @if ($previous_date != null && $previous_date != $journals->created_at->format('Y-m-d'))
                                    <tr>
                                        <td colspan="4">
                                            <hr style="background: black ;height: 7px">  <hr style="height: ">
                                            <tr>
                                                <th>دائن</th>
                                                <th>مدين</th>
                                                <th>تفاصيل</th>
                                                <th>تاريخ الانشاء</th>

                                            </tr>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>{{number_format( $journals->credit , 2) }}</td>
                                    <td>{{number_format( $journals->debit ,2)}}</td>
                                    <td>{{ $journals->details }}</td>
                                    <td>{{ $journals->created_at }}</td>
                                </tr>
                                @php
                                    $previous_date = $journals->created_at->format('Y-m-d');
                                    $credit_total += $journals['credit'];
                                    $debit_total += $journals['debit'];
                                    $total_credit_debit = $credit_total - $debit_total;
                                @endphp
                            @endforeach
                        
                            <tr>
                                <th> اجمالي دائن <span class="badge badge-info" style="font-size: 14px">{{number_format(  $credit_total, 2) }}</span></th>
                                <th>اجمالي مدين <span class="badge badge-info" style="font-size: 14px">{{number_format( $debit_total, 2) }}</span></th>
                                @if(isset($total_credit_debit))
                                    <th>الصافي <span class="badge badge-info" style="font-size: 14px"> {{number_format( $total_credit_debit , 2) }}</span></th>
                                @endif
                            </tr>
                        </table>                
                    
                    </div>
                </div>
            </div>
            <div class="card-footer">
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection