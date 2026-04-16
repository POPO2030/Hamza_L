@extends('layouts.app')

@section('title')
    {{__(' تعديل الفاتورة ')}}
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
    <section class="content-header no-print">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل الفاتورة</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('invoices.index') }}">
                        عودة
                    </a>
                   
                </div>
            </div>
        </div>
    </section>

    {{-- @include('flash::message') --}}
{!! Form::model($invoice, ['route' => ['invoices.update', $invoice->id], 'method' => 'patch']) !!}

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

                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">تعديل بيان الاسعار</span>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('customer_id', 'العميل:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $invoice->get_customer->name }}</span>
                        </div>
                        {{-- <div class="col-sm-3">
                            {!! Form::label('branch', 'الفرع:') !!}
                            {!! Form::select('branch', [1 => 'جسر السويس', 2 => 'بلقس'], $invoice->branch, [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div> --}}
                        <div class="col-sm-3">
                            {!! Form::label('invoice_id', ' اذن رقم:') !!}
                            <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $invoice->id}}</span>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('date', 'التاريخ:') !!}
                            {!! Form::date('date', $invoice->date->format('Y-m-d'), [
                                'class' => 'form-control',
                               
                            ]) !!}
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
                                        <td style="text-align: center;"> {{ $price_wash }}  </td>
                                    @else
                                <td style="text-align: center;">
                                    <input type="text"
                                        name="piece_price[]" 
                                        value="{{ $items->piece_price }}" 
                                        class="price_wash_input form-control" 
                                        data-qty="{{ $items->total_qty }}"
                                        data-target="wash_total_{{ $loop->index }}"
                                        style="width: 60px; text-align: center;"        
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^(\d*\.\d{0,2}).*$/, '$1')"
                                    />
                                </td>
                                    @endif
                                    
                                    @if ($invoice->calculation_method == "kilo")
                                        <td style="text-align: center;"> {{ $price_wash * $items->total_kg }}</td>
                                    @else
                                <td style="text-align: center;"> 
                                    <span class="wash_total" id="wash_total_{{ $loop->index }}">{{ $total_price_piece_price }}</span>
                                    <input type="hidden"  name="total_amount[]" id="wash_total_input_{{ $loop->index }}" value="{{ $total_price_piece_price }}">
                                </td>
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
                                     <th>
                                        <span id="total_price_piece_price_display">{{ $total_price_piece_price }}</span>
                                    </th>
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
                            @if ($invoice->calculation_method == "kilo")
                                    <span class="border border-lightgray  text-white p-2 d-block text-center"
                                    style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                  {{ $invoice->amount_original }} جنية
                                </span>
                            @else
                                <span class="border border-lightgray  rounded text-white p-2 d-block text-center"
                                    id="amount_original"
                                    style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
                                    {{ $invoice->amount_original }} جنية
                                </span>
                            @endif
                        </div>
<div class="col-sm-2"> 
    {!! Form::label('amount_minus', 'مبلغ الخصم:') !!}
    <div class="input-group">
        {!! Form::text('amount_minus', $invoice->amount_minus ?? '0.00', [
            'class' => 'form-control',
            'id' => 'amount_minus_input',
            'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '')",
            'inputmode' => 'decimal',
         
        ]) !!}
        <div class="input-group-append">
            <span class="input-group-text" style="font-weight: bold;">جنية</span>
        </div>
    </div>
</div>


<div class="form-check col-sm-2">
{{-- {!! Form::label('tax', 'الضريبة 14%:') !!} --}}
 <label class="form-check-label" for="checkbox_tax"> الضريبة 14%:</label> {{-- شيك بوك الضريبة --}}
    <input type="checkbox" class="form-check-input" id="checkbox_tax" {{ $invoice->tax > 0 ? 'checked' : '' }}>
   
<span id="tax_display" class="border border-lightgray rounded text-white p-2 d-block text-center"
      style="background-color: #e0e4e7 !important; color: #504f4f !important; font-weight: bold;">
    {{ $invoice->tax }} جنية
</span>
    <input type="hidden" name="tax" id="tax_input" value="{{ $invoice->tax }}">
</div>

