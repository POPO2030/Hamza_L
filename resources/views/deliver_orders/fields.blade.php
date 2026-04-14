@if(isset($redirect))
    <input type="hidden" name="redirect" value={{$redirect}}>
@endif

@if(isset($customer_data))
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('customer_id',$customer_data,null,['class'=> 'form-control','id'=>'customer_id','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customer_data']) }}
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('customer_name',$deliverOrder->get_customer->name,['class'=> 'form-control','id'=>'customer_name','style'=>"width: 100%;",'required','readonly']) }}
    {{ Form::hidden('customer_id',$deliverOrder->customer_id,['class'=> 'form-control','id'=>'customer_id','style'=>"width: 100%;",'required','readonly']) }}
</div>
@endif

@if(isset($receipt_data))
<div class="form-group col-sm-6">
    {!! Form::label('receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receipt_id',$receipt_data,null,['class'=> 'form-control','id'=>'receipts','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receipt_data']) }}
</div>
@else
<!-- Receive Receipt Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('receipt_id',$deliverOrder->receipt_id,['class'=> 'form-control','id'=>'receipt_id','style'=>"width: 100%;",'required','readonly']) }}
</div>
@endif
<!-- Product Id Field -->

@if(isset($product_data))
<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('product_id',$product_data,null,['class'=> 'form-control','id'=>'products','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'product_data']) }}

</div>
<div class="form-group col-sm-2">
    {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_type',$product_type,['class'=> 'form-control','id'=>'product_type','style'=>"width: 100%;",'required','readonly']) }}
</div>
@else
<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_name',$deliverOrder->get_products->name,['class'=> 'form-control','id'=>'product_name','style'=>"width: 100%;",'required','readonly']) }}
    {{ Form::hidden('product_id',$deliverOrder->product_id,['class'=> 'form-control','id'=>'product_id','style'=>"width: 100%;",'required','readonly']) }}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_type',$deliverOrder->get_receive_receipt->product_type,['class'=> 'form-control','id'=>'product_type','style'=>"width: 100%;",'required','readonly']) }}
</div>
@endif


@if(isset($work_order_data))
<div class="form-group col-sm-6">
    {!! Form::label('work_order_id', 'رقم الغسلة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('work_order_id',$work_order_data,null,['class'=> 'form-control','id'=>'work_order_id', 'style'=>"width: 100%",'required'],['option'=>'work_order_data']) }}
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('work_order_id', 'رقم الغسلة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('work_order_id',$deliverOrder->work_order_id,['class'=> 'form-control','id'=>'work_order_id','style'=>"width: 100%;",'required','readonly']) }}
</div>
@endif




<!-- Receive Id Field -->
@if(isset($receive_data))
<div class="form-group col-sm-6">
    {!! Form::label('receive_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receive_id',$receive_data,null,['class'=> 'form-control','id'=>'receive_id', 'style'=>"width: 100%",'required'],['option'=>'receive_data']) }}
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('receive_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('receive_name',$deliverOrder->get_receivable->name,['class'=> 'form-control','id'=>'receive_name','style'=>"width: 100%;",'required','readonly']) }}
    {{ Form::hidden('receive_id',$deliverOrder->receive_id,['class'=> 'form-control','id'=>'receive_id','style'=>"width: 100%;",'required','readonly']) }}
</div>
@endif

<div>
 {{-- خانة الحالة مخفية --}}
 {!! Form::hidden('status', null, ['class' => 'form-control', 'id' => 'status']) !!}
</div>

<!-- Product_Count Field -->
<div class="form-group col-sm-2">
    {!! Form::label('product_count', 'كمية الغسلة:') !!}
    <p style="text-align: center; font-size: x-large" >
    <span class="badge badge-success" id="product_count">{{$data}}</span></p>
</div>

<!-- Remaining Field -->
<div class="form-group col-sm-2">
    {!! Form::label('remaining', 'المتبقى من الغسلة:') !!}
    <p style="text-align: center; font-size: x-large" >
    <span class="badge badge-danger" id="remaining">{{ $remaining }}</span></p>
</div>

<!-- Remain Recipt Field -->
<div class="form-group col-sm-2">
    {!! Form::label('remaining', ' المتبقى من اذن اضافة:') !!}
    <p style="text-align: center; font-size: x-large" >
    <span class="badge badge-danger" id="remaining">{{ $remainReceipt }}</span></p>
</div>


<div class="row" style="margin:3rem 0;width:100%">
          <button onclick="addRow(),calc()" type="button" id="add" class="btn btn-primary add_row">اضافة وحدة</button>    
            <table id="empTable" class="table table-boreder" style="border:1.5px solid gray;width:100%">
                <tr>
                <td>عدد الاكياس</td>
                <td>عدد القطع</td>
                <td>الاجمالى</td>
                <td>حذف</td> 
                </tr>
            @if(isset($deliverOrder))
            @foreach($deliverOrder->get_details as $row)
            <tr>
                <td><input type="number" name="package_number[]" value="{{$row->package_number}}" class="form-control package_number" oninput="calc()"></td>
                <td><input type="number" name="count[]" value="{{$row->count}}" class="form-control count" oninput="calc()"></td>
                <td><input type="number" name="total[]" value="{{$row->total}}" class="form-control total" readonly></td>
                <td><button onclick="removeRow(this),calc()" class="btn btn-link btn-danger btn-just-icon destroy"><i class="fa fa-trash"></i></button></td>
            </tr>
            @endforeach
            @endif
            </table>
           الاجمالى : <input class="form-control" readonly type="number" id="grandtotal">
</div>



<script>

    function addRow() {
        
        var empTab = document.getElementById('empTable');

        var rowCnt = empTab.rows.length;    
        var tr = empTab.insertRow(rowCnt); 

        for (var c = 0; c < 4; c++) {
            var td = document.createElement('td');          
            td = tr.insertCell(c);

            if (c == 3) {   
                var button = document.createElement('button');
                var icon = document.createElement('i');
                icon.setAttribute('class', 'fa fa-trash');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-link btn-danger btn-just-icon destroy');
                button.setAttribute('onclick', 'removeRow(this),calc()');
                td.appendChild(button).appendChild(icon);
                
            }else if(c == 2){


                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'total[]');
                ele.setAttribute('readonly', 'readonly');
                ele.classList.add('form-control','total');
                td.appendChild(ele);
            
            }else if(c == 1){
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'count[]');
                ele.setAttribute('max', '99999');
                ele.setAttribute('min', '1');
                ele.setAttribute('step', '1');
                ele.setAttribute('value', '');
                ele.setAttribute('required', 'required');
                ele.setAttribute('oninvalid', "setCustomValidity('   محتوى الوحدة مطلوب ولا يتجاوز 5 ارقام')");
                ele.setAttribute('onchange', "try{setCustomValidity('')}catch(e){}");
                ele.setAttribute('oninput', "calc()");
                ele.classList.add('form-control','count');
                td.appendChild(ele);
            }else if(c == 0){
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'package_number[]');
                ele.setAttribute('max', '99999');
                ele.setAttribute('min', '1');
                ele.setAttribute('step', '1');
                ele.setAttribute('value', '');
                ele.setAttribute('required', 'required');
                ele.setAttribute('oninvalid', "setCustomValidity('    عدد الاكياس مطلوب ولا يتجاوز 5 ارقام')");
                ele.setAttribute('onchange', "try{setCustomValidity('')}catch(e){}");
                ele.setAttribute('oninput', "calc()");
                ele.classList.add('form-control','package_number');
                td.appendChild(ele);
            }

        }
    }

    function removeRow(oButton) {
        var empTab = document.getElementById('empTable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); 
    }

    function calc(){
        var package_number = document.getElementsByClassName("package_number");
        var count = document.getElementsByClassName("count");
        var grandtotal = 0;
        for (let index = 0; index < count.length; index++) {
            document.getElementsByClassName("total")[index].value=package_number[index].value * count[index].value;
            grandtotal += package_number[index].value * count[index].value;
        }
        document.getElementById('grandtotal').value=grandtotal

    }

    calc()

</script>