@extends('layouts.app')


@section('title')
    {{__('متابعة الانتاج')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>متابعة الانتاج</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
               <!-- Category Id Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('work_oreder_id', ' رقم الغسلة:') !!}
                {{ Form::select('work_oreder_id',$work_oreder_id,null,['placeholder' => 'اختر مرحلة','class'=> 'form-control searchable ','id'=>'work_oreder_id', 'data-placeholder'=>"اختر الغسلة", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('يجب اختيار مجموعه المنتجات')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'work_oreder_id']) }}
            </div>

            <table class="table table-striped" id="tab">
                <tr>
                    <th>رقم الغسلة</th>
                    <th>التاريخ</th>
                    <th>عرض</th>
                </tr>
            </table>
                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>

    $( document ).ready(function() {
        $(document).on('change','#work_oreder_id',function(){

            var tableHeaderRowCount = 1;
            var table = document.getElementById('tab');
            var rowCount = table.rows.length;
            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                table.deleteRow(tableHeaderRowCount);
            }

            var id = $(this).val()
            $.ajax({
           type:'get',
           url:"{!!URL::to('/get_wo_followup')!!}",
           data:{'id':id},
           success:function(result){
            console.log(result)
            for(row of result){
                var tr = document.createElement('tr');

                var td1= document.createElement('td');
                td1.innerText = row.work_order_id
                tr.appendChild(td1)

                var td2= document.createElement('td');
                td2.innerText = row.created_at
                tr.appendChild(td2)

                var td3= document.createElement('td');
                var button = document.createElement('a');
                var icon = document.createElement('i');
                icon.setAttribute('class', 'fa fa-eye');
                button.setAttribute('class', 'btn btn-xs');
                button.setAttribute('href', 'workOrders/'+row.work_order_id);
                td3.appendChild(button).appendChild(icon);
                tr.appendChild(td3)
                document.getElementById('tab').appendChild(tr);;
            }
            

        }
        })
        })
    })
</script>