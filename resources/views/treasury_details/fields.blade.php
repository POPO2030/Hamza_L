<!-- treasury_id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('treasury_id', 'الخزينه:') !!}
    {{ Form::select('treasury_id',$treasury_details,null,['option'=>'treasury_details','class'=> 'form-control']) }}
</div>


<!-- Treasury Journal Field -->
<div class="form-group col-sm-3">
    {!! Form::label('treasury_journal', 'رقم يوميه :') !!}
    {!! Form::text('treasury_journal', date('1/ d'), ['class' => 'form-control']) !!}
</div>
<!-- Treasury Journal Field -->
<div class="form-group col-sm-3">
    {!! Form::label('date', 'تاريخ اليوميه:') !!}
    {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('account_type', 'نوع الحساب:') !!}
    <select name="account_type" id="account_type" class="form-control">
        <option value="">اختر الحساب</option>
        <option value="1">العملاء</option>
        <option value="2">الموردين</option>
    </select>
</div>


    {{-- نوع الدفع --}}
    <div class="form-group col-sm-2">
        <label for="payment_type_id">نوع الدفع:</label>
        <select name="payment_type_id" id="payment_type_id" class="form-control searchable">
            @foreach ($payment_type as $payment_types)
                @if ($payment_types->id == 1 || $payment_types->id == 4 || $payment_types->id == 10)

                    @continue
                @endif
                <option value="{{ $payment_types->id }}">{{ $payment_types->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- حساب العملاء --}}
    <div class="form-group col-sm-2" id="customer_accounts" style="display: none;">
        {!! Form::label('customer_account', 'الي حساب عميل:') !!}
        <select name="customer_id" id="customer_id" class="form-control searchable" dir="rtl" style="width: 100%"> 
            <option value="">اختر العميل</option>
            @foreach ($Customer as $Customers)
                <option value="{{$Customers->id}}">{{$Customers->customer_code}} {{$Customers->name}}</option>
            @endforeach
        </select>
    </div>


    
        {{-- حساب الموردين --}}
        <div class="form-group col-sm-2" id="supplier_accounts" style="display: none;">
            {!! Form::label('supplier_account', 'الي حساب مورد:') !!}
            <select name="supplier_id" id="supplier_id" class="form-control searchable" dir="rtl" style="width: 100%">
                <option value="">اختر المورد</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                @endforeach
            </select>
        </div>
<!-- Credit Field -->
<div class="form-group col-sm-3">
    {!! Form::label('credit', 'دائن:') !!}
    {!! Form::text('credit', null, ['class' => 'form-control'. ($errors->has('credit') ? ' is-invalid' : ''),'id'=>'credit','placeholder' => number_format(null, 2)]) !!}
    @if ($errors->has('credit'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('credit') }}</strong>
    </span>
@endif
<span id="credit-error" class="error-message" style="color: red"></span>
</div>


<!-- Debit Field -->
<div class="form-group col-sm-3">
    {!! Form::label('debit', 'مدين:') !!}
    {!! Form::text('debit', null, ['class' => 'form-control'. ($errors->has('debit') ? ' is-invalid' : ''),'id'=>'debit','placeholder' => number_format(null, 2)]) !!}
    @if ($errors->has('debit'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('debit') }}</strong>
    </span>
@endif
<span id="debit-error" class="error-message" style="color: red"></span>
</div>

{{-- <div class="form-group col-sm-3" id="empty" >
</div> --}}

<!-- Details Field -->
<div class="form-group col-sm-3">
    {!! Form::label('details', 'تفاصيل:') !!}
    {!! Form::text('details', null, ['class' => 'form-control']) !!}
</div>



