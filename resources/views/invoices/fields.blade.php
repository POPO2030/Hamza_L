<style>
    .read-text {
      border-radius: 5px;
      background-color: rgb(241, 241, 241);
      color: rgb(0, 0, 0);
      text-align: center;
      border: 0;
      font-weight: 600;
    }
    th {
        text-align: center;

        font-weight: bold;
    }
    tr{
        font-weight: bold ;
    }
    
    </style>
    
<!-- Customer Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('customer_id', 'اسم العميل:') !!}
    <select name="customer_id" id="customer_id" class="form-control searchable" required>
        <option value="">اختر العميل</option>
        @foreach($customers as $customer)
            <option value="{{$customer->id}}">{{$customer->name}}</option>
        @endforeach
    </select>
</div>

<!-- Calculation Method Field -->
<div class="form-group col-sm-3">
    {!! Form::label('calculation_method', 'طريقة الحساب:') !!}
    <select name="calculation_method" id="calculation_method" class="form-control" required>
        <option value="kilo">بالكيلو</option>
        <option value="piece">بالقطعة</option>
    </select>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('date', 'تاريخ الفاتوره:') !!}
    {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date', 'name' => 'date']) !!}
</div>
{{-- <div class="form-group col-sm-3">
    {!! Form::label('branch', 'الفرع:') !!}
    {!! Form::select('branch', ['1' => 'جسر السويس','2' => 'بلقس'], null, ['class' => 'form-control', 'id' => 'branch']) !!}</div> --}}

{{-- <!-- Piece Price Field -->
<div class="form-group col-sm-3" style="display: none;">
    {!! Form::label('piece_price', 'سعر القطعة بالجنيه: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('piece_price', null, ['class' => 'form-control', 'id'=>'piece_price' ,'minlength' => 1,'maxlength' => 3]) !!}
</div> --}}

<div class="form-group col-sm-12">
    <div>
    <table  class="table"  id="tab">
        <thead>
            <tr style="background-color: rgb(0 0 0 / 75%);color: #fff;   font-weight: bold;">
                {{-- <th>اذن التسليم</th> --}}
                <th>رقم الغسله</th>
                <th>الصنف</th>
                {{-- <th>السعر</th> --}}
                <th>البيان</th>
                <th>تاريخ اذن التسليم</th>
                <th>جهة التسليم</th>
                <th>الوزن</th>
                <th>الكمية</th>
                {{-- <th>سعر القطعه</th> --}}
                <th>اجمالي</th>
                {{-- <th>تحديد</th> --}}
            </tr>
        </thead>
        <tbody id="deliver-orders-table"  >
            <div id="hiddenInputsContainer"></div>
            <!-- Dynamic rows will be inserted here -->
        </tbody>
    </table>
</div>
</div>



<!-- Amount Net Field -->
{{-- <div class="form-group col-sm-3"> --}}
    {{-- {!! Form::label('amount_original', 'المبلغ الاصلي:') !!} --}}
    {!! Form::hidden('amount_original', '0.00', ['class' => 'form-control', 'id' => 'amount_original', 'readonly' => true, 'required' => true] ) !!}
{{-- </div> --}}
<div class="form-group col-sm-3">
    {!! Form::label('amount_net', 'الاجمالى:') !!}
    {!! Form::text('amount_net', '0.00', ['class' => 'form-control', 'id' => 'amount_net', 'readonly' => true, 'required' => true]) !!}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('amount_minus', 'المبلغ بالخصم:') !!}
    {!! Form::text('amount_minus', '0.00', ['class' => 'form-control', 'id' => 'amount_minus']) !!}
</div>

 <div class="form-group col-sm-7">
 </div>
{{-- <div class="form-group col-sm-2">
    {!! Form::label('amount_Increase', 'المبلغ بالزياده:') !!}
    {!! Form::text('amount_Increase', '0.00', ['class' => 'form-control', 'id' => 'amount_Increase']) !!}
</div> --}}

<div class="form-group col-sm-2">
    {!! Form::label('tax', 'ضريبة 14% : ') !!}
    {!! Form::checkbox('tax', '14%', false, ['class' => 'form-check-input', 'id' => 'tax']) !!}
    {!! Form::hidden('tax_output', '0.00', ['class' => 'form-control', 'id' => 'tax_output', 'readonly' => true]) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('discount_notice', 'اشعار خصم 3% : ') !!}
    {!! Form::checkbox('discount_notice', '3%', false, ['class' => 'form-check-input', 'id' => 'discount_notice']) !!}
    {!! Form::hidden('discount_notice_output', '0.00', ['class' => 'form-control', 'id' => 'discount_notice_output', 'readonly' => true]) !!}
</div>

<!-- Comment -->
<div class="form-group col-sm-9">
    {!! Form::label('comment', 'ملاحظات:') !!}
    {!! Form::text('comment', null, ['class' => 'form-control', 'id' => 'comment']) !!}
</div>
