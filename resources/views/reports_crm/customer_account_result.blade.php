@extends('layouts.app')

<?php
function formatDate($date) {
// Convert the date string to a DateTime object
$dateTime = new DateTime($date);
// Define the Arabic day names
$arabicDayNames = array(
'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'
);
// Get the Arabic day name based on the day of the week
$dayOfWeek = $dateTime->format('w'); // 0 (Sunday) to 6 (Saturday)
$arabicDayName = $arabicDayNames[$dayOfWeek];

// Format the date with the Arabic day name
$formattedDate = $arabicDayName . '، ' . $dateTime->format('d/m/Y');

return $formattedDate;
}

?>

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    td , tr{
        text-align: center
    }
    .hover-image {
        width: 50px;
        height: 50px;
        transition: width 0.3s, height 0.3s;
    }

    .hover-image:hover {
        width: 250px;
        height: 300px;
    }
    .col-sm-12.printable.p-10{
            padding: 5 !important;
            text-align: center;
            display: none;
        }
        #head{
        background-color: #fdfdfd !important; 
        font-weight: bold;
       }

       .btn.btn-fab, .btn.btn-just-icon{
        height: 30px !important;
       }

    @media print {
        @page {
        size: 'A4';
        margin: 10 !important;
        /* padding: 5 !important; */
        
    }

        .header, .main-footer, .mb-2,.fixed-plugin,.footer{
            display: none;
        }
        .content-wrapper{
        margin: 0 !important;
        background-color: white !important;
        /* transform: scale(0.80);         81% scaling */
        /* transform-origin: top right;  */
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
            font-size: 20px;
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
        .ps-scrollbar-y-rail , .ps-scrollbar-y{
            display: none;
        }
    }
</style>
@endpush

@section('title')
{{ __('كشف  حساب العميل') }}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
          كشف  حساب العميل
          <span class="badge badge-info" style="font-size: 20px"> {{$customer_name->name}} </span> 
        </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('customer_account_report') }}">
            رجوع
        </a>
        <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
            <i class="fas fa-file-excel"></i> تصدير الى الاكسيل 
          </button>
          <button class="btn btn-primary btn-sm float-left" onclick="printFullReport()" style="margin-left: 10px;"> 
            <i class="fas fa-print"></i> طباعه 
        </button>

        <button type="button" class="btn btn-dark btn-sm float-left" data-toggle="modal" data-target="#modal-default" style="margin-left: 10px;">  اضافة خصم 
            <i class="fas fa-percent"></i>
        </button>
        <button type="button" class="btn btn-dark btn-sm float-left" data-toggle="modal" data-target="#modal_account_settlement" style="margin-left: 10px;">  اضافة تسوية 
            <i class="fas fa-coins"></i>
        </button>
    </div>
  </div>