<div class="form-check col-sm-2">
{{-- {!! Form::label('discount_notice', 'اشعار 3%:') !!} --}}
    <label class="form-check-label" for="checkbox_discount_notice"> اشعار 3%: </label>     {{-- شيك بوك الاشعار --}}
    <input type="checkbox" class="form-check-input" id="checkbox_discount_notice" {{ $invoice->discount_notice > 0 ? 'checked' : '' }}>

<span id="discount_notice_display" class="border border-lightgray rounded text-white p-2 d-block text-center"
      style="background-color: #e0e4e7 !important; color: #504f4f !important; font-weight: bold;">
    {{ $invoice->discount_notice }} جنية
</span>
    <input type="hidden" name="discount_notice" id="discount_notice_input" value="{{ $invoice->discount_notice }}">
</div>


<div class="col-sm-3">
    {!! Form::label('amount_net', 'الاجمالى:') !!}

    {{-- عرض القيمة للمستخدم --}}
    <span id="amount_net_display" class="border border-lightgray  rounded text-white p-2 d-block text-center" 
          style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">
        {{ $invoice->amount_net }} جنية
    </span>

    {{-- حقل مخفي يُرسل في الفورم --}}
    {!! Form::hidden('amount_net', $invoice->amount_net, ['id' => 'amount_net_input']) !!}
