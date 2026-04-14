@extends('layouts.app')

@section('title')
    {{__('تقرير الموديل بالكامل')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i>  تقرير الموديل بالكامل </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('models_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
       
            <div class="form-group col-sm-4">
                {!! Form::label('recepit_id', ' اذن اضافة:') !!}
                <select name="recepit_id" id="recepit_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($recepits as $recepit)
                        <option value="{{$recepit->id}}">{{$recepit->id}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('model', ' الموديل:') !!}
                <select name="model" id="model" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($models as $model)
                        <option value="{{$model->model}}">{{$model->model}}</option>
                    @endforeach
                </select>
            </div>
 

            <div class="form-group col-sm-4">
                {!! Form::label('customer_id', ' العميل:') !!}
                <select name="customer_id" id="customer_id" class="form-control searchable">
                   
                </select>
            </div>

            {{-- <div class="form-group col-sm-4">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control searchable ','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control searchable ','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div> --}}

            <div class="form-group col-sm-4">
                
            </div>
            <div class="form-group col-sm-4">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
                {{-- <button onclick="add_id({{ $recepit->id }})" class="btn btn-primary open-ready-modal col-12" data-toggle="modal" data-target="#modal-default">بحث</button> --}}
                {{-- {!! Form::button('بحث', ['class' => 'btn btn-info btn-lg'  ,'data-toggle'=>'modal' ,'data-target'=>'#modal-default']) !!} --}}
            </div>

           
              

                    </div>
                </div>
            </div>

        
        </div>
</form>
    </div>







   
    






@endsection


    <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
    <script>
        $( document ).ready(function() {

    $(document).on('change','#model',function(){
    var model=$(this).val();

    $.ajax({
    type:'get',
    url:"{!!URL::to('/get_customers_for_model')!!}",
    data:{'model':model},
    success:function(result){
        console.log(result)
        customer_id
        if(result.length > 1){
        // Add the default option "اختر العميل"
        var defaultOption = document.createElement("option");
        defaultOption.text = "اختر العميل";
        defaultOption.value = "";
        document.getElementById("customer_id").appendChild(defaultOption);
        
        for (let index = 0; index < result.length; index++) {
            op=document.createElement("option");
            op.innerText=result[index].name
            op.value=result[index].id
            // op.setAttribute('selected', 'selected');
            document.getElementById("customer_id").append(op)
        }
        }else{
            for (let index = 0; index < result.length; index++) {
            op=document.createElement("option");
            op.innerText=result[index].name
            op.value=result[index].id
            op.setAttribute('selected', 'selected');
            document.getElementById("customer_id").append(op)
        }
        }
        
    }
    })
    })

    $(document).on('change','#recepit_id',function(){
    var recepit_id=$(this).val();

    $.ajax({
    type:'get',
    url:"{!!URL::to('/get_customers_for_recepit_id')!!}",
    data:{'recepit_id':recepit_id},
    success:function(result){
        console.log(result)
        customer_id
        // // Add the default option "اختر العميل"
        // var defaultOption = document.createElement("option");
        // defaultOption.text = "اختر العميل";
        // defaultOption.value = "";
        // document.getElementById("customer_id").appendChild(defaultOption);
        
        for (let index = 0; index < result.length; index++) {
            op=document.createElement("option");
            op.innerText=result[index].name
            op.value=result[index].id
            op.setAttribute('selected', 'selected');
            document.getElementById("customer_id").append(op)
        }
    }
    })
    })

    });
    </script>


