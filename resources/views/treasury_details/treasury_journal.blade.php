@extends('layouts.app')

@section('title')
    {{__('يومية الخزينة')}}
@endsection

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
    </style>
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
      {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
      {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-duallistbox.css')}}"> --}}
      {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
      {{-- <script  src="{{asset('js/jquery.bootstrap-duallistbox.js')}}"></script> --}}
    
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12" style="text-align: center">
                    <h1 style="font-weight: bold;">يوميه الخزينة </h1>
                    <h3 style="font-family: 'Cairo', sans-serif;color: #3f3f3f"> تاريخ اليوم : {{ date('Y-m-d ') }} ( {{ $arabicDayNames[date("l", strtotime(" today"))] }} )</h4>
                </div>
            </div>
        </div>
        <br>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'treasuryDetails.store','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">

<div style="text-align: left">
    <a href="{{ route('treasuryDetails.index') }}" class="btn btn-primary">جميع اليوميات</a>
    <a href="{{ route('under_collection') }}" class="btn btn-primary">اوراق تحت التحصيل</a>
</div>

                <div class="row">
                    <div class="row">
                        @include('treasury_details.fields')
                    </div>
                </div>
                    <div class="card-footer">
                        {!! Form::submit('حفظ', ['class' => 'btn btn-success btn-sm save']) !!}
                    </div>
                <br>
                    <div style="margin-right: 7%;margin-left: 7%;">
                    <table>
                        <tr>
                          <th>دائن</th>
                          <th>مدين</th>
                          <th>تفاصيل</th>
                        </tr>
                        @foreach ($journal as $journals)
                        @if ($journals->payment_type_id == 2)
                        <tr>
                          <td>{{number_format( $journals->credit , 2) }}</td>
                          <td>{{number_format( $journals->debit ,2)}}</td>
                          <td>{{ $journals->details }}</td>
                        </tr>
                        @endif 
                        @endforeach
                        <tr>
                            <th> اجمالي دائن نقدى<span class="badge badge-info" style="font-size: 14px">{{number_format(  $credit_total_cash, 2) }}</span></th>
                            <th>اجمالي مدين نقدى<span class="badge badge-info" style="font-size: 14px">{{number_format( $debit_total_cash, 2) }}</span></th>
                            <th>صافى النقدية <span class="badge badge-info" style="font-size: 14px"> {{number_format( $result_cash , 2) }}</span></th>
                          </tr>
                      </table>

                    </div>

                </div>

            </div>

        {{-- ---------------------------------- حسابات البنوك-----------------------------------  --}}
        <div class="accordion col-sm-12" id="accordionExample">
            <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h3 > <i class="fas fa-file-invoice-dollar" style="color: gray"></i>  تفاصيل ارصدة حسابات البنوك    </h3>
                </button>
                </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">

        <div class="card-footer" style="text-align: center">
            @foreach ($banks as $bank)
           
            {{-- <span class="badge badge-secondary" style="font-size: 20px">  --}}
        {{-- <a href="{{ route('Bankpayment', $banks->get_payment_type->id) }}" style="color: #dddddd">{{ $banks->get_payment_type->name}}  </span>   --}}
            <span class="badge badge-info" style="font-size: 20px" dir="ltr"> {{ $bank->name}} ({{ $bank->amount}}) </span>  
        {{-- </a> --}}
            &nbsp; &nbsp;
            @endforeach
        </div>

        </div>
        </div>
        </div>
        {{-- ------------------End حسابات البنوك End--------------------------- --}}

            {!! Form::close() !!}

        </div>
    </div>
@endsection



@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_checks.js') }}"></script>
{{-- form validate --}}
{{-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> --}}
<script src="{{ asset('js/views_js/treasury_details.js') }}"></script>



@endpush