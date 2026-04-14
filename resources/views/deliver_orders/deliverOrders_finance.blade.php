@extends('layouts.app')

@section('title')
    {{__('إذن التسليم')}}
@endsection

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-truck"></i> إذن التسليم</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('workOrders.index') }}">
                        عودة
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

    @include('flash::message')

        <div class="card">

           

            <div class="card-body">

                @push('page_scripts')
                <script type="text/javascript">
                    $('#date_in').datetimepicker({
                        format: 'YYYY-MM-DD HH:mm:ss',
                        useCurrent: true,
                        sideBySide: true
                    })
                </script>
            @endpush

<div class="row">
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('customer_id',$customer_data,null,['class'=> 'form-control','id'=>'customer_id','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customer_data']) }}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receipt_id',$receipt_data,null,['class'=> 'form-control','id'=>'receipts','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receipt_data']) }}
</div>

<!-- Product Id Field -->

<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('product_id',$product_data,null,['class'=> 'form-control','id'=>'products','style'=>"width: 100%",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'product_data']) }}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_type',$product_type,['class'=> 'form-control','id'=>'product_type','style'=>"width: 100%;",'required','readonly']) }}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('work_order_id', 'رقم الغسلة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('work_order_id',$work_order_data,null,['class'=> 'form-control','id'=>'work_order_id', 'style'=>"width: 100%",'required'],['option'=>'work_order_data']) }}
</div>

<!-- Receive Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receive_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receive_id',$receive_data,null,['class'=> 'form-control','id'=>'receive_id', 'style'=>"width: 100%",'required'],['option'=>'receive_data']) }}
</div>

<!-- Product_Count Field -->
<div class="form-group col-sm-3">
    {!! Form::label('product_count', 'كمية الغسلة:') !!}
    <p style="text-align: center; font-size: x-large" >
    <span class="badge badge-success" id="product_count" name="product_count">{{$ready_packages[0]->get_count_product->product_count}}</span></p>
    {{-- <input value="{{$ready_packages[0]->get_count_product->product_count}}" name="product_count" id="product_count" style="outline: none; background-color: transparent;border: none; text-align:center; color:darkred; " readonly> --}}
</div>

</div>


<div class="row" style="margin:3rem 0;width:100%">
<form action="{{URL('update_delivered_package')}}" method="Post" style="width:100%">
    @csrf
  

            <table id="empTable" class="table table-boreder" style="border:1.5px solid gray;width:100%">
                <tr>
                <td>عدد الاكياس</td>
                <td>عدد القطع</td>
                <td>الاجمالى</td>
                <td>تم التسليم (كيس)</td>
                <td>المتبقى</td>
                <td>تسليم</td>
                </tr>
                @foreach($ready_packages as $ready_package)
                @foreach($ready_package->get_details as $row)
                @if ($row->package_number - $row->delivered_package > 0)
                    <tr>
                        <td>
                            <input type="hidden" value="{{$row->id}}" name="id[]">
                            <input value="{{$row->package_number}}" id="package_number" style="outline: none; background-color: transparent;border: none;" readonly>
                            
                        </td>
                        <td> 
                            <input value="{{$row->count}}" name="count[]" id="count" style="outline: none; background-color: transparent;border: none;" readonly>
                        </td>
                       
                        <td> 
                            <input value="{{$row->total}}" name="total[]" id="total" style="outline: none; background-color: transparent;border: none;" readonly>
                        </td>
                        <td>{{$row->delivered_package}}</td>
                        
                        <td class="remian">{{$row->package_number - $row->delivered_package}}</td>

                     
                        <td>
                            <input type="number" min=1 name="delivered_package[]" class="delivered-input">
                            <span class="error-message"></span>
                        </td>
                        
                        <td><input type="hidden" name="deliver_order_id[]" value=" {{ $ready_package->id }}" readonly> </td>
                           <td> 
                             <input type="hidden" name="final_deliver_order_id[]" class="serial-input" value="{{$finalDeliver_id}}" readonly>

                        </td>

                    </tr>
                  
          
                    @endif
                @endforeach
                @endforeach
            </table>

            {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
            {!! Form::submit('تسليم الكل', ['class' => 'btn btn-primary', 'id' => 'all']) !!}

</form>
</div>

            </div>
        </div>
    </div>
    

@endsection

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>

<script>

  // Set the readOnly property to true
  document.getElementById('package_number').readOnly = true;
  document.getElementById('count').readOnly = true;
  document.getElementById('total').readOnly = true;


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



<script>
    $(document).ready(function() {
  $("#all").click(function(event) {
    event.preventDefault();
    $(".remian").each(function() {
      var remaining = parseInt($(this).text()); // جلب قيمه remian
      var deliveredInput = $(this).closest("tr").find(".delivered-input");
      if (remaining > 0) {
      if (deliveredInput.val() === '') {
        deliveredInput.val(remaining); // .delivered-inputتغير قيمه
      }
      $(this).closest("form").submit();
    } else {
        // Display the error message
        $(this).closest("tr").find(".error-message").html("عفوًا... لا يوجد كميات للتسليم").css({
          "color": "red",
          "font-weight": "bold"
        });
  // Clear the inputs
//   deliveredInput.val('');

// Display the error message
deliveredInput.after(errorMessageSpan);

// Stop the code execution
return false
        
      }

    });
  });
});


    </script>
