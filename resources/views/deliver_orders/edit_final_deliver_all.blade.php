@extends('layouts.app')

@section('title')
    {{__('تعديل إذن تسليم مجمع')}}
@endsection

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @foreach ($deliverOrders as $delivers)
                    @endforeach
                    {{-- @if (count($delivers)) --}}
                    <h1><i class="fas fa-truck"></i>  تعديل إذن تسليم مجمع &nbsp; &nbsp; ( {{ $delivers->get_customer->name }} )</h1>
                    {{-- @else --}}
                    {{-- <h1><i class="fas fa-truck"></i>  تعديل إذن تسليم مجمع </h1> --}}
                    {{-- @endif --}}
                    
                  
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-left"
                       href="{{ route('final_deliver_orders') }}">
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

<form action="{{URL('update_final_deliver_all')}}" method="post" style="width:100%">      
    @csrf  

    @foreach ($deliverOrders as $delivers)
       
        @foreach ($delivers->get_final_deliver as $final_details )
    
        @endforeach
            {{-- @if ($details->package_number - $details->delivered_package > 0) --}}
            @foreach ($delivers->get_details as $details )
<div class="row">

<!-- WorkOrder Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('work_order_id', 'رقم الغسلة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('work_order_id', $delivers->work_order_id, ['class' => 'form-control', 'id' => 'work_order_id', 'style' => 'width: 100%', 'required', 'readonly']) }}
    {{ Form::hidden('work_order_id',$delivers->work_order_id,null,['class'=> 'form-control','id'=>'work_order_id', 'style'=>"width: 100%",'required','readonly'],['option'=>'delivers']) }}
</div>

<!-- Receipt Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('receipt_id', $delivers->receipt_id, ['class' => 'form-control', 'id' => 'receipts', 'style' => 'width: 100%', 'required', 'readonly']) }}
    {{ Form::hidden('receipt_id',$delivers->receipt_id,null,['class'=> 'form-control','id'=>'receipts','style'=>"width: 100%",'required' ,'readonly','onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'delivers']) }}
</div>

<!-- Product Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_id', $delivers->get_products->name, ['class' => 'form-control', 'id' => 'products', 'style' => 'width: 100%', 'required', 'readonly']) }}
    {{ Form::hidden('product_id',$delivers->get_products->id,null,['class'=> 'form-control','id'=>'products','style'=>"width: 100%",'required','readonly' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'delivers']) }}
</div>

<!-- Receive Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('receive_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('receive_id', $delivers->get_receivable->name, ['class' => 'form-control', 'id' => 'receive_id', 'style' => 'width: 100%', 'required', 'readonly']) }}
    {{ Form::hidden('receive_id',$delivers->get_receivable->id,null,['class'=> 'form-control','id'=>'receive_id', 'style'=>"width: 100%",'required','readonly'],['option'=>'delivers']) }}
</div>



</div>
<div class="row" style="margin:3rem 0;width:100%">
   
                <table id="empTable" class="table table-boreder" style="border:1.5px solid gray;width:100%">
                    
                    <tr>
                    <td>عدد الاكياس</td>
                    <td>عدد القطع</td>
                    <td>الاجمالى</td>
                    <td>تم التسليم (كيس)</td>
                    <td>المتبقى</td>
                    <td>تسليم</td>
                    </tr>
                    
                   
                    
                        <tr>
                            <td>
                                <input type="hidden" value="{{$details->id}}" name="id[]">
                                <input value="{{$details->package_number}}" name="package_number[]" id="package_number" style="outline: none; background-color: transparent;border: none;" readonly>
                                
                            </td>
                            <td> 
                                <input value="{{$details->count}}" name="count[]" id="count" style="outline: none; background-color: transparent;border: none;" readonly>
                            </td>
                           
                            <td> 
                                <input value="{{$details->total}}" name="total[]" id="total" style="outline: none; background-color: transparent;border: none;" readonly>
                            </td>
                            <td>{{$details->delivered_package}}</td>                     <!-----------تم تسليم--------->
                            
                            <td class="remian">{{$details->package_number - $details->delivered_package }}</td>
    
                            <td>
                                <input type="number" name="delivered_package[]" class="delivered-input" value="{{ $details->delivered_package }}">
                                <span class="error-message"></span>
                            </td>
                            
                            <td><input type="hidden" name="deliver_order_id[]" value=" {{ $details->deliver_order_id }}" readonly> </td>
                               <td> 
                                 <input type="hidden" name="final_deliver_order_id[]" class="serial-input" value="{{$final_details->final_deliver_order_id}}" readonly>
                            </td>
                            
    
                        </tr>
                       
                </table>
            </div>
                    {{-- @endif --}}
                    
                    @endforeach
            @endforeach 

                {!! Form::button('جهة التسليم', ['class' => 'btn btn-primary'  ,'data-toggle'=>'modal' ,'data-target'=>'#modal-default']) !!} &nbsp; &nbsp;
                {{-- {!! Form::button('تسليم الكل', ['class' => 'btn btn-primary' ,'data-toggle'=>'modal' ,'data-target'=>'#modal-default']) !!} --}}
    

</div>



            </div>
        </div>
    </div>
    

    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اختر جهة التسليم</h5>
      
        </div>
        <div class="modal-body">
            <div class="form-group col-sm-12">
            {!! Form::label('receivable_id', 'تسليم إلى :') !!}
            {{ Form::select('receivable_id', $receive_id, null, ['class' => 'form-control searchable', 'data-placeholder' => 'اختر المستلم', 'style' => 'width: 100%']) }}
            {{-- {{ Form::select('receivable_id',$receive_id,null,['class'=> 'form-control', 'style'=>"width: 100%;height: 38px; font-size: medium;",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receivable_id']) }} --}}

            {{-- {{ Form::hidden('finalDeliver_id', $delivers->final_deliver_order_id, null, ['class' => 'form-control', 'style' => 'width: 100%']) }} --}}
        </div>
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal" >إلغاء</button> &nbsp; &nbsp;
        <button type="submit"  id = 'all' class="btn btn-primary">تسليم الكل</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
        </div>
        </div>
      </form>

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
