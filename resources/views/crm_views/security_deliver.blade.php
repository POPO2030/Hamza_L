@extends('layouts.app')

@section('title')
    {{__('تسليم الامن')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-truck"></i> تسليم الامن</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
               <!-- Category Id Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('barcode', 'باركود: <span style="color: red">*</span>', [], false) !!}
                {{-- {!! Form::text('barcode', null, ['class' => 'form-control','id'=>'barcode','autofocus']) !!} --}}
                {!! Form::text('barcode', null, ['class' => 'form-control' . ($errors->has('barcode') ? ' is-invalid' : ''),'id'=>'barcode','autofocus','required']) !!}
                @if ($errors->has('barcode'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('barcode') }}</strong>
                </span>
            @endif
            </div>

                <form method="post" action="{{URL('add_security_deliver_order')}}" onsubmit="return validateTableData()" id="create">
                
                @csrf
                <div style="position: relative;">
            <table class="table table-striped" id="tab">
            <tr>
                <td>الغسلة</td>
                <td>اذن التسليم</td>
                <td>عدد الاكياس</td>
                <td>عدد القطع</td>
                <td>الاجمالى</td>
                <td>حذف</td>
                </tr>
            </table>
            <span id="validationMessage" style="color: red;"></span>
        </div>
            <button type="submit" class="btn btn-primary save">حفظ</button>
            </form>
                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
<script src="{{URL('datatables_js/jquery-3.6.0.min.js')}}"></script>
<script>
    $( document ).ready(function() {
        $(document).on('input','#barcode',function(){

            var tableHeaderRowCount = 1;
            var table = document.getElementById('tab');
            var rowCount = table.rows.length;

            var barcode = $(this).val()
            $.ajax({
           type:'get',
           url:"{!!URL::to('/add_security_deliver')!!}",
           data:{'barcode':barcode},
           success:function(result){
            console.log(result)

                var tr = document.createElement('tr');

                var td= document.createElement('td');
                var ele = document.createElement('input');
                ele.setAttribute('type', 'hidden');
                ele.setAttribute('name', 'barcode[]');
                ele.setAttribute('value', result.barcode);
                td.innerText=result.get_order.id
                td.appendChild(ele)
                tr.appendChild(td)

                var td0= document.createElement('td');
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'deliver_order_id[]');
                ele.setAttribute('readonly', 'readonly');
                ele.setAttribute('value', result.deliver_order_id);
                ele.classList.add('form-control');
                td0.appendChild(ele);
                tr.appendChild(td0)


                var td1= document.createElement('td');
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'package_number[]');
                ele.setAttribute('readonly', 'readonly');
                ele.setAttribute('value', '1');
                ele.classList.add('form-control');
                td1.appendChild(ele);
                tr.appendChild(td1)

                var td2= document.createElement('td');
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'count[]');
                ele.setAttribute('readonly', 'readonly');
                ele.setAttribute('value', result.count);
                ele.classList.add('form-control');
                td2.appendChild(ele);
                tr.appendChild(td2)

                var td3= document.createElement('td');
                var ele = document.createElement('input');
                ele.setAttribute('type', 'number');
                ele.setAttribute('name', 'total[]');
                ele.setAttribute('readonly', 'readonly');
                ele.setAttribute('value', result.count);
                ele.classList.add('form-control');
                td3.appendChild(ele);
                tr.appendChild(td3)

                var td4= document.createElement('td');
                var button = document.createElement('button');
                var icon = document.createElement('i');
                icon.setAttribute('class', 'fa fa-trash');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-link btn-danger btn-just-icon destroy');
                button.setAttribute('onclick', 'removeRow(this)');
                td4.appendChild(button).appendChild(icon);
                tr.appendChild(td4)

                document.getElementById('tab').appendChild(tr);;
                  // Show success message
                //   alert('تنبيه...تم التسليم بنجاح');
        }
        
        })
        $(this).val('')
        })
        function removeRow(oButton) {
        var empTab = document.getElementById('empTable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); 
    }

    // ================================================
    $(document).on('keyup', function(e) {
        // f2
  if (e.key == "F2") $('.save').click();
});


    })



    function validateTableData() {
        var table = document.getElementById("tab");
        var rows = table.getElementsByTagName("tr");

        if (rows.length <= 1) {
            var validationMessage = document.getElementById("validationMessage");
            validationMessage.innerText = "يجب إضافة بيانات إلى الجدول قبل الحفظ.";
            return false; // Prevent form submission
        }else{
            var button = document.querySelector('.btn.btn-primary.save');
         button.disabled = true;
        }

        // If validation passes, you can submit the form
        return true;
    }

</script>