</div>


                    

                    <div class="col-sm-12">
                    <div class="mt-4">
                        {!! Form::submit('حفظ ', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const getNumber = (id) => {
            const text = document.getElementById(id)?.innerText || "0";
            return parseFloat(text.replace(/[^\d.]/g, '')) || 0;
        };

        const discountInput = document.getElementById('amount_minus_input');
        const amountNetDisplay = document.getElementById('amount_net_display');
        const amountNetInput = document.getElementById('amount_net_input');

        function calculateTotal() {
            const amountOriginal = getNumber('amount_original');
            const tax = getNumber('tax_display');
            const discountNotice = getNumber('discount_notice_display');
            const discount = parseFloat(discountInput.value) || 0;

            const netTotal = (amountOriginal + tax - discountNotice) - discount;
            const formatted = netTotal.toFixed(2);

            amountNetDisplay.innerText = formatted + ' جنية';
            amountNetInput.value = formatted;
        }

        discountInput.addEventListener('input', calculateTotal);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        function getNumber(text) {
            return parseFloat(String(text).replace(/[^\d.]/g, '')) || 0;
        }

        function calculateWashTotals() {
            let total = 0;

            // اجمع كل قيم الغسلات
            document.querySelectorAll('.price_wash_input').forEach(input => {
                const price = parseFloat(input.value) || 0;
                const qty = parseFloat(input.dataset.qty) || 0;
                const subtotal = price * qty;

                // تحديث قيمة الغسلة في الصف
                const targetId = input.dataset.target;
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    targetEl.innerText = subtotal.toFixed(2);
                }

                // تحديث الـ <input hidden> المرتبط بنفس الصف
                const inputIndex = targetId.split('_').pop(); // يأخذ رقم السطر
                const inputEl = document.getElementById('wash_total_input_' + inputIndex);
                if (inputEl) {
                    inputEl.value = subtotal.toFixed(2);
                }

                total += subtotal;
            });

            // تحديث اجمالي الفاتورة في جدول الاجمالي
            const totalPieceDisplay = document.getElementById('total_price_piece_price_display');
            if (totalPieceDisplay) {
                totalPieceDisplay.innerText = total.toFixed(2);
            }

            // تطبيق الخصم اليدوي
            const discountInput = document.getElementById('amount_minus_input');
            const discount = parseFloat(discountInput.value) || 0;

            // تطبيق الضريبة 14% إذا checkbox مفعّل
            const checkboxTax = document.getElementById('checkbox_tax');
            const tax = checkboxTax && checkboxTax.checked ? total * 0.14 : 0;
            const taxDisplay = document.getElementById('tax_display');
            if (taxDisplay) {
                taxDisplay.innerText = tax.toFixed(2) + ' جنية';
                const taxInput = document.getElementById('tax_input');
                if (taxInput) {
                    taxInput.value = tax.toFixed(2);
                }
            }

            // تطبيق خصم إشعار 3% إذا checkbox مفعّل
            const checkboxDiscount = document.getElementById('checkbox_discount_notice');
            const discountNotice = checkboxDiscount && checkboxDiscount.checked ? total * 0.03 : 0;
            const discountNoticeDisplay = document.getElementById('discount_notice_display');
            if (discountNoticeDisplay) {
                discountNoticeDisplay.innerText = discountNotice.toFixed(2) + ' جنية';
                const discountNoticeInput = document.getElementById('discount_notice_input');
                if (discountNoticeInput) {
                    discountNoticeInput.value = discountNotice.toFixed(2);
                }
            }

            // حساب الاجمالى النهائى
            const netTotal = (total + tax - discountNotice) - discount;

            // تحديث عرض الاجمالى
            const amountOriginal = document.getElementById('amount_original');
            const amountNetDisplay = document.getElementById('amount_net_display');
            const amountNetInput = document.getElementById('amount_net_input');

            if (amountOriginal) amountOriginal.innerText = total.toFixed(2) + ' جنية';
            if (amountNetDisplay) amountNetDisplay.innerText = netTotal.toFixed(2) + ' جنية';
            if (amountNetInput) amountNetInput.value = netTotal.toFixed(2);
        }

        // ربط الأحداث بالحساب التلقائي عند التعديل
        document.querySelectorAll('.price_wash_input').forEach(input => {
            input.addEventListener('input', calculateWashTotals);
        });

        const discountInput = document.getElementById('amount_minus_input');
        if (discountInput) {
            discountInput.addEventListener('input', calculateWashTotals);
        }

        const checkboxTax = document.getElementById('checkbox_tax');
        if (checkboxTax) {
            checkboxTax.addEventListener('change', calculateWashTotals);
        }

        const checkboxDiscount = document.getElementById('checkbox_discount_notice');
        if (checkboxDiscount) {
            checkboxDiscount.addEventListener('change', calculateWashTotals);
        }

        // أول مرة نحسب عند تحميل الصفحة
        calculateWashTotals();
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calculationMethod = "{{ $invoice->calculation_method }}";

        function getNumber(text) {
            return parseFloat(String(text).replace(/[^\d.]/g, '')) || 0;
        }

        function calculateTotalsForKilo() {
            if (calculationMethod !== 'kilo') return;

            // إجمالي الفاتورة الأصلي
            const amountOriginalText = document.querySelector('#amount_original')?.innerText || '{{ $invoice->amount_original }}';
            const amountOriginal = getNumber(amountOriginalText);

            // الخصم اليدوي
            const amountMinus = parseFloat(document.getElementById('amount_minus_input')?.value || 0);

            // الضريبة 14%
            const taxCheckbox = document.getElementById('checkbox_tax');
            const tax = taxCheckbox && taxCheckbox.checked ? amountOriginal * 0.14 : 0;
            document.getElementById('tax_display').innerText = tax.toFixed(2) + ' جنية';
            document.getElementById('tax_input').value = tax.toFixed(2);

            // إشعار خصم 3%
            const discountNoticeCheckbox = document.getElementById('checkbox_discount_notice');
            const discountNotice = discountNoticeCheckbox && discountNoticeCheckbox.checked ? amountOriginal * 0.03 : 0;
            document.getElementById('discount_notice_display').innerText = discountNotice.toFixed(2) + ' جنية';
            document.getElementById('discount_notice_input').value = discountNotice.toFixed(2);

            // حساب الاجمالى الصافي
            const amountNet = (amountOriginal + tax - discountNotice) - amountMinus;

            // تحديث القيم المعروضة
            document.getElementById('amount_net_display').innerText = amountNet.toFixed(2) + ' جنية';
            document.getElementById('amount_net_input').value = amountNet.toFixed(2);
        }

        // إضافة الأحداث
        const taxCheckbox = document.getElementById('checkbox_tax');
        if (taxCheckbox) {
            taxCheckbox.addEventListener('change', calculateTotalsForKilo);
        }

        const discountNoticeCheckbox = document.getElementById('checkbox_discount_notice');
        if (discountNoticeCheckbox) {
            discountNoticeCheckbox.addEventListener('change', calculateTotalsForKilo);
        }

        const amountMinusInput = document.getElementById('amount_minus_input');
        if (amountMinusInput) {
            amountMinusInput.addEventListener('input', calculateTotalsForKilo);
        }

        // تنفيذ أولي عند تحميل الصفحة
        calculateTotalsForKilo();
    });
</script>
