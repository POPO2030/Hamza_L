@extends('layouts.app')

@section('title')
    {{__(' الفاتورة الاصل')}}
@endsection

<style>
    @media print {
        @page {
            size: A5 landscape !important;
            /* margin: 0; */
            /* zoom: 0.40 !important; */
        }


        /* Hide non-essential elements */
        .header, 
        .footer, 
        .content-header, 
        .fixed-plugin,
        .btn {
            display: none !important;
        }

        /* Ensure content visibility */
        .card-body {
            visibility: visible;
            /* width: 100%; */
            /* height: 100%; */
            margin-top: -12%;
            margin-left: 20%;
            padding: 0;
            background-color: white !important;
            page-break-after: always;
            zoom: 0.65 !important;
        }
        .card {
            background-color: transparent !important; 
        }
        /* Adjust font sizes and spacing for A5 */
        table {
            width: 100%;
            font-size: 10pt;
            border-collapse: collapse;
        }

        td, th {
            padding: 0.75mm;
            border: 0.5pt solid #000;
        }
        
        tr {
            page-break-inside: avoid;
        }
        /* Ensure text is readable */
        * {
            /* color: black !important; */
            text-align: right;
        }

       
       
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #9c27b0">
                <div class="col-sm-6" >
                    <h1 style="color: rgb(43, 42, 42); font-weight: bold;">إدارة  فقط - الفاتورة الأصل  </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('invoices.index') }}">
                        عودة
                    </a>
                    {{-- <button  class="btn btn-primary float-left" onclick="window.print()">  طباعه </button>  --}}

                </div>
            </div>
        </div>
    </section>

    {{-- @include('flash::message') --}}

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{-- @include('invoices.show_fields') --}}

                    
                        <style>
                            table, th, td {
                            border: 1px solid;
                            weight: 90%
                            }
                        </style>

                        <!-- Customer Id Field -->
                        <div class="col-sm-12">

                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">اذن تسليم بضاعة</span>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('customer_id', 'العميل:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $invoice->get_customer->name }}</span>
                        </div>
                        {{-- <div class="col-sm-3">
                            {!! Form::label('branch', 'الفرع:') !!}
                            <span class="border border-lightgray rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                             @if ($invoice->branch == 1) جسر السويس @elseif ($invoice->branch == 2) بلاقس @endif
                            </span>
                        </div> --}}
                        <div class="col-sm-3">
                            {!! Form::label('invoice_id', ' فاتورة رقم:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $invoice->id}}</span>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('date', 'تاريخ الفاتورة:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $invoice->date->format('Y-m-d') }}</span>
                        </div>



                        <div class="col-sm-12" style="margin-top:10px; ">
                        <table id="table_print" style="width: 100%">
                            <thead>
                                <tr style="background-color: #e0e4e7;text-align: center;font-weight: bold;">
                                    <th>م</th>
                                    <th>اذن التسليم</th>
                                    <th>اذن الاضافة</th>
                                    <th>الموديل</th>
                                    <th>جهة التسليم</th>

                                    <th>نوع الغسيل</th>
                                    <th>الوزن/ العدد</th>
                                    <th>سعر الغسيل</th>
                                    <th>قيمة الغسيل</th>

                                    <th>نوع الفاشون</th>
                                    <th>عدد القطع</th>
                                    <th>سعر الفاشون</th>
                                    <th>قيمة الفاشون</th>

                                </tr>
                            </thead>
                            <tbody >
                                @php
                                    $total_kilos=0;   $total_price_kilos=0;  $total_quantities=0;   $total_price_units=0;  $total_price_piece_price=0;
                                @endphp
                                @foreach ($invoice_details as $items)
                                    @php
                                        $total_kilos+=$items->total_kg;
                                        $total_quantities+=$items->total_qty;
                                    @endphp
                                    @php
                                        $price_wash=0;   $wash_names=[];
                                        foreach ($items->service_item_with_kilo as $wash){
                                            $price_wash+=$wash->money;
                                            $wash_names[]=$wash->name;
                                        }
                                    @endphp

                                    @php
                                        $price_fashion=0;   $fashion_names=[]; 
                                        foreach ($items->service_item_with_unit as $fashion){
                                            $price_fashion+=$fashion->money;
                                            $fashion_names[]=$fashion->name;
                                        }
                                    @endphp
                                    @php
                                    $total_price_kilos+=$price_wash * $items->total_kg; 
                                    $total_price_units+=$price_fashion * $items->total_qty; 
                                    $total_price_piece_price+=$items->piece_price * $items->total_qty;
                                    @endphp
                                <tr>
                                    <td style="text-align: center;"> {{ $loop->iteration }} </td>
                                    <td style="text-align: center;"> {{ $items->final_deliver_order_id }}</td>

                                    <td style="text-align: center;">{{ $items->get_work_order->receive_receipt_id }}</td>
                                    <td style="text-align: center;"> {{ $items->get_work_order->get_products->name }} {{ $items->get_work_order->get_ReceiveReceipt->product_type ? ' (' . $items->get_work_order->get_ReceiveReceipt->product_type . ')' : '' }} {{ $items->get_work_order->get_ReceiveReceipt->model ? ' (' . $items->get_work_order->get_ReceiveReceipt->model . ')' : '' }} </td>
                                    <td style="text-align: center;"> {{ $items->get_work_order->get_receivables->name }}  </td>
                                    <td style="text-align: center;">
                                        @foreach ($wash_names as $names)
                                        <span class="badge badge-secondary border border-lightgray"> {{ $names }} </span>
                                        @endforeach
                                    </td>
                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;"> {{ $items->total_kg }} </td>
                                    @else
                                        <td style="text-align: center;"> {{ $items->total_qty }} </td>
                                    @endif
                                    
                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;"> {{ $price_wash }} </td>
                                    @else
                                        <td style="text-align: center;"> {{ $items->piece_price }} </td>
                                    @endif
                                    
                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;"> {{ $price_wash * $items->total_kg }}</td>
                                    @else
                                        <td style="text-align: center;"> {{ $total_price_piece_price }}</td>
                                    @endif
                                    <td style="text-align: center;">
                                        @foreach ($fashion_names as $name)
                                        <span class="badge badge-info border border-info"> {{ $name }} </span>
                                        @endforeach
                                    </td>
                                    <td style="text-align: center;">{{ $items->total_qty }}</td>

                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;"> {{ $price_fashion }}</td>
                                    @else
                                        <td style="text-align: center;"> 0 </td>
                                    @endif    

                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;">{{ $price_fashion * $items->total_qty }}</td>
                                    @else
                                        <td style="text-align: center;"> 0 </td>
                                    @endif
                        
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr style="background-color: #e0e4e7;text-align: center;font-weight: bold;">
                                    <th colspan="6">الاجمالى</th>

                                    @if ($invoice->calculation_method == "kilo")
                                        <th>{{ $total_kilos }}</th>
                                    @else
                                        <th>{{ $total_quantities }}</th>   
                                    @endif
                                
                                    <th>--</th>

                                    @if ($invoice->calculation_method == "kilo")
                                        <th>{{ $total_price_kilos }}</th>
                                    @else
                                        <th>{{ $total_price_piece_price }}</th>
                                    @endif
                                    <th>--</th>
                                    <th>{{ $total_quantities }}</th>
                                    <th>--</th>

                                    @if ($invoice->calculation_method == "kilo")
                                        <th>{{ $total_price_units }}</th>
                                    @else
                                    <th>0</th>
                                    @endif

                                </tr>
                            </thead>
                        </table>
                        </div> 

                        {{-- <div class="col-sm-8"> --}}
                            {{-- {!! Form::label('sum_total_kg', 'اجمالي الوزن:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                            --
                            </span> --}}
                        {{-- </div> --}}

                        <div class="col-sm-3">
                            {!! Form::label('amount_original', 'اجمالى الفاتورة:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                {{ $invoice->amount_original }} جنية
                            </span>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('amount_minus', 'مبلغ الخصم:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                {{ $invoice->amount_minus }} جنية
                            </span>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('tax', 'الضريبة 14%:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                {{ $invoice->tax }} جنية
                            </span>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('discount_notice', 'اشعار 3%:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                {{ $invoice->discount_notice }} جنية
                            </span>
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('amount_net', 'الاجمالى:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                {{ $invoice->amount_net }} جنية
                            </span>
                        </div>

                        <div class="col-sm-12">
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important;color: #504f4f !important;font-weight: bold;margin-top: 10px;font-size: 10pt;">
                                إذا لم نتلقى منكم اي اعتراض على الفاتورة اعلاه خلال يومين على الاكثير تعتبر الفاتورة صحيحة كمية وقيمة
                            </span> 
                        </div>

                        <div class="col-sm-8">
                        </div>
                        <div class="col-sm-4">
                            <p  style="color: #504f4f !important;font-weight: bold; text-align:center !important;">
                            توقيع المستلم
                            </p>
                        </div>
                        <div class="col-sm-8">
                        </div>
                        <div class="col-sm-4">
                            <p  style="color: #504f4f !important;font-weight: bold; text-align:center !important;">
                            -----------
                            </p>
                        </div>



                </div>
            </div>
        </div>
    </div>
@endsection


{{-- <script>
        window.onload = function() {
            window.print();
        }
    </script> --}}