</div>
</section>


    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body">

                <h3 style="text-align: center; color: #9c27b0; font-size:15pt; font-weight:bolder;">

                    @if(isset($request['from']) && $request['from'] != null && isset($request['to']) && $request['to'] != null)
                        <p>كشف حساب عن الفترة من ({{ formatDate($request['from']) }}) - الى ({{ formatDate($request['to']) }})</p>
                    @else
                        <p> كشف حساب </p>
                    @endif
                </h3>
               

            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12 printable p-10" id="title">
                    <p>   <span class="badge badge-info" style="font-size: 20px"> {{$customer_name->name}} </span> </p>
                </div>
                    <table class="table table-border" id="tab">
                        
                        <tr class="table-active" >
                            <th style="vertical-align: middle;">التاريخ</th>
                            <th style="vertical-align: middle;">البيان</th>
                            <th style="vertical-align: middle;">مدين</th>
                            <th style="vertical-align: middle;">دائن</th>
                            <th style="vertical-align: middle;">الرصيد</th>
                            <th style="vertical-align: middle;">نوع الدفع</th>
                            <th style="vertical-align: middle;" class="hide_column">تفاصيل</th>
                        </tr>
                                @php
                                    $count = 0;
                                    $sum = 0;
                                @endphp
                @if (isset($customer_details))
                   
                        <tr>
                            <td>
                                @if(isset($request->from))
                                    {{ \Carbon\Carbon::parse($request->from)->subDay()->format('Y-m-d') }}
                                @endif
                            </td>
                            <td  style="font-weight:bolder"> رصيد اول المدة</td>
                            <td></td>
                            <td></td>
                            <td style="font-weight:bolder">
                                {{ number_format($customer_balance_first_period,2) }}  
                            </td>
                        </tr>  
                    

                    @php
                        $balance = $customer_balance_first_period;
                    @endphp  
                    @foreach ($customer_details as $item)
                    @php
                        if ($item->invoice_id == null) {
                            if($item->payment_type_id == 10 || $item->payment_type_id == 2 || $item->payment_type_id == 3 || $item->payment_type_id == 5){      // خصم
                                $balance -= $item->cash_balance_credit;
                            }elseif($item->payment_type_id == 11) {    // تسويه
                                $balance += $item->cash_balance_debit;
                            }
                            
                        } else {
                            $balance += $item->cash_balance_debit;
                        }
        
                    @endphp
                            {{-- @if ($item->payment_type_id != 4) --}}
                                
                            <tr>
                                <td>{{ $item->date }}</td>
                                <td style="color: red; font-weight:bolder">  {{ $item->note }} {{ $item->invoice_id ? "($item->invoice_id)" : '' }} </td>
                                <td style="font-weight:bolder">{{ number_format($item->cash_balance_debit,2) }}</td>
                                <td style="font-weight:bolder">{{ number_format($item->cash_balance_credit,2) }}</td>
                                <td style="font-weight:bolder">{{ number_format($balance,2) }}</td>
                                <td>
                                    @if (in_array($item->payment_type_id, [2, 3, 5, 10,11]))
                                    @if ($item->payment_type_id == 3 || $item->payment_type_id == 5)
                                        <span class="badge badge-info">
                                            <i class="fas fa-money-bill"></i>
                                            {{ $item->get_payment_type->name }}
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fas fa-coins"></i>
                                            {{ $item->get_payment_type->name }}
                                        </span>
                                    @endif
                                @else
                                    --
                                @endif
                                </td>

                                <td class="hide_column d-flex align-items-center justify-content-start flex-wrap gap-2 p-2">
                                
                                @if (isset($item->invoice_id))
                                    <a href="{{ URL('invoices', $item->invoice_id) }}" class="btn btn-link btn-default btn-just-icon">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                                  
                                @if ($item->payment_type_id == 11)
                                    <button onclick="get_row_settlement('{{ $item->id }}','{{ $item->cash_balance_debit }}','{{ $item->note }}','{{ $item->date }}')" type="button" class="btn btn-link btn-default btn-just-icon edit" data-toggle="modal" data-target="#modal_edit_account_settlement" style="margin-left: 10px;">   
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {!! Form::open(['route' => ['delete_settlement', $item->id], 'method' => 'post', 'class' => 'd-inline']) !!}
                                    <input type="hidden" name="from" value="{{ request('from') }}">
                                    <input type="hidden" name="to" value="{{ request('to') }}">
                                    <input type="hidden" name="customer_id" value="{{ $customer_name->id }}">
                                    <input type="hidden" name="id" id="delete_settlement_row_id" value="">

                                    {!! Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
                                        'onclick' => "return confirm('هل أنت متأكد من حذف التسوية؟'),delete_row_settlement('$item->id')"
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif
                                  
                                @if ($item->payment_type_id == 10)
                                    <button onclick="get_row_discount('{{ $item->id }}','{{ $item->cash_balance_credit }}','{{ $item->note }}','{{ $item->date }}')" type="button" class="btn btn-link btn-default btn-just-icon edit" data-toggle="modal" data-target="#modal_edit_discount_customer" style="margin-left: 10px;">   
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {!! Form::open(['route' => ['delete_discount', $item->id], 'method' => 'post', 'class' => 'd-inline']) !!}
                                    <input type="hidden" name="from" value="{{ request('from') }}">
                                    <input type="hidden" name="to" value="{{ request('to') }}">
                                    <input type="hidden" name="customer_id" value="{{ $customer_name->id }}">
                                    <input type="hidden" name="id" id="delete_discount_row_id" value="">

                                    {!! Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-link btn-danger btn-just-icon destroy',
                                        'onclick' => "return confirm('هل أنت متأكد من حذف الخصم؟'),delete_row_discount('$item->id')"
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif

                                </td>
                          
                            </tr>
                                
                            {{-- @endif --}}
                            

                           
                    @endforeach
                    <tr class="table-active" style="position: sticky;top: 0;background-color: rgb(0 0 0 / 75%);color: #fff;">

                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;"></th>
                        <th style="vertical-align: middle;" ></th>
                        <th style="vertical-align: middle;" ></th>



                    </tr>
                @endif
                    </table>

            {{-- </div> --}}
                <div class="card-footer text-center">
                    <div class="row">
                       
                    </div>
                </div>
                

            </div>
        </div>
        
    </div>



    {{-- ------------------------------ اضافة الخصم -------------------------- --}}

    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">اضافة الخصم</h5>

        </div>
        <div class="modal-body">
            
          <form method="post" action="{{ URL('add_discount_customer/'.$customer_name->id) }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,0);">
          @csrf
          <input type="hidden" name="from" value="{{ request('from') }}">
          <input type="hidden" name="to" value="{{ request('to') }}">

            <div class="form-group col-sm-12">
                {!! Form::label('date', 'التاريخ :') !!}
                {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date', 'name' => 'date' , 'required' => true,]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('amount', 'المبلغ:') !!}
                {!! Form::number('amount', null, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''),'id'=>'amount','minlength' => 1,'maxlength' => 12 , 'required' => true]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('note', 'ملحوظات:') !!}
                {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 2]) !!}
               
            </div>

            {{-- <input type="text" id="from" name="from" value="{{$request->from}}">
            <input type="text" id="to" name="to" value="{{$request->to}}"> --}}
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
        </form>
        </div>
        </div>
    
    </div>
    {{-- -------------------------------------------------------- --}}
    
     {{-- ------------------------------ تعديل الخصم -------------------------- --}}
    <div class="modal fade" id="modal_edit_discount_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelEdit">تعديل الخصم</h5>

        </div>
        <div class="modal-body">
            
          <form method="post" action="{{ URL('edit_discount_customer/'.$item->id) }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,0);">
          @csrf
          <input type="hidden" name="from" value="{{ request('from') }}">
          <input type="hidden" name="to" value="{{ request('to') }}">
          <input type="hidden" name="customer_id" value="{{ $customer_name->id }}">
          <input type="hidden" name="id" id="discount_row_id" value="">

            <div class="form-group col-sm-12">
                {!! Form::label('date', 'التاريخ :') !!}
                {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date_discount', 'name' => 'date','required' => true,]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('amount', 'المبلغ:') !!}
                {!! Form::number('amount', null, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''),'id'=>'amount_discount','minlength' => 1,'maxlength' => 12,'required' => true,]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('note', 'ملحوظات:') !!}
                {!! Form::textarea('note', null, ['class' => 'form-control','id'=>'note_discount','minlength' => 2,'maxlength' => 2255, 'rows' => 2]) !!}
               
            </div>

            {{-- <input type="text" id="from" name="from" value="{{$request->from}}">
            <input type="text" id="to" name="to" value="{{$request->to}}"> --}}
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
        </div>
        </div>
      
    </div>
    {{-- -------------------------------------------------------- --}}

    {{-- ------------------------------ اضافة تسوية -------------------------- --}}
    <div class="modal fade" id="modal_account_settlement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">اضافة تسوية</h5>

        </div>
        <div class="modal-body">
            
          <form method="post" action="{{ URL('add_account_settlement_customer/'.$customer_name->id) }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,0);">
          @csrf
          <input type="hidden" name="from" value="{{ request('from') }}">
          <input type="hidden" name="to" value="{{ request('to') }}">

            <div class="form-group col-sm-12">
                {!! Form::label('date', 'التاريخ :') !!}
                {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date', 'name' => 'date']) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('amount', 'المبلغ:') !!}
                {!! Form::number('amount', null, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''),'id'=>'amount','minlength' => 1,'maxlength' => 12]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('note', 'ملحوظات:') !!}
                {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 2]) !!}
               
            </div>

            {{-- <input type="text" id="from" name="from" value="{{$request->from}}">
            <input type="text" id="to" name="to" value="{{$request->to}}"> --}}
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
        </div>
        </div>
      
    </div>
    {{-- -------------------------------------------------------- --}}

    {{-- ------------------------------ تعديل تسوية -------------------------- --}}
    <div class="modal fade" id="modal_edit_account_settlement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelEdit">تعديل تسوية</h5>

        </div>
        <div class="modal-body">
            
          <form method="post" action="{{ URL('edit_account_settlement_customer/'.$item->id) }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,0);">
          @csrf
          <input type="hidden" name="from" value="{{ request('from') }}">
          <input type="hidden" name="to" value="{{ request('to') }}">
          <input type="hidden" name="customer_id" value="{{ $customer_name->id }}">
          <input type="text" name="id" id="settlement_row_id" value="">

            <div class="form-group col-sm-12">
                {!! Form::label('date', 'التاريخ :') !!}
                {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date_settlement', 'name' => 'date']) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('amount', 'المبلغ:') !!}
                {!! Form::number('amount', null, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''),'id'=>'amount_settlement','minlength' => 1,'maxlength' => 12]) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('note', 'ملحوظات:') !!}
                {!! Form::textarea('note', null, ['class' => 'form-control','id'=>'note_settlement','minlength' => 2,'maxlength' => 2255, 'rows' => 2]) !!}
               
            </div>

            {{-- <input type="text" id="from" name="from" value="{{$request->from}}">
            <input type="text" id="to" name="to" value="{{$request->to}}"> --}}
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
        </div>
        </div>
      
    </div>
    {{-- -------------------------------------------------------- --}}