<div class="form-group col-sm-2" id="banks">
    {!! Form::label('banks', 'بنك:') !!}
    <select name="bank_id" id="bank_id" class="form-control searchable" dir="rtl" style="width: 100%"> 
        <option value="">اختر البنك</option>
        @foreach ($banks as $bank)
            <option value="{{$bank->id}}"> {{$bank->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-2" id="date_recive_check_group">
    <label for="date_recive_check">تاريخ استلام الشيك:</label>
    <input type="date" name="date_recive_check" id="date_recive_check" class="form-control">
</div>

<div class="form-group col-sm-2" id="date_entitlment_group">
    <label for="date_entitlment">تاريخ الاستحقاق:</label>
    <input type="date" name="date_entitlment" id="date_entitlment" class="form-control">
</div>

<div class="form-group col-sm-2" id="check_no_group" >
    <label for="check_no">رقم الشيك:</label>
    <input type="text" name="check_no" id="check_no" class="form-control">
</div>


<!-- Img Field -->
<div class="form-group col-sm-6" id="img_check_group">
    {!! Form::label('img', 'صورة الشيك:') !!}
    {!! Form::file('img[]', ['multiple' => true, 'class' => 'form-control', 'id' => 'img', 'data-browse' => 'اختر الصورة']) !!}
    <div class="preview">
        @if (!empty($temp))
            @foreach ($temp as $image)
                <div class="col-sm-10">
                    <img class="img-thumbnail" src="{{ asset($image) }}" alt="preview" style="height: 200px;">
                </div>
            @endforeach
        @endif
    </div>
    @error('img')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="errorSpan" class="error" style="color: red;font-weight:bold"></span>
</div>



<script src="{{URL('js/jquery-3.6.0.min.js')}}" ></script>
 {{-- اخفاء رقم الشيك و تاريخ الشيك  --}}
<script>
$(document).ready(function () {
    function toggleFields() {
        var paymentTypeId = $('#payment_type_id').val();

        // أخفِ جميع الحقول أولاً
        $('#banks, #date_recive_check_group, #date_entitlment_group, #check_no_group, #img_check_group, #empty').hide();

        if (paymentTypeId == '3') {
            $('#banks').show();
            $('#date_recive_check_group').show();
            $('#date_entitlment_group').show();
            $('#check_no_group').show();
            $('#img_check_group').show();
            $('#empty').show();
        } else if (paymentTypeId == '5') {
            $('#banks').show();
            $('#empty').show();
        }
        // غير ذلك، لا يظهر أي شيء
    }

    // نادِ الدالة عند تحميل الصفحة
    toggleFields();

    // نادِ الدالة عند تغيير الاختيار
    $('#payment_type_id').change(function () {
        toggleFields();
    });
});
</script>

</script>



<script>
    document.getElementById('account_type').addEventListener('change', function () {
        var accountType = this.value;
        if (accountType === '1') {
            document.getElementById('customer_accounts').style.display = 'block';
            document.getElementById('supplier_accounts').style.display = 'none';

        } else if (accountType === '2') {
            document.getElementById('customer_accounts').style.display = 'none';
            document.getElementById('supplier_accounts').style.display = 'block';

        } else {
            document.getElementById('customer_accounts').style.display = 'none';
            document.getElementById('supplier_accounts').style.display = 'none';

        }
    });
</script>


<script>
    // Get references to the input fields
    var creditInput = document.getElementById('credit');
    var debitInput = document.getElementById('debit');

    // Function to disable credit input and enable debit input
    function disableCredit() {
        creditInput.disabled = true;
        debitInput.disabled = false;
    }

    // Function to disable debit input and enable credit input
    function disableDebit() {
        debitInput.disabled = true;
        creditInput.disabled = false;
    }

    // Event listener for credit input
    creditInput.addEventListener('input', function() {
        // If credit input is not empty, disable debit input
        if (this.value.trim() !== '') {
            disableDebit();
        } else {
            // If credit input is empty, enable debit input
            debitInput.disabled = false;
        }
    });

    // Event listener for debit input
    debitInput.addEventListener('input', function() {
        // If debit input is not empty, disable credit input
        if (this.value.trim() !== '') {
            disableCredit();
        } else {
            // If debit input is empty, enable credit input
            creditInput.disabled = false;
        }
    });
</script>

