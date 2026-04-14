@extends('layouts.app')

@section('title')
    {{__('تقارير مخزن الجاهز')}}
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقارير مخزن الجاهز</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" action="{{URL('readyfollowup_report')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
               <!-- Category Id Field -->

            <div class="form-group col-sm-4">
            {!! Form::label('customer_id', ' العميل:') !!}
                <select name="customer_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('workorder_id', 'الغسلة:') !!}
                <select name="workorder_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($work_orders as $work_order)
                        <option value="{{$work_order->id}}">{{$work_order->id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('recepit_id', ' اذن اضافة:') !!}
                <select name="recepit_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($recepits as $recepit)
                        <option value="{{$recepit->id}}">{{$recepit->id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('final_deliver_order_id', ' اذن التسليم:') !!}
                <select name="final_deliver_order_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($final_deliver_orders as $final_deliver)
                        <option value="{{$final_deliver->final_deliver_order_id}}">{{$final_deliver->final_deliver_order_id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('receivable_id', 'المستلم:') !!}
                <select name="receivable_id" class="form-control searchable">
                <option value="all" selected>الكل</option>

                 @foreach($receivables as $receivable)
                <option value="{{$receivable->id}}">{{$receivable->name}}</option>
                 @endforeach
                </select>
            </div>


          

      

            <div class="form-group col-sm-4">
            {!! Form::label('to', 'الحالة:') !!}
                <select name="status" id="status" class="form-control searchable">
                    <option value="open">داخل المخزن</option>
                    <option value="closed">تم التسليم</option>
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control searchable ','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control searchable ','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>

            {{-- <div class="form-group col-sm-4">
            {!! Form::label('residual', 'البواقى:') !!}
                <select name="residual" id="residual" class="form-control searchable">
                    <option value="not_residual">بدون</option>
                    <option value="residual">بواقى</option>
                </select>
            </div> --}}

         
            <div class="form-group col-sm-4"></div>
           

            <div class="form-group col-sm-4">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>


            </div>

        
        </div>
</form>
    </div>

@endsection


