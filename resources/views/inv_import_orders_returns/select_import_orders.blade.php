@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('تحديداذن مرتجع بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-clipboard-check"></i>
            تحديداذن مرتجع بضاعه  
        </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary btn-sm float-left"
                       href="{{ route('invImportOrders_Returns.index') }}">
                        عوده
                    </a>
                </div>
            </div>
        </div>
</section>

<div class="content px-3">
    <div class="card">
        {!! Form::open(['route' => 'invImportOrdersReturns.create','id'=>'create']) !!}
        <div class="card-body">
            <div class="row">
          
                <!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'كود اذن اضافة بضاعه: <span style="color: red">*</span>', [], false) !!}
                <select name="invimport_id" class="form-control invimport_id searchable">
                    @foreach($importorders_customers as $importorder)
                        <option value="{{$importorder->id}}">
                            {{$importorder->get_customer->name .'-'.$importorder->id}}
                        </option>
                    @endforeach
                </select>

</div>

            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit('بحث', ['class' => 'btn btn-primary btn-sm save']) !!}
            <a href="{{ route('invImportOrders_Returns.index') }}" class="btn btn-default btn-sm">الغاء</a>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection