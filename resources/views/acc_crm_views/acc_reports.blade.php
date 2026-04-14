@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقرير الحسابات</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" action="{{URL('accfollowup_report')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
               <!-- Category Id Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('stage_id', 'مراحل الانتاج:') !!}
                <select name="stage_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($stages as $stage)
                        <option value="{{$stage->id}}">{{$stage->name}}</option>
                    @endforeach
                </select>
            </div>
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
                {!! Form::label('place_id', 'المكان:') !!}
                <select name="place_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($places as $place)
                        <option value="{{$place->id}}">{{$place->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('service_id', 'اللون:') !!}
                <select name="service_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($services as $service)
                        <option value="{{$service->id}}">{{$service->name}}</option>
                    @endforeach
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
            <div class="form-group col-sm-4">
            {!! Form::label('to', 'الحالة:') !!}
                <select name="status" id="status" class="form-control searchable">
                    <option value="open">قيد التنفيذ</option>
                    <option value="closed">تم التنفيذ</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
            </div>
            <div class="form-group col-sm-4">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>
            

           
                {{-- <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div> --}}
            </div>

        
        </div>
</form>
    </div>

@endsection