@endsection

@push('page_scripts')
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>


@endpush

<script>
function printFullReport() {
    // Get all the content you want to print
    var printContents = document.getElementById('tab').outerHTML;
    var customerName = "{{ $customer_name->name }}";
    var periodText = "";
    
    @if(isset($request['from']) && $request['from'] != null && isset($request['to']) && $request['to'] != null)
        periodText = `كشف حساب عن الفترة من ({{ formatDate($request['from']) }}) - الى ({{ formatDate($request['to']) }})`;
    @else
        periodText = "كشف حساب";
    @endif

    var printWindow = window.open('', '_blank');

    printWindow.document.open();
    printWindow.document.write(`
        <html dir="rtl" lang="ar">
        <head>
            <title>كشف حساب العميل ${customerName}</title>
            <style>
                /* Base Styles */
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 5px 2px 0 2px !important;
                    padding: 0;
                    background: white;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    width: calc(100% - 4px);
                }
                
                /* Header Styles */
                .print-header {
                    text-align: center;
                    margin: 5px 2px 10px 2px;
                    padding: 0;
                }
                
                /* Table Styles */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 0;
                    page-break-inside: auto;
                    font-size: 12px;
                }
                
                th, td {
                    border: 1px solid #333;
                    padding: 4px;
                    text-align: center;
                }
                
                th {
                    background-color: #f0f0f0 !important;
                     color: black !important;
                    font-weight: bold;
                }
                
                /* First row styling */
                tr:first-child td {
                    color: black !important;
                    font-weight: bold;
                }
                
                tr.table-active {
                    background-color: rgba(0,0,0,0.75) !important;
                    color: white !important;
                }
                
                /* Hide details column */
                .hide_column {
                    display: none !important;
                }
                
                /* Custom Badge Colors */
                .badge {
                    padding: 2px 4px;
                    display: inline-block;
                    border-radius: 2px;
                    font-size: 11px;
                    margin: 1px;
                    line-height: 1.3;
                    color: white !important;
                }
                
                .badge-primary {
                    background-color: #9c27b0 !important;
                }
                
                .badge-secondary {
                    background-color: #6c757d !important;
                }
                
                .badge-info {
                    background-color: #00bcd4 !important;
                }
                
                .badge-warning {
                    background-color: #ff9800 !important;
                }
                
                /* Page Break Control */
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                
                /* Page Settings */
                @page {
                    size: A4;
                    margin: 5mm 2mm 0mm 2mm !important;
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h3 style="margin:5px 2px;font-size:16px;color: #9c27b0;font-weight:bolder;">${periodText}</h3>
                <h4 style="margin:5px 2px;font-size:14px;">العميل: <span class="badge badge-primary">${customerName}</span></h4>
            </div>
            ${printContents}
            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 300);
                    }, 200);
                };
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>

<script>
    function get_row_settlement(id, cash_balance_debit,note,date) {
        document.getElementById('date_settlement').value = date;
        document.getElementById('amount_settlement').value = cash_balance_debit;
        document.getElementById('note_settlement').value = note;
        document.getElementById('settlement_row_id').value = id;
    }

    function get_row_discount(id, cash_balance_debit,note,date) {
        document.getElementById('date_discount').value = date;
        document.getElementById('amount_discount').value = cash_balance_debit;
        document.getElementById('note_discount').value = note;
        document.getElementById('discount_row_id').value = id;
    }
    function delete_row_settlement(id) {
        document.getElementById('delete_settlement_row_id').value = id;
    }
    function delete_row_discount(id) {
        document.getElementById('delete_discount_row_id').value = id;
    }
</script>