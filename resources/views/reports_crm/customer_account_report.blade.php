
@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{ __('عرض  حساب العميل') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2>
                            <i class="fas fa-scroll heart-beat"></i>   عرض  حساب العميل
                        </h2>
                    </div>
                    <div class="card-body">
                    <form id="accountForm" method="post" action="">
                        @csrf
                        <div class="form-group">
                            <label for="customer_id">اسم العملاء:</label>
                            <select name="customer_id" id="customer_id" class="form-control searchable" required dir="rtl">
                                <option value="">اختر اسم العملاء</option>
                                @foreach ($customer as $customers)
                                    <option value="{{ $customers->id }}"> {{ $customers->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('from', 'من:') !!}
                                {{ Form::date('from', null, ['placeholder' => 'من', 'class' => 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('to', 'الى:') !!}
                                {{ Form::date('to', null, ['placeholder' => 'الى', 'class' => 'form-control','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
                            </div>  
                        </div>
                        
                        <div class="form-group text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <button type="submit" id="customer_account_result" class="btn btn-primary btn-block"
                                        onclick="submitForm('{{ route('customer_account_result') }}')">عرض حساب العميل مختصر</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" id="customer_account_report_detail" class="btn btn-primary btn-block"
                                        onclick="submitForm('{{ route('customer_account_report_detail') }}')">عرض حساب العميل تفصيلي</button>
                                </div>
                                <div class="col-md-4">
                                    <!-- Modified button with added onclick handler -->
                                    <button type="submit" id="customer_statement_result" class="btn btn-primary btn-block"
                                        onclick="handleStatementReport()">كشف حساب العملاء</button>
                                </div>
                                
                                <div class="col-md-4">
                                    <button type="submit" id="customer_account_report_discount" 
                                        class="btn btn-primary btn-block"
                                        onclick="handleDiscountReport()">عرض خصومات العميل</button>
                                </div>
                            </div>
                        </div>
                    </form>


                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function submitForm(actionUrl) {
        const form = document.getElementById('accountForm');
        form.action = actionUrl;
    }

    // New function to handle the statement report button click
    function handleStatementReport() {
        const customerIdField = document.getElementById('customer_id');
        
        // Remove 'required' attribute only for this report
        customerIdField.removeAttribute('required');
        
        // Submit the form with the correct route
        submitForm('{{ route('customer_statement_result') }}');
        
        // Re-add 'required' after submission (optional for form reset)
        setTimeout(() => customerIdField.setAttribute('required', true), 500);
    }

    function handleDiscountReport() {
    const customerIdField = document.getElementById('customer_id');

    // Remove required to allow empty selection
    customerIdField.removeAttribute('required');

    // Set form action to discount route
    submitForm('{{ route('customer_account_report_discount') }}');

    // Re-add required (in case user uses another button later)
    setTimeout(() => customerIdField.setAttribute('required', true), 500);
}
</script>